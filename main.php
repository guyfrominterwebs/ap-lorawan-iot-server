<?php
/**

	Lora hub server script. Capable of starting any hosted server found in the servers 
	folder. Provides start up routines and global autoloader for shared scripts. Declares 
	some common functions and runtime constants such as debug -function.
	
	Server starting is done on a name basis. Accepted server names are formed by taking 
	the folder name containing a hosted server and removing "server" from it.

	When used from CLI, the server name is the first argument value for this script.
	When used using any other interface, the server name must be provided using a global 
	variable called 'server_name'.

	Hosted servers can be found from the servers folder located in application root.

	If this script fails, it will return an error code larger than 1 since PHP uses 1
	as default return value for succesful includes.

*/
chdir (__DIR__);
require 'config/config.php';
if (!isset ($argv [1]) && !isset ($server_name)) {
	return fail (2, 2);
}
$serverPath = serverPath ();
if (!loadConfig ()) {
	return fail (3, 3);
}
if (!loadServerConfig ($serverPath)) {
	return fail (4, 4);
}
startServer ($serverPath);

/**
	Constructs the server path based on the provided server name.
	\return $serverPath Path to the hosted server's root directory.
*/
function serverPath () : string {
	/**
		\todo
			This function should be changed to fetch the directory names from the servers directory 
			to make adding new hosted servers easier.
	*/
	$path = __DIR__."/servers";
	switch ($name = serverName ()) {
		case "cac":
		case "mqtt":
		case "rt":
		case "web":
			return "${path}/${name}server";
		default:
			return '';
	}
}
/**
	Starts the server. \bNOTE: Must be the last function called within this script.
	\param $serverPath Path to a hosted server's root directory.
*/
function startServer (string $serverPath) : void {
	Lora\Config::registerAutoloaders ();
	chdir ($serverPath);
	if (isCli ()) {
		include "$serverPath/main.php";
	}
}

/**
	Loads global configuration file and determines whether or not debugging is enabled.
	\return A boolean value is returned indicating success of this function.
*/
function loadConfig () : bool {
	if (($configs = parse_ini_file ("config/config.ini.php", true, INI_SCANNER_TYPED)) === false) {
		return false;
	}
	if (isset ($configs ['system']['debug'])) {
		define ('DEBUG', $configs ['system']['debug'] == true);
	}
	Lora\Config::loadConfig ($configs);
	return true;
}

/**
	Attempts to load server specific configurations if such exist.
	\param $serverPath Path to a hosted server's root directory.
	\return True is returned if configurations were succesfully loaded or if there are none. False is returned incase of failure.
*/
function loadServerConfig (string $serverPath) : bool {
	if (file_exists ($path = "${serverPath}/configs/config.ini.php")) {
		if (($config = parse_ini_file ($path, true, INI_SCANNER_TYPED)) === false) {
			return false;
		}
		$config ['server']['path_root'] = $serverPath;
		Lora\Config::loadConfig ($config);
	}
	return true;
}

/**
	Determines if CLI was used to start this script.
	\return If CLI was used to start this script, true is returned; otherwise false.
*/
function isCli () : bool {
	return php_sapi_name () === 'cli';
}

/**
	Attempts to return name of the server which is wished to be started.
	\return Returns the server name if it is provided. An empty string is returned if server name could not be located.
*/
function serverName () : string {
	global $argv, $server_name;
	$name = isCli () ? $argv [1] : $server_name;
	return empty ($name) ? '' : $name;
}

/**
	Returns an appropriate of the two provided error codes based on the starting interface.
	\param $cliError Error code to return incase this script is being ran from a CLI.
	\param $otherError Error code to return for all the other start up interfaces.
	\return Returns an error code. Can be a mixed value.
*/
function fail ($cliError, $otherError) {
	return isCli () ? $cliError : $otherError;
}

/**
	A global debug function found in the root namespace. Can be used from any hosted server.
	\b NOTE: Try to avoid using 1 since that is PHP's default return code for succesful include.
	\return Returns true if debugging is turned on and false if not.
*/
function debug () : bool {
	return defined ('DEBUG') && DEBUG === true;
}
