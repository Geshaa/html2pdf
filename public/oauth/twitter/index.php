<?php
/**
 * Create instance of TwiiterLoginApi object
 */

session_start();
require_once('oauth/twitteroauth.php');
require_once('twitter_class.php');

if (isset($_GET['connect']) && $_GET['connect'] == 'twitter') {
	$objTwitterApi 	= new TwitterLoginAPI;
	$return 		= $objTwitterApi->login_twitter($_GET['connect']);

	if( $return['error'] ) {
		echo $return['error'];
	} else {
		header('location:'.$return['url']);
		exit;
	}
}

?>
 
