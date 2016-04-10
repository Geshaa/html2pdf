<?php
	include 'config.php';

	$sql = "UPDATE users SET firstName = :firstName, 
            lastName = :lastName, 
            password = :password  
            WHERE id = :userID";
	$stmt = $db->prepare($sql);                                  
	$stmt->bindParam(':firstName', $_POST['firstName']);       
	$stmt->bindParam(':lastName', $_POST['lastName']);    
	$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT) );
	$stmt->bindParam(':userID', $_POST['userID']);
	 
	$stmt->execute(); 
	
?>