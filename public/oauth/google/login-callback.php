<?php
session_start();
require_once('../../Core.php');


//if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
//    $_SESSION['oauth_status'] = 'oldtoken';
//    header('Location: destroy.php');
//} else {

$core         = Core::getInstance();
$firstName    = $_POST['first_name'];
$lastName     = $_POST['last_name'];
$email        = $_POST['email'];
$password     = $_POST['accessToken'];

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
    $stm = $core->dbh->prepare("INSERT INTO users(firstName, lastName, email, password, accessToken) VALUES ( :firstName, :lastName, :email, :password, :accessToken)");
    $stm->bindParam(':firstName', $firstName);
    $stm->bindParam(':lastName', $lastName);
    $stm->bindParam(':email', $email);
    $stm->bindParam(':password', $hash);
    $stm->bindParam(':accessToken', $password);
    $stm->execute();

    $statement = $core->dbh->prepare("SELECT id from users WHERE email = :email");
    $statement->bindParam(':email', $email);
    $statement->execute();

    $results = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['userID'] = $results['id'];
}

