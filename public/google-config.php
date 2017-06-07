<?php
session_start();

//Include Google client library 
//include_once 'src/contrib/Google_Oauth2Service.php';
require_once '../vendor/autoload.php';

/*
 * Configuration and setup Google API
 */
define('APPLICATION_NAME', 'Google Calendar API PHP Quickstart');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
define('CREDENTIALS_PATH', '~/.credentials/calendar.json');
define('REDIRECT_URL', 'http://localhost/');

define('SCOPES', implode(' ', array(
  Google_Service_Calendar::CALENDAR_READONLY)
));

//Call Google API
$client = new Google_Client();
$client->setAccessType('offline');
$client->setApplicationName(APPLICATION_NAME);
$client->setAuthConfig(CLIENT_SECRET_PATH);
$client->setRedirectUri(REDIRECT_URL);
$client->setScopes(SCOPES);
$client->addScope("https://www.googleapis.com/auth/userinfo.email");

$authUrl = $client->createAuthUrl();
$plus = new Google_Service_Plus($client);
$calendar = new Google_Service_Calendar($client);


//$google_oauthV2 = new Google_Oauth2Service($gClient);
?>