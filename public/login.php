<?php 
	include 'config.php';

	$email = $_POST['email'];
	$password = $_POST['password'];
	$logged = false;

	$statement = $db->prepare("SELECT id, email, password from users WHERE email = :email");
	$statement->bindParam(':email', $email);
	$statement->execute();

	$results = $statement->fetch(PDO::FETCH_ASSOC);

	if( count($results) > 0 && password_verify($password, $results['password']) ) {
		session_start();
		$_SESSION['userID'] = $results['id'];
		echo 1;
	}
	else {
		echo 0;
	}

?>