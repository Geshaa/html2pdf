<?php
require_once('../Core.php');

class AdministrateUsers {
	private $core;
	private $statement;
	private $results;

	public function listAll() {
		$this->core = Core::getInstance();

		$this->statement = $this->core->dbh->prepare("SELECT id, firstName, lastName, email from users");
		$this->statement->execute();

		$this->results = $this->statement->fetchAll(PDO::FETCH_ASSOC);

	    echo json_encode($this->results);
	}

	public function delete() {
		$this->core = Core::getInstance();
		
		$this->statement = $this->core->dbh->prepare("DELETE from users WHERE id = :id");
		$this->statement->bindParam(':id', $_POST['userID']);
		$this->statement->execute();
	}

	public function update() {
		$this->core = Core::getInstance();

		$sql = "UPDATE users SET firstName = :firstName, 
            lastName = :lastName, 
            password = :password  
            WHERE id = :userID";
		$this->statement = $this->core->dbh->prepare($sql);                                  
		$this->statement->bindParam(':firstName', $_POST['firstName']);       
		$this->statement->bindParam(':lastName', $_POST['lastName']);    
		$this->statement->bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT) );
		$this->statement->bindParam(':userID', $_POST['userID']);
		 
		$this->statement->execute(); 
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