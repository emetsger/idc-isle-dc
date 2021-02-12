package main

import (
	"encoding/json"
	"fmt"
	"github.com/stretchr/testify/assert"
	"log"
	"net/url"
	"strings"
	"testing"
)

// Encapsulates the relevant components of a URL which executes a JSON API request against Drupal
type JsonApiUrl struct {
	t            assert.TestingT
	baseUrl      string
	drupalEntity string
	drupalBundle string
	filter       string
	value        string
}

// Compose and return the JSONAPI URL
func (json *JsonApiUrl) String() string {
	var u *url.URL
	var err error

	assert.NotEmpty(json.t, json.baseUrl, "error generating a JsonAPI URL from %v: %s", json, "base url must not be empty")
	assert.NotEmpty(json.t, json.drupalEntity, "error generating a JsonAPI URL from %v: %s", json, "drupal entity must not be empty")
	assert.NotEmpty(json.t, json.drupalBundle, "error generating a JsonAPI URL from %v: %s", json, "drupal bundle must not be empty")

	u, err = url.Parse(fmt.Sprintf("%s", strings.Join([]string{DrupalBaseurl, "jsonapi", json.drupalEntity, json.drupalBundle}, "/")))
	assert.Nil(json.t, err, "error generating a JsonAPI URL from %v: %s", json, err)

	if json.filter != "" {
		u, err = url.Parse(fmt.Sprintf("%s?filter[%s]=%s", u.String(), json.filter, json.value))
	}

	assert.Nil(json.t, err, "error generating a JsonAPI URL from %v: %s", json, err)
	return u.String()
}

func (jar *JsonApiUrl) get(v interface{}) {
	// retrieve json of the migrated entity from the jsonapi and unmarshal the single response
	res, body := getResource(jar.t.(*testing.T), jar.String())
	defer func() { _ = res.Close }()
	unmarshalSingleResponse(jar.t.(*testing.T), body, res, &JsonApiResponse{}).to(v)
}

// Encapsulates a generic JSON API response
type JsonApiResponse struct {
	Data []map[string]interface{}
}

// Handles the case where the 'data' key contains an array of objects, or a single object.
func (jar *JsonApiResponse) UnmarshalJSON(b []byte) error {
	fullRes := make(map[string]interface{})

	if err := json.Unmarshal(b, &fullRes); err != nil {
		return err
	}

	if e, ok := fullRes["data"]; !ok {
		return fmt.Errorf("missing 'data' key when unmarshaling JSONAPI response: %v", e)
	} else {
		switch e.(type) {
		case []interface{}:
			jar.Data = make([]map[string]interface{}, len(e.([]interface{})))
			for i, v := range e.([]interface{}) {
				jar.Data[i] = v.(map[string]interface{})
			}
		case map[string]interface{}:
			jar.Data = make([]map[string]interface{}, 1)
			jar.Data[0] = e.(map[string]interface{})
		default:
			return fmt.Errorf("unable to determine type of JSONAPI key 'data': %v", e)
		}
	}
	return nil
}

// Adapts the generic JsonApiResponse to a higher-fidelity type
func (jar *JsonApiResponse) to(v interface{}) {
	if b, e := json.Marshal(jar); e != nil {
		log.Fatalf("Unable to marshal %v as json: %s", jar, e)
	} else {
		json.Unmarshal(b, v)
	}
}

type JsonApiData struct {
	Type DrupalType
	Id   string
}

func (jad *JsonApiData) resolve(t *testing.T, v interface{}) {
	u := JsonApiUrl{
		t:            t,
		baseUrl:      DrupalBaseurl,
		drupalEntity: jad.Type.entity(),
		drupalBundle: jad.Type.bundle(),
		filter:       "id",
		value:        jad.Id,
	}

	u.get(v)
}

