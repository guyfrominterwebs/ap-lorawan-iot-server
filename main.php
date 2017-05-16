<?php
/**
 *
 *	Lora hub server script. Capable of starting any hosted server found in the servers 
 *	folder. Provides start up routines and global autoloader for shared scripts. Declares 
 *	some common functions and runtime constants such as debug -function.
 *	
 *	Server starting is done on a name basis. Accepted server names are formed by taking 
 *	the folder name containing a hosted server and removing "server" from it.
 *
 *	When used from CLI, the server name is the first argument value for this script.
 *	When used using any other interface, the server name must be provided using a global 
 *	variable called 'server_name'.
 *
 *	Hosted servers can be found from the servers folder located in application root.
 *
 *	If this script fails, it will return an error code larger than 1 since PHP uses 1
 *	as default return value for succesful includes.
 *
*/
chdir (__DIR__);
require 'config/config.php';
if (($configs = parse_ini_file ("config/config.ini.php", true)) === false) {
	return fail (2, 2);
}
if (!isset ($argv [1]) && !isset ($server_name)) {
	return fail (3, 3);
}
loadConfig ($configs);
$serverPath = serverPath ();
if (loadServerConfig ($serverPath)) {
	startServer ($serverPath);
}

exit ();

/**
	Constructs the server path based on the provided server name.
	\return $serverPath Path to the hosted server's root directory.
*/
function serverPath () : string {
	$path = __DIR__."/servers";
	switch (serverName ()) {
		case "cac":
			return "${path}/cacserver";
		case "mqtt":
			return "${path}/mqttserver";
		case "rt":
			return "${path}/rtserver";
		case "web":
			return "${path}/webserver";
		default:
			return '';
	}
}
/**
	Starts the server. \bNOTE: Must be the last function called within this script.
*/
function startServer (string $serverPath) {
	Lora\Config::registerAutoloaders ();
	chdir ($serverPath);
	if (isCli ()) {
		include "$serverPath/main.php";
	}
}

function loadConfig (array $configs) : void {
	if (isset ($configs ['system']['debug'])) {
		define ('DEBUG', $configs ['system']['debug'] == true);
	}
	Lora\Config::loadConfig ($configs);
}

function loadServerConfig (string $serverPath) : bool {
	$path = "${serverPath}/configs/config.ini.php";
	if (!file_exists ($path) || ($config = parse_ini_file ($path, true)) === false) {
		return false;
	}
	$config ['server']['path_root'] = $serverPath;
	Lora\Config::loadConfig ($config);
	return true;
}

function isCli () {
	return php_sapi_name () === 'cli';
}

function serverName () {
	global $argv, $server_name;
	return isCli () ? $argv [1] : $server_name;
}

function fail ($cli_error, $other_error) {
	return isCli () ? $cli_error : $other_error;
}

function debug () {
	return defined ('DEBUG') && DEBUG === true;
}