<?php 
	include 'config.php';
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
	<section class="formHolder">
		<form method="post" name="loginForm">
			<div>
				<input type="email" required name="email" placeholder="Email">
			</div>
			<div>
				<input type="password" required name="password" placeholder="****">
			</div>
			<div>
				<input type="submit" value="Submit">
			</div>
		</form>
	</section>
	
	<script src="assets/front/js/scripts.js"></script>
	<!-- Delete livereload.js on production -->
	<script src="http://localhost:35755/livereload.js"></script>
</body>
</html>
