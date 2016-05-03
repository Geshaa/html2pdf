<?php
require_once('../Core.php');

class Authenticate {

	public function login() {
		$core = Core::getInstance();

		$email 		= $_POST['email'];
		$password 	= $_POST['password'];
		$logged 	= false;

		$statement = $core->dbh->prepare("SELECT id, email, password, userLevel from users WHERE email = :email");
		$statement->bindParam(':email', $email);
		$statement->execute();

		$results = $statement->fetch(PDO::FETCH_ASSOC);

		if( count($results) > 0 && password_verify($password, $results['password']) ) {
			session_start();
			$_SESSION['userID'] = $results['id'];
			echo $results['userLevel'];
		}
		else {
			echo -1;
		}
	}

	public function logout() {

		session_start();

		if(isset($_SESSION['userID']))
			unset($_SESSION['userID']);

		session_destroy();

		echo 'destroy';
	}

	public function register() {
		$core = Core::getInstance();

		$firstName 		= $_POST['regFirstName'];
		$lastName 		= $_POST['regLastName'];
		$email 			= $_POST['regEmail'];
		$password 		= $_POST['regPassword'];

		$statement = $core->dbh->prepare("SELECT COUNT(id) from users WHERE email = :email");
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
	}
}

$user = new Authenticate();

switch($_POST['mode']) {

	case 'login':
		$user->login();
		break;
	case 'logout':
		$user->logout();
		break;
	case 'logout':
		$user->register();
		break;
}

?>