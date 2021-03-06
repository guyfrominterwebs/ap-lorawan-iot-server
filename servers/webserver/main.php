<?php
/**
	Start up script for the webserver. Loads all configuration files and initialises Slim and its routes.
*/
chdir (__DIR__);
$server_name = 'web';
if ((require '../../main.php') !== 1) {
	internalError ();
	return;
}
require 'frameworks/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$server = new \Slim\Slim ();
$handler = new \Lora\RequestHandler ($server);

$server->map ('/api/?(:action+)', function (array $action = []) use ($server, $handler) {
	$handler->handleApiRequest ($action);
})->via ('GET', 'POST', 'PUT', 'DELETE');

$server->map ('/?(:action+)', function (array $action = []) use ($server, $handler) {
	$handler->handleContentRequest ($action);
})->via ('GET', 'POST', 'PUT', 'DELETE');

$server->run();

/**
	Change response to 500 if something goes wrong during this script.
*/
function internalError () {
	header ('HTTP/1.1 500 Internal Server Error');
}