// Represents the results of a JSONAPI query for a single Person from the Person Taxonomy
type JsonApiPerson struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Name        string
			Dates       []string `json:"field_date"`
			Description struct {
				Value     string
				Format    string
				Processed string
			}
			PrimaryPartOfName       string   `json:"field_primary_part_of_name"`
			PreferredNamePrefix     []string `json:"field_preferred_name_prefix"`
			PreferredNameRest       []string `json:"field_preferred_name_rest"`
			PreferredNameSuffix     []string `json:"field_preferred_name_suffix"`
			PreferredNameFullerForm []string `json:"field_preferred_name_fuller_form"`
			PreferredNameNumber     []string `json:"field_preferred_name_number"`
			AltNameFullerForm       []string `json:"field_alt_name_fuller_form"`
			AltNameNumber           []string `json:"field_alt_name_number"`
			AltNamePrefix           []string `json:"field_alt_name_prefix"`
			AltNameSuffix           []string `json:"field_alt_name_suffix"`
			AltPreferredNameRest    []string `json:"field_alt_preferred_name_rest"`
			AltPrimaryPartOfName    []string `json:"field_alt_primary_part_of_name"`
			Authority               []struct {
				Uri    string
				Title  string
				Source string
			} `json:"field_authority_link"`
		} `json:"attributes"`
		JsonApiRelationships struct {
			Relationships struct {
				Data []struct {
					JsonApiData
					Meta map[string]string
				}
			} `json:"field_relationships"`
		} `json:"relationships"`
	} `json:"data"`
}

// Represents the results of a JSONAPI query for a single Access Rights Taxonomy Term
type JsonApiAccessRights struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Name        string
			Description struct {
				Value     string
				Format    string
				Processed string
			}
			Authority []struct {
				Uri    string
				Title  string
				Source string
			} `json:"field_authority_link"`
		} `json:"attributes"`
	} `json:"data"`
}

// Represents the results of a JSONAPI query for a single Copyright and Use Taxonomy Term
type JsonApiCopyrightAndUse struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Name        string
			Description struct {
				Value     string
				Format    string
				Processed string
			}
			Authority []struct {
				Uri    string
				Title  string
				Source string
			} `json:"field_authority_link"`
		} `json:"attributes"`
	} `json:"data"`
}

// Represents the results of a JSONAPI query for a single Family Taxonomy Term
type JsonApiFamily struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Name        string
			Date        []string `json:"field_date"`
			FamilyName  string   `json:"field_family_name"`
			Title       string   `json:"field_title_and_other_words"`
			Description struct {
				Value     string
				Format    string
				Processed string
			}
			Authority []struct {
				Uri    string
				Title  string
				Source string
			} `json:"field_authority_link"`
		} `json:"attributes"`
		JsonApiRelationships struct {
			Relationships struct {
				Data []struct {
					JsonApiData
					Meta map[string]string
				}
			} `json:"field_relationships"`
		} `json:"relationships"`
	} `json:"data"`
}

// Represents the results of a JSONAPI query for a single collection entity
type JsonApiCollection struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Title       string
			Description struct {
				Value    string
				LangCode string
			}
			ContactEmail     string   `json:"field_collection_contact_email"`
			ContactName      string   `json:"field_collection_contact_name"`
			CollectionNumber []string `json:"field_collection_number"`
			FindingAid       []struct {
				Uri   string
				Title string
			} `json:"field_finding_aid"`
		} `json:"attributes"`
		JsonApiRelationships struct {
			AltTitle struct {
				Data  []JsonApiLanguageValue
				Links struct {
					Related struct {
						Href string
					}
				}
			} `json:"field_alternative_title"`
			TitleLanguage struct {
				Data  JsonApiLanguageValue
				Links struct {
					Related struct {
						Href string
					}
				}
			} `json:"field_title_language"`
			Description struct {
				Data []JsonApiLanguageValue
			} `json:"field_description"`
			MemberOf struct {
				Data []struct {
					JsonApiData
				}
			} `json:"field_member_of"`
		} `json:"relationships"`
	} `json:"data"`
}

