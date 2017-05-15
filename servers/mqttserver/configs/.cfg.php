<?php

require __DIR__.'/../../../config/config.php';
$configs = parse_ini_file ("config.ini.php", true);
if ($configs === false) {
	return false;
}
if (isset ($configs ['system']['debug'])) {
	define ('DEBUG', $configs ['system']['debug'] == true);
}
$conf = Lora\Config::instance ();
$conf->loadGlobalConfigs ();
$conf->init ($configs);
$conf->setExclude ($conf->get ('system', 'autoload_exclude'));
$conf->registerAutoloaders ();

function debug () {
	return defined ('DEBUG') && DEBUG === true;
}

function setConfig ($value, ...$key) {
	global $configs;
	$temp = $configs;
	$count = count ($key) - 1;
	for ($i = 0; $i < $count; ++$i) {
		$temp = $temp [$key [$i]];
	}
	$temp [$key [$i]] = $value;
}
