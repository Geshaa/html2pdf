<?php
/**
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
session_start();
require_once('oauth/twitteroauth.php');
require_once('twitter_class.php');

if(isset($_GET['connect']) && $_GET['connect'] == 'twitter'){
	$objTwitterApi = new TwitterLoginAPI;
	$return = $objTwitterApi->login_twitter($_GET['connect']);
	if($return['error']){
		echo $return['error'];
	}else{
		header('location:'.$return['url']);
		exit;
	}

}


?>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type"content="text/html; charset=UTF-8">
<title>How To Login With Twitter oAuth Using PHP</title>
</head>
<body>
<div class='tLink'><strong>Tutorial Link:</strong> <a href='http://www.stepblogging.com/how-to-login-with-twitter-oauth-using-php/' target='_blank'>Click Here</a></div><br/>
<div class='web'>
	<h1>How To Login With Twitter oAuth Using PHP</h1>
	<?php 
		if($_REQUEST['connected']){ 
			$objTwitterApi = new TwitterLoginAPI;
			$return = $objTwitterApi->view();

			echo 'email:'.$return['email'].'<br>';
			echo 'fname:'.$return['first_name'].'<br>';
			echo 'lname:'.$return['last_name'].'<br>';
            echo 'twitter_id:'.$return['id'].'<br>';
            echo 'name:'.$return['name'].'<br>';
			echo 'profile_image: <img src = "'.$return['profile_image_url'].'" width="100" /><br>';
			echo 'Logout: <a href="https://twitter.com/logout" target="_blank">Logout</a><br>';
	
	}else{ 
		echo '<a href="index.php?connect=twitter"><img src="./images/lighter.png" alt="Sign in with Twitter"/></a>';
	 } ?>
</div>
</body>
</html>



