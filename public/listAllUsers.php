<?php
	include 'config.php';

	$statement = $db->prepare("SELECT id, firstName, lastName, email from users");
	$statement->execute();

	$results = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
?>