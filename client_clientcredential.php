<?php

/**
 * Copyright MITRE 2017
 *
 * OpenIDConnectClient for PHP7
 * Original author: Michael Jett <mjett@mitre.org>
 * Work appended by: Otto Rask <ojrask@gmail.com>
 * Work appended by: Kristopher Doyen <kristopher.doyen@gmail.com>
 * Work appended by: Hnin Aye Khine <hninakhine@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once(__DIR__ . '/vendor/autoload.php');

use OpenIdConnectClient\OpenIdConnectClient;

$identiyServer4BaseUrl = 'http://myproviderURL.com';

$oidc = new \OpenIdConnectClient\OpenIdConnectClient([
        'provider_url' => $identiyServer4BaseUrl,
        'client_id' => 'ClientIDHere',
        'client_secret' => 'ClientSecretHere'
    ]);

$oidc->setProviderConfigParams([
    'token_endpoint' => $identiyServer4BaseUrl . '/connect/token',
    'introspection_endpoint' => $identiyServer4BaseUrl . '/connect/introspect',
    'jwks_uri' => $identiyServer4BaseUrl . '/.well-known/openid-configuration/jwks',
    'authorization_endpoint' => $identiyServer4BaseUrl . '/connect/authorize',
    'userinfo_endpoint' => $identiyServer4BaseUrl . '/connect/userinfo',
    'end_session_endpoint' => $identiyServer4BaseUrl . '/connect/endsession',
    'check_session_iframe' => $identiyServer4BaseUrl . '/connect/checksession',
    'revocation_endpoint' => $identiyServer4BaseUrl . '/connect/revocation',
]);

$oidc->addScopes(['api']);


// This assumes success (to validate check if the access_token
// property is there and a valid JWT):
//$clientCredentialsToken = $oidc->requestClientCredentialsToken()->access_token;
$clientCredentialsToken = $oidc->requestClientCredentialsToken();
var_dump($clientCredentialsToken);

$accessToken = $clientCredentialsToken->access_token;

echo "<br/>Access Token: " . $clientCredentialsToken->access_token;
echo "<br/>Client ID: " . $oidc->getClientId();
echo "<br/>Client Secret: " . $oidc->getClientSecret();

// Access Token Validation
$oidc->setApiName('APINameHere');
$oidc->setApiSecret('APISecretHere');
$isValid = $oidc->introspectToken($clientCredentialsToken->access_token, $clientCredentialsToken->token_type);
echo "<br/>Introspected Token: ";
var_dump($isValid);