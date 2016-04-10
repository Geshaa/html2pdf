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
			<p>Administrator panel</p>
			<span id="logOutButton" class="btn">Log out</span>
		</div>
	</header>
	<main>
		<div class="wrapper listUsers">
			<table id="listAllUsers">
				<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				
				</tbody>
			</table>
		</div>
	</main>

	<div data-overlay="popup"></div>

	<div data-popup="editUserData">
        <span data-popup-close="editUserData">X</span>
        <h2>edit user data</h2>
		<form name="updateUserForm" method="post">
			<input type="hidden" name="userID" id="userID">
			<div>
				<label for="edit-first-name">First name</label>
				<input type="text" id="edit-first-name" name="firstName" placeholder="First name" required>
			</div>
			<div>
				<label for="edit-last-name">last name</label>
				<input type="text" id="edit-last-name" name="lastName" placeholder="Last name" required>
			</div>
			<div>
				<label for="edit-password-name">password</label>
				<input type="password" id="edit-password" name="password" placeholder="Password" required>
			</div>
			<div class="popup__actions">
				<button type="submit" data-user-id="" class="btn"> Save changes</button>
			</div>
		</form>
    </div>

    <div data-popup="deleteUser">
        <span data-popup-close="deleteUser">X</span>
        <h2>Are you sure you want to delete this user ?</h2>
        <div class="popup__actions">
            <a href="#" rel="nofollow" data-user-id="" class="btn" id="deleteUser" data-popup-close="deleteUser">Yes, delete</a>
        </div>
    </div>

	<script src="assets/front/js/scripts.js"></script>
	<!-- Delete livereload.js on production -->
	<script src="http://localhost:35755/livereload.js"></script>
</body>
</html>
