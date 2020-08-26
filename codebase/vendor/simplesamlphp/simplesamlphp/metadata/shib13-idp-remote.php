<?php

/**
 * SAML 1.1 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */

/*
$metadata['https://simplesaml.local:4443/idp/shibboleth'] = [
    'SingleSignOnService' => 'https://simplesaml.local:4443/idp/profile/Shibboleth/SSO',
    'certificate' => '/run/secrets/idp_signing_cert',
    'name' => [
        'en' => 'Shibboleth IdP (SAML 1)'
    ]
];
*/
$metadata['https://islandora-idp.traefik.me/idp/shibboleth'] = array (
  'entityid' => 'https://islandora-idp.traefik.me/idp/shibboleth',
  'contacts' =>
  array (
  ),
  'metadata-set' => 'shib13-idp-remote',
  'SingleSignOnService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:mace:shibboleth:1.0:profiles:AuthnRequest',
      'Location' => 'https://islandora-idp.traefik.me:4443/idp/profile/Shibboleth/SSO',
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://islandora-idp.traefik.me:4443/idp/profile/SAML2/POST/SSO',
    ),
    2 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
      'Location' => 'https://islandora-idp.traefik.me:4443/idp/profile/SAML2/POST-SimpleSign/SSO',
    ),
    3 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://islandora-idp.traefik.me:4443/idp/profile/SAML2/Redirect/SSO',
    ),
  ),
  'ArtifactResolutionService' =>
  array (
    0 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:1.0:bindings:SOAP-binding',
      'Location' => 'https://islandora-idp.traefik.me:4443/idp/profile/SAML1/SOAP/ArtifactResolution',
      'index' => 1,
    ),
    1 =>
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
      'Location' => 'https://islandora-idp.traefik.me:4443/idp/profile/SAML2/SOAP/ArtifactResolution',
      'index' => 2,
    ),
  ),
  'keys' =>
  array (
    0 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => '
MIIDEzCCAfugAwIBAgIUS9SuTXwsFVVG+LjOEAbLqqT/el0wDQYJKoZIhvcNAQEL
BQAwFTETMBEGA1UEAwwKaWRwdGVzdGJlZDAeFw0xNTEyMTEwMjIwMjZaFw0zNTEy
MTEwMjIwMjZaMBUxEzARBgNVBAMMCmlkcHRlc3RiZWQwggEiMA0GCSqGSIb3DQEB
AQUAA4IBDwAwggEKAoIBAQCMAoDHx8xCIfv/6QKqt9mcHYmEJ8y2dKprUbpdcOjH
YvNPIl/lHPsUyrb+Nc+q2CDeiWjVk1mWYq0UpIwpBMuw1H6+oOqr4VQRi65pin0M
SfE0MWIaFo5FPvpvoptkHD4gvREbm4swyXGMczcMRfqgalFXhUD2wz8W3XAM5Cq2
03XeJbj6TwjvKatG5XPdeUe2FBGuOO2q54L1hcIGnLMCQrg7D31lR13PJbjnJ0No
5C3k8TPuny6vJsBC03GNLNKfmrKVTdzr3VKp1uay1G3DL9314fgmbl8HA5iRQmy+
XInUU6/8NXZSF59p3ITAOvZQeZsbJjg5gGDip5OZo9YlAgMBAAGjWzBZMB0GA1Ud
DgQWBBRPlM4VkKZ0U4ec9GrIhFQl0hNbLDA4BgNVHREEMTAvggppZHB0ZXN0YmVk
hiFodHRwczovL2lkcHRlc3RiZWQvaWRwL3NoaWJib2xldGgwDQYJKoZIhvcNAQEL
BQADggEBAIZ0a1ov3my3ljJG588I/PHx+TxAWONWmpKbO9c/qI3Drxk4oRIffiac
ANxdvtabgIzrlk5gMMisD7oyqHJiWgKv5Bgctd8w3IS3lLl7wHX65mTKQRXniG98
NIjkvfrhe2eeJxecOqnDI8GOhIGCIqZUn8ShdM/yHjhQ2Mh0Hj3U0LlKvnmfGSQl
j0viGwbFCaNaIP3zc5UmCrdE5h8sWL3Fu7ILKM9RyFa2ILHrJScV9t623IcHffHP
IeaY/WtuapsrqRFxuQL9QFWN0FsRIdLmjTq+00+B/XnnKRKFBuWfjhHLF/uu8f+E
t6Lf23Kb8yD6ZR7dihMZAGHnYQ/hlhM=
                        ',
    ),
    1 =>
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => '
MIIDFDCCAfygAwIBAgIVAN3vv+b7KN5Se9m1RZsCllp/B/hdMA0GCSqGSIb3DQEB
CwUAMBUxEzARBgNVBAMMCmlkcHRlc3RiZWQwHhcNMTUxMjExMDIyMDE0WhcNMzUx
MjExMDIyMDE0WjAVMRMwEQYDVQQDDAppZHB0ZXN0YmVkMIIBIjANBgkqhkiG9w0B
AQEFAAOCAQ8AMIIBCgKCAQEAh91caeY0Q85uhaUyqFwP2bMjwMFxMzRlAoqBHd7g
u6eo4duaeLz1BaoR2XTBpNNvFR5oHH+TkKahVDGeH5+kcnIpxI8JPdsZml1srvf2
Z6dzJsulJZUdpqnngycTkGtZgEoC1vmYVky2BSAIIifmdh6s0epbHnMGLsHzMKfJ
Cb/Q6dYzRWTCPtzE2VMuQqqWgeyMr7u14x/Vqr9RPEFsgY8GIu5jzB6AyUIwrLg+
MNkv6aIdcHwxYTGL7ijfy6rSWrgBflQoYRYNEnseK0ZHgJahz4ovCag6wZAoPpBs
uYlY7lEr89Ucb6NHx3uqGMsXlDFdE4QwfDLLhCYHPvJ0uwIDAQABo1swWTAdBgNV
HQ4EFgQUAkOgED3iYdmvQEOMm6u/JmD/UTQwOAYDVR0RBDEwL4IKaWRwdGVzdGJl
ZIYhaHR0cHM6Ly9pZHB0ZXN0YmVkL2lkcC9zaGliYm9sZXRoMA0GCSqGSIb3DQEB
CwUAA4IBAQBIdd4YWlnvJjql8+zKKgmWgIY7U8DA8e6QcbAf8f8cdE33RSnjI63X
sv/y9GfmbAVAD6RIAXPFFeRYJ08GOxGI9axfNaKdlsklJ9bk4ducHqgCSWYVer3s
RQBjxyOfSTvk9YCJvdJVQRJLcCvxwKakFCsOSnV3t9OvN86Ak+fKPVB5j2fM/0fZ
Kqjn3iqgdNPTLXPsuJLJO5lITRiBa4onmVelAiCstI9PQiaEck+oAHnMTnC9JE/B
DHv3e4rwq3LznlqPw0GSd7xqNTdMDwNOWjkuOr3sGpWS8ms/ZHHXV1Vd22uPe70i
s00xrv14zLifcc8oj5DYzOhYRifRXgHX
                        ',
    ),
    2 =>
    array (
      'encryption' => true,
      'signing' => false,
      'type' => 'X509Certificate',
      'X509Certificate' => '
MIIDEzCCAfugAwIBAgIUG6Nn1rlERS1vsi88tcdzSYX0oqAwDQYJKoZIhvcNAQEL
BQAwFTETMBEGA1UEAwwKaWRwdGVzdGJlZDAeFw0xNTEyMTEwMjIwMTRaFw0zNTEy
MTEwMjIwMTRaMBUxEzARBgNVBAMMCmlkcHRlc3RiZWQwggEiMA0GCSqGSIb3DQEB
AQUAA4IBDwAwggEKAoIBAQCBXv0o3fmT8iluyLjJ4lBAVCW+ZRVyEXPYQuRi7vfD
cO4a6d1kxiJLsaK0W88VNxjFQRr8PgDkWr28vwoH1rgk4pLsszLD48DBzD942peJ
l/S6FnsIJjmaHcBh4pbNhU4yowu63iKkvttrcZAEbpEro6Z8CziWEx8sywoaYEQG
ifPkr9ORV6Cn3txq+9gMBePG41GrtZrUGIu+xrndL0Shh4Pq0eq/9MAsVlIIXEa8
9WfH8J2kFcTOfoWtIc70b7TLZQsx4YnNcnrGLSUEcstFyPLX+Xtv5SNZF89OOIxX
VNjNvgE5DbJb9hMM4UAFqI+1bo9QqtxwThjc/sOvIxzNAgMBAAGjWzBZMB0GA1Ud
DgQWBBStTyogRPuAVG6q7yPyav1uvE+7pTA4BgNVHREEMTAvggppZHB0ZXN0YmVk
hiFodHRwczovL2lkcHRlc3RiZWQvaWRwL3NoaWJib2xldGgwDQYJKoZIhvcNAQEL
BQADggEBAFMfoOv+oISGjvamq7+Y4G7ep5vxlAPeK3RATYPYvAmyH946qZXh98ni
QXyuqZW5P5eEt86toY45IwDU5r09SKwHughEe99iiEkxh0mb2qo84qX9/qcg+kyN
jeLd/OSyolpUCEFNwOFcog7pj7Eer+6AHbwTn1Mjb5TBsKwtDMJsaxPvdj0u7M5r
xL/wHkFhn1rCo2QiojzjSlV3yLTh49iTyhE3cG+RxaNKDCxhp0jSSLX1BW/ZoPA8
+PMJEA+Q0QbyRD8aJOHN5O8jGxCa/ZzcOnYVL6AsEXoDiY3vAUYh1FUonOWw0m9H
p+tGUbGS2l873J5PrsbpeKEVR/IIoKo=
                        ',
    ),
  ),
  'scope' =>
  array (
    0 => 'johnshopkins.edu',
  ),
);
