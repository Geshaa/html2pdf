<?php header("Access-Control-Allow-Origin: *"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>html2pdf</title>
	<link rel="stylesheet" href="assets/front/css/style.css">

	<!-- Linked oauth-->
<!--	<script type="text/javascript" src="//platform.linkedin.com/in.js">-->
<!--		api_key:   775m9wk8a8m8o1-->
<!--		onLoad: onLinkedInLoad-->
<!--		authorize: false-->
<!--	</script>-->
</head>
<body>
	<section class="formHolder loginHolder active">
		<form method="post" name="loginForm">
			<h1>Login details</h1>
			<div>
				<input type="email" required name="email" placeholder="Email">
			</div>
			<div>
				<input type="password" required name="password" placeholder="****">
			</div>
			<div class="formHolder__buttons">
				<span class="openForm" data-open="registerHolder">Register</span>
				<button type="submit" class="btn"><span>Submit</span></button>
			</div>
			<div class="formHolder__loginSocial">
				<div class="fb-login-button" data-scope="public_profile,email" data-share="true"  data-width="450" data-show-faces="true" onlogin="checkLoginState();"></div>
				<div>
<!--					<script type="in/Login"></script>-->
					<a href="https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id=775m9wk8a8m8o1&https%3A%2F%2Fhtml2pdf.givanov.eu/dashboard.php&state=98765EeFWf45A53sdfKef4233&scope=r_basicprofile r_emailaddress">
						<img src="./images/linkedin_connect_button.png" alt="Sign in with LinkedIn"/>
					</a>
				</div>
			</div>
			<p class="formHolder__message">Invalid username or password</p>
		</form>
	</section>
	<section class="formHolder registerHolder">
		<form method="post" name="registerForm">
			<h1>Register details</h1>
			<div>
				<input type="text" name="regFirstName" placeholder="First name" required>
			</div>
			<div>
				<input type="text" name="regLastName" placeholder="Last name" required>
			</div>
			<div>
				<input type="email" name="regEmail" placeholder="Email" required>
			</div>
			<div>
				<input type="password" name="regPassword" placeholder="Password" required>
			</div>
			<div class="formHolder__buttons">
				<span class="openForm" data-open="loginHolder">Login</span>
				<button type="submit" class="btn"><span>register</span></button>
			</div>
			<p class="formHolder__message">This email address is already taken.</p>
		</form>
	</section>

	<script src="assets/front/js/scripts.js"></script>
	<script src="oauth/facebook/fb.js" type="text/javascript"></script>

<!--	<script type="text/javascript">-->
<!---->
<!--		// Setup an event listener to make an API call once auth is complete-->
<!--		function onLinkedInLoad() {-->
<!--			IN.Event.on(IN, "auth", getProfileData);-->
<!--		}-->
<!---->
<!--		// Handle the successful return from the API call-->
<!--		function onSuccess(data) {-->
<!--			console.log(data);-->
<!--		}-->
<!---->
<!--		// Handle an error response from the API call-->
<!--		function onError(error) {-->
<!--			console.log(error);-->
<!--		}-->
<!---->
<!--		// Use the API call wrapper to request the member's basic profile data-->
<!--		function getProfileData() {-->
<!--			IN.API.Profile("me").fields("first-name", "last-name", "email-address", "id").result(onSuccess).error(onError);-->
<!--		}-->
<!--	</script>-->

	<!-- Delete livereload.js on production -->
	<script src="http://localhost:35755/livereload.js"></script>
</body>
</html>
