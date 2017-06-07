<?php
//Include GP config file
include_once 'google-config.php';

//Unset token and user data from session
unset($_SESSION['token']);
unset($_SESSION['user_data']);

//Reset OAuth access token
$client->revokeToken();

//Destroy entire session
session_destroy();

//Redirect to homepage
header("Location:index.php");
?>