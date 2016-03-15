<?php 
	include 'config.php';

	$email = $_POST['email'];
	$password = $_POST['password'];
	$logged = false;

	$statement = $db->prepare("SELECT COUNT(id) from users WHERE email = :email and password = :password ");
	$statement->bindParam(':email', $email);
	$statement->bindParam(':password', $password);
	$statement->execute();

	$count = $statement->fetchColumn();

	if ( $count === "1") {
		$stm = $db->prepare("SELECT id from users WHERE email = :email and password = :password ");
		$stm->bindParam(':email', $email);
		$stm->bindParam(':password', $password);
		$stm->execute(); 
				
		$row = $stm->fetch(PDO::FETCH_ASSOC);
		session_start();
		$_SESSION['userID'] = $row['id'];
	}

	echo $count;
?>