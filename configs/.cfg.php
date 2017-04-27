<?php

require __DIR__.'/../../../config/config.php';
if (($config = parse_ini_file ("config.ini.php", true)) === false) {
	return false;
}
if (($globalConfig = parse_ini_file (__DIR__."/../../../config/config.ini.php", true)) === false) {
	return false;
}
if (isset ($config ['system']['debug'])) {
	define ('DEBUG', $config ['system']['debug'] == true);
}
Lora\Config::loadConfig ($config);
Lora\Config::loadConfig ($globalConfig);
Lora\Config::registerAutoloaders ();

function debug () {
	return defined ('DEBUG') && DEBUG === true;
}
