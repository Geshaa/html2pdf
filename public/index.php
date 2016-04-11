<?php 
//	include 'config.php';
//require_once('Core.php');
//$core = Core::getInstance();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>html2pdf</title>
	<link rel="stylesheet" href="assets/front/css/style.css">
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
	<!-- Delete livereload.js on production -->
	<script src="http://localhost:35755/livereload.js"></script>
</body>
</html>
