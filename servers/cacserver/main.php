<?php
/*
	TODO: Global autoloader in addition to server specific autoloaders.
*/
require '../../frameworks/wsclient/Client.php';
require 'server/clilib.php';
require 'server/datastore.php';

use \Lora\Server\{Command as Command, InternalMSG as InternalMSG};

$args = arguments ();
$argsc = count ($args);
$command = '';

if ($argsc > 0) {
	if (hasHelp ($args)) { ///< Help!
		outHelp ();
		exit ();
	}
}
$commands = [];
if (!hasSilent ($args)) { ///< Silents mode. Does not ask for additional input.
	echo 'Input command: ';
	$commands = parseCommand (trim (fgets (fopen ('php://stdin', 'r'))));
}

$repeat = getRepeat ($args);
$delay = getDelay ($args);
$device = deviceHwId (1);
$single = hasSingle ($args);
$send = array_merge (
			runArgs ($args, $device, $single),
			runArgs ($commands, $device, $single)
		);
for ($i = 0; $i < $repeat || $repeat === 0; ++$i) {
	foreach ($send as $msg) {
		broadcast ($msg, $i + 1 === $repeat);
		sleep ($delay);
	}
}
exit ();

function commandToInternal (string $command, string $device, array $values) : string {
	switch ($command) {
		case "terminate":
			return InternalMSG::composeMsg (Command::ACTION, [ 'terminate' ]);
		case "temperature":
		case "light":
		case "many":
			$func = "construct_${command}";
			return  $func ($device, $values);
	}
	return '';
}

# TODO: Better server machine support. Should have a way to differ a server machine 
# using ws from browser doing the same.
function broadcast (string $data, bool $last) {
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
	if ($last) {
		$client->disconnect ();
	}
	return true;
}

function construct_temperature (string $device, array $temperatures) : string {
	$data = [
		"device" => $device,
		"values" => buildValues ($temperatures, 'TMP')
	];
	return InternalMSG::composeMsg (Command::DATA, $data);
}

function construct_light (string $device, array $lights) : string {
	$data = [
		"device" => $device,
		"values" => buildValues ($lights, 'LT.')
	];
	return InternalMSG::composeMsg (Command::DATA, $data);
}

function construct_many (string $device, array $args) : string {
	$data = [
		"device" => $device,
		"values" => [
			[ "TMP" => 21 ],
			[ "LT." => 1 ]
		]
	];
	return InternalMSG::composeMsg (Command::DATA, $data);
}

function buildValues (array $values, string $type) {
	$result = [];
	foreach ($values as $value) {
		$result [] = [ $type => trim ($value, '\'"')];
	}
	return $result;
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
 