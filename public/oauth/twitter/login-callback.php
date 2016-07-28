<?php
session_start();
require_once('oauth/twitteroauth.php');
require_once('twitter_class.php');
require_once('../OAuthenticate.php');

if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: destroy.php');
} else {
	$objTwitterApi = new TwitterLoginAPI;
	$connection = $objTwitterApi->twitter_callback();

	if( $connection == 'connected') {

		$objTwitterApi 	= new TwitterLoginAPI;
		$return 		= $objTwitterApi->view();

		$oauth 		    = new OAuthenticate();
		$oauth->register($return['first_name'],$return['last_name'],$return['email'], $return['id'] );

		header('location: ./../../dashboard.php');
	} else {
		header('Location: ./../../index.php');
		exit;
	}
}
