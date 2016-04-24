<?php
    include 'config.php';
    session_start();

    $statement = $db->prepare("SELECT id, htmlSource, cssSource, dateCreated, photo from pdf WHERE user_id = :userID");
    $statement->bindParam(':userID', $_SESSION['userID']);
    $statement->execute();

    if ($statement) {
    	$results = $statement->fetchAll(PDO::FETCH_ASSOC);
    	echo json_encode($results);
    }
    else {
    	echo -1;
    }

?>

