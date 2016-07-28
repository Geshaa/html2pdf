<?php
session_start();
require_once __DIR__.'/../Core.php';

class OAuthenticate {
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $accessToken;
    private $core;

    public function register($firstName, $lastName, $email, $password, $accessToken = NULL) {
        $this->core 		= Core::getInstance();

        $this->firstName    = $firstName;
        $this->lastName     = $lastName;
        $this->email        = $email;
        $this->password     = $password;
        $this->accessToken  = $accessToken;

        $statement = $this->core->dbh->prepare("SELECT COUNT(id) from users WHERE email = :email");
        $statement->bindParam(':email', $this->email);
        $statement->execute();

        $count = $statement->fetchColumn();

        if ( $count === "1") {
            $statement = $this->core->dbh->prepare("SELECT id from users WHERE email = :email");
            $statement->bindParam(':email', $this->email);
            $statement->execute();

            $results = $statement->fetch(PDO::FETCH_ASSOC);
            $_SESSION['userID'] = $results['id'];
        }
        else {
            $hash = password_hash($this->password, PASSWORD_DEFAULT);
            $stm = $this->core->dbh->prepare("INSERT INTO users(firstName, lastName, email, password, accessToken) VALUES ( :firstName, :lastName, :email, :password, :accessToken)");
            $stm->bindParam(':firstName', $this->firstName);
            $stm->bindParam(':lastName', $this->lastName);
            $stm->bindParam(':email', $this->email);
            $stm->bindParam(':password', $hash);
            $stm->bindParam(':accessToken', $this->accessToken);
            $stm->execute();

            $statement = $this->core->dbh->prepare("SELECT id from users WHERE email = :email");
            $statement->bindParam(':email', $this->email);
            $statement->execute();

            $results = $statement->fetch(PDO::FETCH_ASSOC);
            $_SESSION['userID'] = $results['id'];
            $_SESSION['accessToken'] = $this->accessToken;
        }
    }



}
