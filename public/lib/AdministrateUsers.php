<?php
require_once('../Core.php');

class AdministrateUsers {

	public function listAll() {
		$core = Core::getInstance();

		$statement = $core->dbh->prepare("SELECT id, firstName, lastName, email from users");
		$statement->execute();

		$results = $statement->fetchAll(PDO::FETCH_ASSOC);

	    echo json_encode($results);
	}

	public function delete() {
		$core = Core::getInstance();

		$userID = $_POST['userID'];
		
		$statement = $core->dbh->prepare("DELETE from users WHERE id = :id");
		$statement->bindParam(':id', $userID);
		$statement->execute();
	}

	public function update() {
		$core = Core::getInstance();

		$sql = "UPDATE users SET firstName = :firstName, 
            lastName = :lastName, 
            password = :password  
            WHERE id = :userID";
		$stmt = $core->dbh->prepare($sql);                                  
		$stmt->bindParam(':firstName', $_POST['firstName']);       
		$stmt->bindParam(':lastName', $_POST['lastName']);    
		$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT) );
		$stmt->bindParam(':userID', $_POST['userID']);
		 
		$stmt->execute(); 
	}
}

$admin = new AdministrateUsers();

switch($_POST['mode']) {

	case 'list':
		$admin->listAll();
		break;
	case 'delete':
		$admin->delete();
		break;
	case 'update':
		$admin->update();
		break;
}

?>