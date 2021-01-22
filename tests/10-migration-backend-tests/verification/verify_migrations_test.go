package main

import (
	"encoding/json"
	"errors"
	"fmt"
	"github.com/stretchr/testify/assert"
	"io/ioutil"
	"net/http"
	"os"
	"path/filepath"
	"testing"
)

const (
	// The name of the directory under 'tests/' that contains all the resources (test source code, migration csv, expected test results).
	// If this directory is renamed or moved, this constant must be updated.  See also `findExpectedJson(...)` and its
	// assumptions of the directory structure that are underneath the TestBaseDir.
	// TODO: consult env?
	TestBasedir = "10-migration-backend-tests"

	// The base URL of the test instance of IDC.
	// TODO: consult env
	DrupalBaseurl = "https://islandora-idc.traefik.me"
)

// Verifies that the Person migrated by testcafe persons-01.csv and persons-02.csv match the expected fields and
// values present in taxonomy-person-01.json
func Test_VerifyTaxonomyTerm(t *testing.T) {
	expectedJson := ExpectedPerson{}
	unmarshalJson(t, "taxonomy-person-01.json", &expectedJson)

	// sanity check the expected json
	assert.Equal(t, "taxonomy_term", expectedJson.Type)
	assert.Equal(t, "person", expectedJson.Bundle)
	assert.Equal(t, "Ansel", expectedJson.FirstName)
	assert.Equal(t, "Wikidata", expectedJson.Authority[0].Name)

	u := &JsonApiUrl{
		t:            t,
		baseUrl:      DrupalBaseurl,
		drupalEntity: expectedJson.Type,
		drupalBundle: expectedJson.Bundle,
		filter:       "name",
		value:        fmt.Sprintf("%s %s", expectedJson.FirstName, expectedJson.LastName),
	}

	// retrieve json of the migrated entity from the jsonapi and unmarshal the single response
	res, body := getResource(t, u.String())
	defer func() { _ = res.Close }()
	data := unmarshalSingleResponse(t, body, res)

	// for each field in expected json,
	//   see if the expected field matches the actual field from retrieved json
	//   resolve relationships if required
	//     - required for schema:knows
	actual := data.JsonApiData[0]
	assert.Equal(t, expectedJson.Type, actual.Type.entity())
	assert.Equal(t, expectedJson.Bundle, actual.Type.bundle())
	assert.Equal(t, expectedJson.Title, actual.JsonApiAttributes.PreferredNameTitle[0])
	assert.Equal(t, fmt.Sprintf("%s %s", expectedJson.FirstName, expectedJson.MiddleName), actual.JsonApiAttributes.PreferredNameGiven[0])
	assert.Equal(t, expectedJson.LastName, actual.JsonApiAttributes.PreferredNameFamily)
	assert.Equal(t, expectedJson.Born, actual.JsonApiAttributes.Dates[0])
	assert.Equal(t, expectedJson.Died, actual.JsonApiAttributes.Dates[1])
	assert.Equal(t, expectedJson.Authority[0].Uri, actual.JsonApiAttributes.Authority[0].Uri)
	assert.Equal(t, expectedJson.Authority[0].Type, actual.JsonApiAttributes.Authority[0].Source)
	assert.Equal(t, expectedJson.Authority[0].Name, actual.JsonApiAttributes.Authority[0].Title)
	assert.True(t, len(actual.JsonApiAttributes.Description.Processed) > 0)
	assert.True(t, len(actual.JsonApiAttributes.Description.Value) > 0)
	assert.Equal(t, "basic_html", actual.JsonApiAttributes.Description.Format)

	// Resolve relationship to a name
	assert.Equal(t, 1, len(actual.JsonApiRelationships.Relationships.Data))
	relData := actual.JsonApiRelationships.Relationships.Data[0]
	assert.Equal(t, "schema:knows", relData.Meta["rel_type"])
	u.value = expectedJson.Knows[0]

	// retrieve json of the resolved entity from the jsonapi
	res, body = getResource(t, u.String())
	defer func() { _ = res.Close }()
	data = unmarshalSingleResponse(t, body, res)
	relSchemaKnows := data.JsonApiData[0]

	// sanity
	assert.Equal(t, relSchemaKnows.Type.bundle(), "person")
	assert.Equal(t, relSchemaKnows.Type.entity(), "taxonomy_term")

	// test
	assert.Equal(t, expectedJson.Knows[0], relSchemaKnows.JsonApiAttributes.Name)
}

