<?php
session_start();
require_once __DIR__ . '/Facebook/autoload.php';
require_once('../../Core.php');

$fb = new Facebook\Facebook([
    'app_id' => '893519327440355',
    'app_secret' => 'e59c90294bbe73e4f724f08da7620af7',
    'default_graph_version' => 'v2.6'
]);

$helper = $fb->getJavaScriptHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
}

if (isset($accessToken)) {
   $fb->setDefaultAccessToken($accessToken);

   try {

    $requestProfile = $fb->get("/me?fields=name,email, first_name, last_name, id");
    $profile = $requestProfile->getGraphNode()->asArray();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
}


// $_SESSION['email']      = $profile['email'];
// $_SESSION['first_name'] = $profile['first_name'];
// $_SESSION['last_name']  = $profile['last_name'];
// $_SESSION['id']  = $profile['id'];

$core         = Core::getInstance();

$firstName    = $profile['first_name'];
$lastName     = $profile['last_name'];;
$email        = $profile['email'];
$password     = $profile['id'];

$statement = $core->dbh->prepare("SELECT COUNT(id) from users WHERE email = :email");
$statement->bindParam(':email', $email);
$statement->execute();

$count = $statement->fetchColumn();

if ( $count === "1") {
    $statement = $core->dbh->prepare("SELECT id from users WHERE email = :email");
    $statement->bindParam(':email', $email);
    $statement->execute();

    $results = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['userID'] = $results['id'];
}
else {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stm = $core->dbh->prepare("INSERT INTO users(firstName, lastName, email, password, accessToken) VALUES ( :firstName, :lastName, :email, :password, :accessToken)");
    $stm->bindParam(':firstName', $firstName);
    $stm->bindParam(':lastName', $lastName);
    $stm->bindParam(':email', $email);
    $stm->bindParam(':password', $hash);
    $stm->bindParam(':accessToken', $accessToken);
    $stm->execute(); 

    $statement = $core->dbh->prepare("SELECT id from users WHERE email = :email");
    $statement->bindParam(':email', $email);
    $statement->execute();

    $results = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['userID'] = $results['id'];
    $_SESSION['accessToken'] = $accessToken;

    // echo $count;
}

header('location: ./../../dashboard.php');
exit;

} 
else {
    echo "Unauthorized access!!!";
    exit;
}
