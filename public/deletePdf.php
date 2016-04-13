<?php
	include 'config.php';

	$id = $_POST['id'];
	
	$statement = $db->prepare("DELETE from pdf WHERE id = :id");
	$statement->bindParam(':id', $id);
	$statement->execute();
?>