func Test_VerifyCollection(t *testing.T) {

}

func Test_VerifyRepositoryItem(t *testing.T) {

}

func Test_VerifyMediaAndFile(t *testing.T) {

}

// Searches the file system for the named file.  The `name` should not contain any path components or separators.
//
// This function allows for an IDE to discover test resources while allowing for IDC test framework (the one invoked by
// `make test`) to discover those same resources without hard coding paths.  Instead, this function makes some
// assumptions about where tests are invoked from, and the directory structure underneath the TestBaseDir.
func findExpectedJson(t *testing.T, name string) string {
	// the resolved json file, including its path relative to the working directory.
	var expectedJsonFile string

	// attempt to discover TestBaseDir from the current working directory, which will work if we are invoked by the
	// IDC 'make test' target.
	filepath.Walk(".", func(path string, info os.FileInfo, err error) error {
		assert.Nil(t, err)
		// Resolve the expected json file relative to TestBaseDir (note the assumptions made about the directory structure)
		if info.IsDir() && info.Name() == TestBasedir {
			expectedJsonFile = filepath.Join(path, "verification", "expected", name)
			return errors.New(fmt.Sprintf("Found test basedir %s", path))
		}
		return nil
	})

	if expectedJsonFile != "" {
		return expectedJsonFile
	}

	// if the TestBaseDir is not found, that means we are probably being invoked from within that directory (e.g. by an
	// IDE or CLI)
	filepath.Walk(".", func(path string, info os.FileInfo, err error) error {
		assert.Nil(t, err)
		// Resolve the json file relative to the directory name `expected` (note the assumptions made about the directory
		// structure)
		if info.IsDir() && info.Name() == "expected" {
			expectedJsonFile = filepath.Join(path, name)
			return errors.New(fmt.Sprintf("Found test basedir %s", path))
		}
		return nil
	})

	assert.NotNil(t, expectedJsonFile)
	assert.NotEmpty(t, expectedJsonFile)
	return expectedJsonFile
}

// Locates the JSON file referenced by 'filename' and unmarshals it into the provided 'value'.  Any errors encountered
// will fail the test.
//
// Note that 'filename' should not contain any path components.  It is resolved to a path by
// findExpectedJson(...)
func unmarshalJson(t *testing.T, filename string, value interface{}) {
	expectedJsonFile := findExpectedJson(t, filename)
	expectedFile, err := os.Open(expectedJsonFile)
	defer func() { expectedFile.Close() }()
	assert.Nil(t, err, "Error opening file %s: %s", expectedJsonFile, err)

	// read expected json from file
	err = json.NewDecoder(expectedFile).Decode(value)
	assert.Nil(t, err, "Error decoding the content of file %s as JSON: %s", expectedJsonFile, err)
}

// Unmarshal a JSONAPI response body and assert that exactly one data element is present
func unmarshalSingleResponse(t *testing.T, body []byte, res *http.Response) *JsonApiPerson {
	data := &JsonApiPerson{}
	err := json.Unmarshal(body, data)
	assert.Nil(t, err, "Error unmarshaling JSONAPI response body: %s", err)
	assert.Equal(t, 1, len(data.JsonApiData), "Exactly one JSONAPI data element is expected in the response, but found %d element(s)", len(data.JsonApiData))
	return data
}

// Successfully GET the content at the URL and return the response and body.
func getResource(t *testing.T, u string) (*http.Response, []byte) {
	res, err := http.Get(u)
	assert.Nil(t, err, "encountered error requesting %s: %s", u, err)
	assert.Equal(t, 200, res.StatusCode, "%d status encountered when requesting %s", res.StatusCode, u)
	body, err := ioutil.ReadAll(res.Body)
	assert.Nil(t, err, "error encountered reading response body from %s: %s", u, err)
	return res, body
}
