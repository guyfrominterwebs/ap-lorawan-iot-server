<?php
/*
	TODO: Global autoloader in addition to server specific autoloaders.
*/
chdir (__DIR__);
require '../../frameworks/wsclient/Client.php';
require 'server/climanager.php';

use \Lora\Server\Command as Command;

var_dump (json_encode ('aeiotigaoposk'));

$stdin = fopen('php://stdin', 'r');

$command = readInput ();
resolveCommand ($command);
exit ();

function resolveCommand ($command) {
	switch ($command) {
		case "terminate":
				broadcast ();
			break;
	}
		// broadcast (trim ($command));
}

# TODO: Better server machine support. Should have a way to differ a server machine 
# using ws from browser doing the same.
function broadcast ($data) {
	static $client = null;
	if (!$client) {
		$url = "ws://127.0.0.1:".\Lora\Config::get ('server', 'intern_port');
		msg_print ("Connecting to ${url}");
		$client = new \WebSocket\Client ($url);
		if (!$client->connect ()) {
			msg_print ("Connection failed: ".$client->lastError ());
		}
	}
	$msg = '';
	$data = $data .":";
	if (!$client->send ($data) || !$client->receive ($msg)) { // Something went wrong.
		return false;
	}
	return true;
}

function msg_print ($msg) {
	echo "CAC Says: ${msg}".PHP_EOL;
}
/*
	$query = new MongoDB\Driver\Query ([]);
	$cursor = $manager->executeQuery ('lorawan.data', $query);
	foreach ($cursor as $c) {
		var_dump ($c);
	}


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
*/
