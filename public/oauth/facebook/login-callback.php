<?php
session_start();
require_once __DIR__ . '/Facebook/autoload.php';
require_once('../OAuthenticate.php');


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

    $oauth 		    = new OAuthenticate();
    $oauth->register($profile['first_name'],$profile['last_name'],$profile['email'], $profile['id'] );

    header('location: ./../../dashboard.php');
    exit;
} 
else {
    echo "Unauthorized access!!!";
    exit;
}
