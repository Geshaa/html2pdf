<?php
header("Access-Control-Allow-Origin: *");

if(isset($_GET['code'])) // get code after authorization
{
    $url = 'https://www.linkedin.com/uas/oauth2/accessToken';
    $param = 'grant_type=authorization_code&code='.$_GET['code'].'&redirect_uri=kko33Nq8vMhBuYdV&client_id=775m9wk8a8m8o1&client_secret=kko33Nq8vMhBuYdV';
//    $return = (json_decode(curl($url,$param),true)); // Request for access token

    if($return['error']) // if invalid output error
    {
        $content = 'Some error occured<br><br>'.$return['error_description'].'<br><br>Please Try again.';
    }
    else // token received successfully
    {
        $url = 'https://api.linkedin.com/v1/people/~:(id,firstName,lastName,pictureUrls::(original),headline,publicProfileUrl,location,industry,positions,email-address)?format=json&oauth2_access_token='.$return['access_token'];
//        $User = json_decode(curl($url)); // Request user information on received token

        var_dump($User);
    }
}

?>