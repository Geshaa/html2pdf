<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="google-signin-client_id" content="97543720705-cumtct93h5qerf070jlv6bfehbf6d253.apps.googleusercontent.com">
	<title>html2pdf</title>
	<link rel="stylesheet" href="assets/front/css/style.css">
</head>
<body>
	<section class="formHolder">
		<div class="formHolder__box">
			<div class="formHolder__box__info">
				<div class="login">
					<span class="openForm">Sign in</span>
				</div>
				<div class="register">
					<span class="openForm">Sign up</span>
				</div>
			</div>
			<div class="formHolder__box__container">
				<div class="loginHolder">
					<form method="post" name="loginForm">
					<h1>Login details</h1>
					<div>
						<input type="email" required name="email" placeholder="Email">
					</div>
					<div>
						<input type="password" required name="password" placeholder="****">
					</div>
					<div class="formHolder__buttons">
						<button type="submit" class="btn"><span>Submit</span></button>
					</div>
					<div class="formHolder__loginSocial">
						<div class="fb-login-button" data-scope="public_profile,email" data-share="true"  data-width="450" data-show-faces="true" onlogin="checkLoginState();"></div>
						<div class="g-signin2" data-onsuccess="GoogleSingIn"></div>
						<div class="tw-login-button">
							<a href="/oauth/twitter/index.php?connect=twitter">
								<img src="assets/front/img/twitterButton.png" alt="Login with Twitter">
							</a>
						</div>
						<div class="in-login-button">
							<a href="oauth/linkedin/auth.php">
								<img src="assets/front/img/linkedinButton.png" alt="Sign in with LinkedIn"/>
							</a>
						</div>
					</div>
					<p class="formHolder__message">Invalid username or password</p>
				</form>
				</div>
				<div class="registerHolder">
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
							<button type="submit" class="btn"><span>register</span></button>
						</div>
						<p class="formHolder__message">This email address is already taken.</p>
					</form>
				</div>
			</div>
		</div>
	</section>

    <script src="assets/front/js/scripts.js"></script>
	<script src="oauth/facebook/fb.js" type="text/javascript"></script>

    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <!-- Delete livereload.js on production -->
	<script src="http://localhost:35755/livereload.js"></script>
</body>
</html>
