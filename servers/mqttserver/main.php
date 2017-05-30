<?php

require 'frameworks/MQTT/phpMQTT.php';
require '../../frameworks/wsclient/Client.php';

\Lora\DataServer::instance ()->start ();
exit ();

function msg_print ($msg) {
	echo "MQTT Says: ${msg}".PHP_EOL;
}

/*
# Example data.
{
	"app_id":"not_an_application",
	"dev_id":"lorawan_asd",
	"hardware_serial":"0039ABFB7C0F69F5",
	"port":1,"
	counter":31,
	"payload_raw":"aGVsbG8gamlza2E=",
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



{
	"app_eui":"70B3D57EF0003E41",
	"dev_eui":"0004A30B001B0E5F",
	"dev_addr":"26012A45",
	"metadata":{
		"time":"2017-05-15T12:01:35.971795498Z",
		"frequency":868.3,
		"modulation":"LORA",
		"data_rate":"SF7BW125",
		"coding_rate":"4/5",
		"gateways":[
			{
				"gtw_id":"eui-000000000000beef",
				"timestamp":3824575339,
				"time":"",
				"channel":1,
				"rssi":-107,
				"snr":-8,
				"rf_chain":1
			}
		]
	}
}
*/

function data_test () {
	$data = json_decode ('{ "_id" : ObjectId("58f5f1747f3a9d09b0e183db"), "app_id" : "not_an_application", "dev_id" : "lorawan_asd", "hardware_serial" : "0039ABFB7C0F69F5", "port" : 1, "counter" : 31, "payload_raw" : "aGVsbG8gamlza2E=", "metadata" : { "time" : "2017-03-28T12:37:41.695112344Z", "frequency" : 868.1, "modulation" : "LORA", "data_rate" : "SF7BW125", "coding_rate" : "4/5", "gateways" : [ { "gtw_id" : "eui-000000000000beef", "timestamp" : 2169582635, "time" : "", "channel" : 0, "rssi" : -119, "snr" : -6.5, "rf_chain" : 1 } ] }, "topic" : "not_an_application/devices/lorawan_asd/up", "time" : 1490704662, "payload" : "hello jiska\u0000" }');
	while (true) {
		procmsg ('waa', $data);
	}
}