// Represents the results of a JSONAPI query for a single islandora object
type JsonApiIslandoraObj struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Title             string
			CollectionNumber  []string
			DateAvailable     string   `json:"field_date_available"`
			DateCopyrighted   []string `json:"field_date_copyrighted"`
			DateCreated       []string `json:"field_date_created"`
			DatePublished     []string `json:"field_date_published"`
			DigitalIdentifier []string `json:"field_digital_identifier"`
			DspaceIdentifier  struct {
				Uri   string
				Title string
			} `json:"field_dspace_identifier"`
			DspaceItemid string `json:"field_dspace_item_id"`
			Description  string
			Extent       []string `json:"field_extent"`
			FindingAid   []struct {
				Uri   string
				Title string
			}
			GeoportalLink struct {
				Uri   string
				Title string
			}
			// TODO
			IsPartOf    string
			Issn        string
			ItemBarcode string
			JhirUri     struct {
				Uri   string
				Title string
			}
			LibraryCatalogLink struct {
				Uri   string
				Title string
			}
		} `json:"attributes"`
		JsonApiRelationships struct {
			Abstract struct {
				Data []JsonApiLanguageValue
			} `json:"field_abstract"`
			AccessRights struct {
				Data []JsonApiData
			} `json:"field_access_rights"`
			// TODO
			AccessTerms struct {
				Data []JsonApiData
			} `json:"field_access_terms"`
			AltTitle struct {
				Data []JsonApiLanguageValue
			} `json:"field_alternative_title"`
			Contributor []struct {
				Data []struct {
					JsonApiData
					Meta map[string]interface{}
				}
			} `json:"field_contributor"`
			Copyright struct {
				Data JsonApiData
			} `json:"field_copyright_and_use"`
			CopyrightHolder struct {
				Data []JsonApiData
			} `json:"field_copyright_holder"`
			Creator struct {
				Data []struct {
					JsonApiData
					Meta map[string]interface{}
				}
			} `json:"field_creator"`
			Description struct {
				Data []JsonApiLanguageValue
			} `json:"field_description"`
			DigitalPublisher struct {
				Data []JsonApiData
			}
			DisplayHints JsonApiData
			Genre        struct {
				Data []JsonApiData
			}
			Language struct {
				Data []JsonApiData
			}
			Model struct {
				Data JsonApiData
			} `json:"field_model"`
			MemberOf struct {
				Data []JsonApiData
			} `json:"field_member_of"`
			Publisher struct {
				Data []JsonApiData
			} `json:"field_publisher"`
			PublisherCountry struct {
				Data []JsonApiData
			} `json:"field_publisher_country"`
			ResourceType struct {
				Data []JsonApiData
			} `json:"field_resource_type"`
			SpatialCoverage struct {
				Data []JsonApiData
			} `json:"field_spatial_coverage"`
			Subject struct {
				Data []JsonApiData
			} `json:"field_subject"`
			TableOfContents struct {
				Data []JsonApiLanguageValue
			} `json:"field_table_of_contents"`
			TitleLanguage struct {
				Data JsonApiData
			} `json:"field_title_language"`
			DisplayHint struct {
				Data JsonApiData
			} `json:"field_display_hints"`
		} `json:"relationships"`
	} `json:"data"`
}

// Represents the results of a JSONAPI query for a single Genre Term
type JsonApiGenre struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Name        string
			Description struct {
				Value     string
				Format    string
				Processed string
			}
			Authority []struct {
				Uri    string
				Title  string
				Source string
			} `json:"field_authority_link"`
		} `json:"attributes"`
	} `json:"data"`
}

// Represents the results of a JSONAPI query for a single Geolocation Term
type JsonApiGeolocation struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Name    string
			Broader []struct {
				Uri   string
				Title string
			} `json:"field_broader"`
			GeoAltName  []string `json:"field_geo_alt_name"`
			Description struct {
				Value     string
				Format    string
				Processed string
			}
			Authority []struct {
				Uri    string
				Title  string
				Source string
			} `json:"field_authority_link"`
		} `json:"attributes"`
	} `json:"data"`
}

// Represents the results of a JSONAPI query for a single Resource Types Taxonomy Term
type JsonApiResourceType struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Name        string
			Description struct {
				Value     string
				Format    string
				Processed string
			}
			Authority []struct {
				Uri    string
				Title  string
				Source string
			} `json:"field_authority_link"`
		} `json:"attributes"`
	} `json:"data"`
}

