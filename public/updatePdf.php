<?php
	include 'config.php';

	$sql = "UPDATE pdf SET htmlSource = :htmlSource, cssSource = :cssSource WHERE id = :id";
	$stmt = $db->prepare($sql);                                  
	$stmt->bindParam(':htmlSource', $_POST['htmlSource']);       
	$stmt->bindParam(':cssSource', $_POST['cssSource']);    
	$stmt->bindParam(':id', $_POST['id']);
	 
	$stmt->execute(); 
?>