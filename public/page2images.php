<?php
//Restful API key here.
$apikey = "349b169c99a2d555";
$api_url = "http://api.page2images.com/restfullink";

//It is the simplest way to call it. Of cause, you can remove it as needed.
call_p2i_with_callback();

// curl to connect server
function connect($url, $para)
{
    if (empty($para)) {
        return false;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($para));
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function call_p2i_with_callback()
{
    global $apikey, $api_url;
    // URL can be those formats: http://www.google.com https://google.com google.com and www.google.com
    $url = "http://www.abv.bg";  //replace with actual address when site is ready
    // 0 - iPhone4, 1 - iPhone5, 2 - Android, 3 - WinPhone, 4 - iPad, 5 - Android Pad, 6 - Desktop
    $device = 6;

    // you can pass us any parameters you like. We will pass it back.
    // Please make sure http://your_server_domain/api_callback can handle our call
    $callback_url = "http://your_server_domain/api_callback?image_id=your_unique_image_id_here";
    $para = array(
                "p2i_url" => $url,
                "p2i_key" => $apikey,
                "p2i_device" => $device
            );
    $response = connect($api_url, $para);

    if (empty($response)) {
        // Do whatever you think is right to handle the exception.
    } else {
        $json_data = json_decode($response);
        if (empty($json_data->status)) {
            // api error do something
            echo "api error";
        }else
        {
            //do anything
            $b64image = base64_encode(file_get_contents($json_data->image_url));
            echo $json_data->status;

            $src = 'data: image/png;base64,'.$b64image;
            // Echo out a sample image
            echo '<img src="'.$src.'">';
        }
    }

}