// Represents the results of a JSONAPI query for a single Subject Term
type JsonApiSubject struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Name        string
			Description struct {
				Value     string
				Format    string
				Processed string
			}
			Authority []struct {
				Uri    string
				Title  string
				Source string
			} `json:"field_authority_link"`
		} `json:"attributes"`
	} `json:"data"`
}

// Represents the results of a JSONAPI query for a single Language Taxonomy Term
type JsonApiLanguage struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Name         string
			LanguageCode string `json:"field_language_code"`
			Description  struct {
				Value     string
				Format    string
				Processed string
			}
			Authority []struct {
				Uri    string
				Title  string
				Source string
			} `json:"field_authority_link"`
		} `json:"attributes"`
	} `json:"data"`
}

// Represents an element of a JSONAPI response that encapsulates a string value and a language taxonomy entity
//
// In the following example, the objects with a type `taxonomy_term--language` are represented by this struct.
//   "field_alternative_title": {
//    "data": [
//      {
//        "type": "taxonomy_term--language",
//        "id": "7397e0c4-df0a-4800-95af-afccc6ff64a5",
//        "meta": {
//          "value": "Moonrise Over Hernandez"
//        }
//      },
//      {
//        "type": "taxonomy_term--language",
//        "id": "bacfc5b6-b4b9-4239-8744-46dca6a91f0e",
//        "meta": {
//          "value": "Salida de la luna sobre Hernández"
//        }
//      }
//    ],
//    "links": {
//      "related": {
//        "href": "http://islandora-idc.traefik.me/jsonapi/node/islandora_object/815a4c04-0be5-44f1-a876-e8ddc11dcf21/field_alternative_title?resourceVersion=id%3A48"
//      },
//      "self": {
//        "href": "http://islandora-idc.traefik.me/jsonapi/node/islandora_object/815a4c04-0be5-44f1-a876-e8ddc11dcf21/relationships/field_alternative_title?resourceVersion=id%3A48"
//      }
//    }
//  }
type JsonApiLanguageValue struct {
	JsonApiData
	Meta struct {
		Value string
	}
}

// Answers the language code of the value string by resolving the Language Taxonomy entity identified in the
// JsonApiLanguageValue
func (lv JsonApiLanguageValue) langCode(t *testing.T) string {
	jsonApiLang := JsonApiLanguage{}
	lv.resolve(t, jsonApiLang)
	return jsonApiLang.JsonApiData[0].JsonApiAttributes.LanguageCode
}

// Answers the value of the string, the language of which is provided by langCode(...)
func (lv JsonApiLanguageValue) value() string {
	return lv.Meta.Value
}

// Represents the results of a JSONAPI query for a single Corporate Body Term
type JsonApiCorporateBody struct {
	JsonApiData []struct {
		Type              DrupalType
		Id                string
		JsonApiAttributes struct {
			Name        string
			Description struct {
				Value     string
				Format    string
				Processed string
			}
			Authority []struct {
				Uri    string
				Title  string
				Source string
			} `json:"field_authority_link"`
			AltDate            string   `json:"field_alt_date_of_meeting"`
			AltLocation        string   `json:"field_alt_location_of_meeting"`
			AltNumberOrSection string   `json:"field_alt_num_of_section_or_meet"`
			AltPrimaryName     string   `json:"field_alt_primary_name"`
			AltSubordinateName string   `json:"field_alt_subordinate_name"`
			Date               []string `json:"field_date"`
			DateOfMeeting      string   `json:"field_date_of_meeting_or_treaty"`
			Location           string   `json:"field_location_of_meeting"`
			NumberOrSection    string   `json:"field_num_of_section_or_meet"`
			PrimaryName        string   `json:"field_primary_name"`
			SubordinateName    string   `json:"field_subordinate_name"`
		} `json:"attributes"`
		JsonApiRelationships struct {
			Relationships struct {
				Data []struct {
					JsonApiData
					Meta map[string]string
				}
			} `json:"field_relationships"`
		} `json:"relationships"`
	} `json:"data"`
}
