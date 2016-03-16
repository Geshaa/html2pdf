<?php 
	include 'config.php';

	$firstName 		= $_POST['regFirstName'];
	$lastName 		= $_POST['regLastName'];
	$email 			= $_POST['regEmail'];
	$password 		= $_POST['regPassword'];

	$statement = $db->prepare("SELECT COUNT(id) from users WHERE email = :email");
	$statement->bindParam(':email', $email);
	$statement->execute();

	$count = $statement->fetchColumn();

	if ( $count === "1") {
		echo $count;
	}
	else {
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$stm = $db->prepare("INSERT INTO users(firstName, lastName, email, password) VALUES ( :firstName, :lastName, :email, :password)");
		$stm->bindParam(':firstName', $firstName);
		$stm->bindParam(':lastName', $lastName);
		$stm->bindParam(':email', $email);
		$stm->bindParam(':password', $hash);
		$stm->execute(); 
		echo $count;
	}
?>