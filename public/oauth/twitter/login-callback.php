<?php
session_start();
require_once('oauth/twitteroauth.php');
require_once('twitter_class.php');
require_once('../../Core.php');


if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: destroy.php');
} else {
	$objTwitterApi = new TwitterLoginAPI;
	$connection = $objTwitterApi->twitter_callback();

	if( $connection == 'connected') {

		$objTwitterApi 	= new TwitterLoginAPI;
		$return 		= $objTwitterApi->view();

		$core         = Core::getInstance();

		$firstName    = $return['first_name'];
		$lastName     = $return['last_name'];;
		$email        = $return['email'];
		$password     = $return['id'];

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
		}

		header('location: ./../../dashboard.php');
	} else {
		header('Location: ./../../index.php');
		exit;
	}
}
