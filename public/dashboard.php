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
<body id="target">
	<header class="head">
		<div class="wrapper">
			<ul>
				<li><a href="#">view generated PDF</a></li>
				<li><a href="#">send PDF vie email</a></li>
			</ul>
			<span id="logOutButton" class="btn">Log out</span>
		</div>
	</header>
	<main>
		<div class="wrapper livepreview">
			<div id="fileDisplayArea"></div>
			<iframe id="livepreviewIframe"></iframe>
		</div>

		<div class="wrapper dashboard">
			<div class="codeSource">
				<form action="pdf-from-source.php" name="codeSource" method="POST" enctype="multipart/form-data">
					<div>
						<label for="cssSource">Enter CSS source</label>
						<textarea name="cssSource" placeholder="Paste here ONLY CSS code" id="cssSource" rows="10" required></textarea>
					</div>
					<div>
						<label for="htmlSource">Enter HTML source</label>
						<textarea name="htmlSource" placeholder="Paste here HTML Code" id="htmlSource" rows="10" required></textarea>
					</div>
					<div>
						<button type="submit" id="generatePdf" class="btn">Generate pdf</button>
					</div>
				</form>
			</div>
			<div class="fileSource">
				<form action="pdf-from-file.php" name="fileSource" method="POST" enctype="multipart/form-data">
					<label>
						<span>CSS needs to be inline in style tag.</span>
						<input type="file" name="uploadHTML" id="uploadHTML" required>
					</label>
					<button type="submit" class="btn"> Upload & Generate</button>
				</form>
			</div>
		</div>
	</main>

	<script src="assets/front/js/scripts.js"></script>

	<!-- Delete livereload.js on production -->
	<script src="http://localhost:35755/livereload.js"></script>
</body>
</html>
