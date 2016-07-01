<?php
session_start();
require_once('oauth/twitteroauth.php');
require_once('twitter_class.php');
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: destroy.php');
}else{
	$objTwitterApi = new TwitterLoginAPI;
	$connection = $objTwitterApi->twitter_callback();
	if( $connection == 'connected'){
		header('Location: index.php?connected=Y');
		exit;
	}else{
		header('Location: index.php?connected=F');
		exit;
	}
}
