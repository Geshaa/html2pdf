<?php 
	include 'config.php';

	session_start();
	if( ! (isset($_SESSION['userID']) && $_SESSION['userID'] != '') ){
	    header ("Location: index.php");
	}
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
	<header class="head">
		<div class="wrapper">
			<span id="logOutButton" class="btn">Log out</span>
			<ul>
				<li><a href="#">view generated PDF</a></li>
				<li><a href="#">send PDF vie email</a></li>
			</ul>
		</div>
	</header>
	<main>
		<div class="wrapper dashboard">
			<div class="pdfSOurce">
				<div>
					<label for="cssSource">Enter CSS source</label>
					<textarea name="cssSource" id="cssSource" rows="10"></textarea>
				</div>
				<div>
					<label for="cssSource">Enter CSS source</label>
					<textarea name="cssSource" id="cssSource" rows="10"></textarea>
				</div>
				<div>
					<span id="generatePdf" class="btn">Generate pdf</span>
				</div>
			</div>
			<div class="uploadFile">
				<input type="file" name="uploadPdf">
			</div>
		</div>
	</main>

	<script src="assets/front/js/scripts.js"></script>
	<!-- Delete livereload.js on production -->
	<script src="http://localhost:35755/livereload.js"></script>
</body>
</html>
