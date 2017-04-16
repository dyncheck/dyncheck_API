<?php
#--------------Edit only this----------------
//Set API key
$api_key = "418b82e1360183ad146515f3e765411b6c6p73b4";
$inc_timeout = 60; // 60/120/180/240

//Generate JSON AUTH string
$data = json_encode([
	'api' => $api_key,

	'typ' => 'av',   // 'av' - Antivirus; 'os' - Operational system
	'engines' => ['avast'],  // You can see all avaible engines at the bottom of the file
	'allowed_ips' => ['1.1.1.1'],    // Available in whitelist connection
	'inc_timeout' => $inc_timeout, // Check dyncheck's plans page for additional information
	'connection' => 'block' // Check dyncheck's plans page for additional information
	]);

//Set API url
$url_upload = "http://dyncheck.loc/api/upload_and_scan";
#--------------------------------------------


function get_info1($api, $file_id)
{
	$url_get_info = "http://dyncheck.loc/api/get_info";

	$param_data = json_encode([
		'api' => $api_key,
		'file_id' => $file_id
		]);
	$gi = curl_init($url_get_info);
	curl_setopt($gi, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($gi, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($gi, CURLOPT_POST, true);
	curl_setopt($gi, CURLOPT_POSTFIELDS,
	    array(
	        'data' => $param_data
	    ));
	curl_setopt($gi, CURLOPT_RETURNTRANSFER, true);

	// Output the response
	$response_str = curl_exec($gi);
	$response_obj = json_decode($response_str);
	if ($response_obj->error == 'false' && $response_obj->status_check == 'processing') {
		return 'wait';
	}
	else {
		return $response_str;
	}
	curl_close($gi);
}

if (count($argv) == 0) exit;

	$cfile = curl_file_create((string)$argv[1]);
	$ch = curl_init($url_upload);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	// Send a file
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
	    array(
	        'data' => $data,
	        'fileName' => $cfile
	    ));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_str = curl_exec($ch);
	$response_obj = json_decode($response_str);
	
	if ($response_obj->error == 'false') {
		echo "\n";
		echo 'File id: ' . $response_obj->report_id . "\n";
		echo 'File: ' . $argv[1] . ' | ' . 'Scan started. Waiting for results...' . "\n \n";
		curl_close($ch);
		for ($attempt=1; $attempt < 7 ; $attempt++) { 
			$status = get_info1($api_key, $response_obj->report_id);
			if ($status == 'wait') {
				sleep(5);
			}
			else {
				echo $status;
				break;
			}
			if ($attempt == 6 ){
				echo "Scan is too long. You can track it manually by File id." . "\n";
			}
		}
		
	}
	elseif ($response_obj->error == 'true') {
	 	echo $response_obj->message;
	 	curl_close($ch);
	 }
	 else {
	 	echo "Something went wrong";
	 	curl_close($ch);
	 }
	
/*
+------------------------------------------------------------+
|                         Antiviruses                        |
+------------------------------------------------------------+
|                 Full name                |   Engine code   |
+------------------------------------------+-----------------+
| Avast Internet Security                  | avast           |
+------------------------------------------+-----------------+
| Avira Internet Security                  | avira           |
+------------------------------------------+-----------------+
| AVG Internet Security                    | avg             |
+------------------------------------------+-----------------+
| BitDefender Total Security               | bitdef          |
+------------------------------------------+-----------------+
| BullGuard Internet Security              | bullguard       |
+------------------------------------------+-----------------+
| DrWeb Total Security                     | drweb           |
+------------------------------------------+-----------------+
| Eset Smart Security                      | eset            |
+------------------------------------------+-----------------+
| Fortinet Smart Security                  | fortinet        |
+------------------------------------------+-----------------+
| F-Secure Internet Security               | fsecure         |
+------------------------------------------+-----------------+
| Kaspersky Internet Security              | kis             |
+------------------------------------------+-----------------+
| Panda Internet Security                  | panda           |
+------------------------------------------+-----------------+
| Microsoft Security Essentials            | mse             |
+------------------------------------------+-----------------+
| McAfee Internet Security                 | mcafee          |
+------------------------------------------+-----------------+
| Comodo Internet Security                 | comodo          |
+------------------------------------------+-----------------+
| Norton Internet Security                 | norton          |
+------------------------------------------+-----------------+
| Trend Micro Internet Security            | trendmicro      |
+------------------------------------------+-----------------+
| Zone Alarm Extreme Security              | zonealarm       |
+------------------------------------------+-----------------+
| 360 Total Security                       | baidu360        |
+------------------------------------------+-----------------+
| Malwarebytes Anti-Malware                | malwarebytes    |
+------------------------------------------+-----------------+
| Sophos Anti-Virus                        | sophos          |
+------------------------------------------+-----------------+
| G Data Internet Security                 | gdata           |
+------------------------------------------+-----------------+
| TrustPort Internet Security              | trustport       |
+------------------------------------------+-----------------+
| Symantec Endpoint Protection             | symantec        |
+------------------------------------------+-----------------+
| Clam Anti-Virus                          | clam            |
+------------------------------------------+-----------------+
| Norman Security Suite                    | norman          |
+------------------------------------------+-----------------+
| Emsisoft Internet Security               | emsisoft        |
+------------------------------------------+-----------------+
| Webroot SecureAnywhere Internet Security | webroot         |
+------------------------------------------+-----------------+
| Quick Heal Total Security                | qheal           |
+------------------------------------------+-----------------+
| K7 Total Security                        | k7              |
+------------------------------------------+-----------------+
| McAfee Total Protection 2017             | mcafeetotalprot |
+------------------------------------------+-----------------+
| VIPRE Internet Security                  | vipre           |
+------------------------------------------+-----------------+
| Outpost Security Suite PRO               | outpost         |
+------------------------------------------+-----------------+
| AhnLab V3 Internet Security              | ahnlab          |
+------------------------------------------+-----------------+
| Zillya! Internet Security                | zillya          |
+------------------------------------------+-----------------+
| Ad-Aware Total Security                  | adaware         |
+------------------------------------------+-----------------+


+---------------------------------------+
|          Operational systems          |
+---------------------------------------+
|        Full name       |  Engine code |
+------------------------+--------------+
| Windows XP SP3 x32     | xpsp3x32     |
+------------------------+--------------+
| Windows XP SP3 x64     | xpsp3x64     |
+------------------------+--------------+
| Windows Vista x32      | vistax32     |
+------------------------+--------------+
| Windows Vista x64      | vistax64     |
+------------------------+--------------+
| Windows 7 Pro x32      | win7prox32   |
+------------------------+--------------+
| Windows 7 Pro x64      | win7prox64   |
+------------------------+--------------+
| Windows 7 Ultimate x32 | win7ult32    |
+------------------------+--------------+
| Windows 7 Ultimate x64 | win7ult64    |
+------------------------+--------------+
| Windows 8 sp1 x32      | win81prox32  |
+------------------------+--------------+
| Windows 8 sp1 x64      | win81prox64  |
+------------------------+--------------+
| Windows 8 Core x32     | win81corex32 |
+------------------------+--------------+
| Windows 8 Core x64     | win81corex64 |
+------------------------+--------------+
| Windows 10 Home x32    | win10homex32 |
+------------------------+--------------+
| Windows 10 Home x64    | win10homex64 |
+------------------------+--------------+
| Windows 10 Pro x32     | win10prox32  |
+------------------------+--------------+
| Windows 10 Pro x64     | win10prox64  |
+------------------------+--------------+
*/