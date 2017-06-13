<?php

// fFRNUDEyOjI4fFRNUDQyOjMyfExULjoyOA==
// 7c544d5031323a32387c544d5034323a33327c4c542e3a3238 
/*
	{
		"app_id":"not_an_application",
		"dev_id":"lorawan_asd",
		"hardware_serial":"0039ABFB7C0F69F5",
		"port":1,
		"counter":31,
		"payload_raw":"fFRNUDEyOjI4fFRNUDQyOjMyfExULjoyOA==",
		"metadata":{
			"time":"2017-03-28T12:37:41.695112344Z",
			"frequency":868.1,
			"modulation":"LORA",
			"data_rate":"SF7BW125",
			"coding_rate":"4/5",
			"gateways":[{
				"gtw_id":"eui-000000000000beef",
				"timestamp":2169582635,
				"time":"",
				"channel":0,
				"rssi":-119,
				"snr":-6.5,
				"rf_chain":1
			}]
		}
	}
	$asd = '|TMP12:28|TMP42:32|LT.:28';
	$c = strlen ($asd);
	for ($i = 0; $i < $c; ++$i) {
		echo dechex (ord ($asd [$i]));
	}
*/

// echo base64_encode ('|TMP12:28|TMP42:32|LT.:28');
$before = microtime (true);
require '../main.php';
if (debug ()) {
	echo microtime (true) - $before, 's';
}
