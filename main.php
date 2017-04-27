<?php
/*
	Lora hub sever script. Capable of starting any hosted server in the servers folder.
	Provides start up routines and global autoloader for shared scripts.
*/

chdir (__DIR__);
require 'config/config.php';
$configs = parse_ini_file ("config/config.ini.php", true);
if ($configs === false) {
	return false;
}
if (isset ($configs ['system']['debug'])) {
	define ('DEBUG', $configs ['system']['debug'] == true);
}

if (!isset ($argv [1])) {
	return 1;
}
$server = $argv [1];

loadConfig ($configs);
$serverPath = serverPath ($server);
if (loadServerConfig ($serverPath)) {
	startServer ($serverPath);
}

function debug () {
	return defined ('DEBUG') && DEBUG === true;
}

function serverPath (string $server) : string {
	$path = __DIR__."/servers";
	switch ($server) {
		case "cac":
			return "${path}/cacserver";
		case "mqtt":
			return "${path}/mqttserver";
		case "rt":
			return "${path}/rtserver";
		default:
			return '';
	}
}

function startServer (string $serverPath) {
	Lora\Config::registerAutoloaders ();
	include "$serverPath/main.php";
}

function loadConfig (array $config) : void {
	Lora\Config::loadConfig ($config);
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