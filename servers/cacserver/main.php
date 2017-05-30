<?php
/*
	TODO: Global autoloader in addition to server specific autoloaders.
*/
require '../../frameworks/wsclient/Client.php';
require 'server/datastore.php';

use \Lora\Server\Command as Command;

$args = arguments ();
$argsc = count ($args);
$command = '';

$halp = [
	's' => [
		"Silent mode, no user input required beside command line arguments."
	],
	'h' => [
		"Displays this help message."
	],
	'temperature' => [
		"A temperature value.",
		'fakeTemperature'
	],
	'light' => [
		"A light value",
		'fakeLight'
	]
];
if ($argsc > 0) {
	if (isset ($args ['h'])) { ///< Help!
		exit ();
	}
}
if (!isset ($args ['s'])) { ///< Silents mode. Does not ask for additional input.
	echo 'Input command: ';
	$command = trim (fgets (fopen ('php://stdin', 'r')));
}

foreach ($args as $key => $arg) {
	if (isset ($halp [$key], $halp [$key][1]) && is_callable ($halp [$key][1])) {
		broadcast ($halp [$key][1] ($arg));
	}
}

foreach (explode (' ', $command) as $c) {
	broadcast (resolveCommand ($c));
}
exit ();

function parseCommand () {
	
}

function resolveCommand ($command) {
	switch ($command) {
		case "terminate": return InternalMSG::composeMsg (Command::ACTION, [ 'terminate' ]);
		case "temperature": return fakeTemperature ([21]);
		case "light": return fakeLight ([1]);
		case "many": return fakeMany ();
	}
		// broadcast (trim ($command));
}

# TODO: Better server machine support. Should have a way to differ a server machine 
# using ws from browser doing the same.
function broadcast ($data) {
	static $client = null;
	if (empty ($data)) {
		return false;
	}
	if (!$client) {
		$url = "ws://127.0.0.1:".\Lora\Config::port ('server', 'internal_messaging');
		msg_print ("Connecting to ${url}");
		$client = new \WebSocket\Client ($url);
		if (!$client->connect ()) {
			msg_print ("Connection failed: ".$client->lastError ());
		}
	}
	$msg = '';
	if (!$client->send ($data) || !$client->receive ($msg)) { // Something went wrong.
		return false;
	}
	$client->disconnect ();
	return true;
}

function fakeTemperature (array $tempeatures) : string {
	$data = [
		"device" => "0039ABFB7C0F69F5",
		"values" => []
	];
	foreach ($tempeatures as $temperature) {
		$data ['values'][] = [ 'TMP' => $temperature ];
	}
	return InternalMSG::composeMsg (Command::DATA, $data);
}

function fakeLight (array $lights) : string {
	$data = [
		"device" => "0039ABFB7C0F69F5",
		"values" => []
	];
	foreach ($lights as $light) {
		$data ['values'][] = [ 'LT.' => $light ];
	}
	return InternalMSG::composeMsg (Command::DATA, $data);
}

function fakeMany () {
	$data = [
		"device" => "0039ABFB7C0F69F5",
		"values" => [
			[ "TMP" => 21 ],
			[ "LT." => 1 ]
		]
	];
	return InternalMSG::composeMsg (Command::DATA, $data);
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
 