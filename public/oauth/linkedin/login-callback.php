<?php
session_start();

$config['base_url']             =   'http://html2pdf.givanov.eu/oauth/linkedin/auth.php';
$config['callback_url']         =   'http://html2pdf.givanov.eu/oauth/linkedin/login-callback.php';
$config['linkedin_access']      =   '775m9wk8a8m8o1';
$config['linkedin_secret']      =   'kko33Nq8vMhBuYdV';

include_once "linkedin.php";
require_once('../../Core.php');

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
$core         = Core::getInstance();

$firstName    = $profile['firstName'];
$lastName     = $profile['lastName'];;
$email        = $profile['emailAddress'];
$password     = $profile['id'];

$statement = $core->dbh->prepare("SELECT COUNT(id) from users WHERE email = :email");
$statement->bindParam(':email', $email);
$statement->execute();

$count = $statement->fetchColumn();

if ( $count === "1") {
    $statement = $core->dbh->prepare("SELECT id from users WHERE email = :email");
    $statement->bindParam(':email', $email);
    $statement->execute();

    $results = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['userID'] = $results['id'];
}
else {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stm = $core->dbh->prepare("INSERT INTO users(firstName, lastName, email, password) VALUES ( :firstName, :lastName, :email, :password)");
    $stm->bindParam(':firstName', $firstName);
    $stm->bindParam(':lastName', $lastName);
    $stm->bindParam(':email', $email);
    $stm->bindParam(':password', $hash);
    $stm->execute(); 

    $statement = $core->dbh->prepare("SELECT id from users WHERE email = :email");
    $statement->bindParam(':email', $email);
    $statement->execute();

    $results = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['userID'] = $results['id'];
    // $_SESSION['accessToken'] = $linkedin->access_token;
}

header('location: ./../../dashboard.php');
exit;
