<?php
session_start();
include_once "linkedin.php";
require_once('../OAuthenticate.php');

$config['base_url']             =   'http://html2pdf.givanov.eu/oauth/linkedin/auth.php';
$config['callback_url']         =   'http://html2pdf.givanov.eu/oauth/linkedin/login-callback.php';
$config['linkedin_access']      =   '775m9wk8a8m8o1';
$config['linkedin_secret']      =   'kko33Nq8vMhBuYdV';

# First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
$linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );
//$linkedin->debug = true;

if (isset($_REQUEST['oauth_verifier'])){
    $_SESSION['oauth_verifier']     = $_REQUEST['oauth_verifier'];

    $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
    $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
    $linkedin->getAccessToken($_REQUEST['oauth_verifier']);

    $_SESSION['oauth_access_token'] = serialize($linkedin->access_token);
    header("Location: " . $config['callback_url']);
    exit;
}
else{
    $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
    $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
    $linkedin->access_token     =   unserialize($_SESSION['oauth_access_token']);
}

$profile      = json_decode($linkedin->getProfile("~:(id,first-name,last-name,email-address)?format=json"), true);

$oauth 		    = new OAuthenticate();
$oauth->register($profile['firstName'],$profile['lastName'],$profile['emailAddress'], $profile['id'] );

header('location: ./../../dashboard.php');
exit;