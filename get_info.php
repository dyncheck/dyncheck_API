<?php
#--------------Edit only this----------------
//Set API key
$api_key = "34836cf96c6d5b98b5fce482942761895c0df4f9";

//Set API url
$url_get_info = "https://dyncheck.com/api/get_info";
#--------------------------------------------
//File ID
$file_id = $argv[1];



//Generate JSON paramethres data
$param_data = json_encode([
	'api' => $api_key,
	'file_id' => $file_id
	]);

// Initialise the curl request
$ch = curl_init($url_get_info);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    array(
        'data' => $param_data
    ));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Output the response
$response_str = curl_exec($ch);
$response_obj = json_decode($response_str);

echo $response_str;

// close the session
curl_close($ch);