<?php
	include 'config.php';

	$userID = $_POST['userID'];
	
	$statement = $db->prepare("DELETE from users WHERE id = :id");
	$statement->bindParam(':id', $userID);
	$statement->execute();
?>