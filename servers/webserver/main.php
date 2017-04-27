<?php
chdir (__DIR__);
if (!require 'configs/.cfg.php') {
	internalError ();
	return;
}
require 'frameworks/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$server = new \Slim\Slim ();
$handler = new \Lora\RequestHandler ($server);

$server->map ('/api/?(:action+)', function (array $action = null) use ($server, $handler) {
	$handler->handleApiRequest ($action);
})->via ('GET', 'POST', 'PUT', 'DELETE');

$server->map ('/?(:action+)', function (array $action = null) use ($server, $handler) {
	$handler->handleContentRequest ($action);
})->via ('GET', 'POST', 'PUT', 'DELETE');

$server->run();


function internalError () {
	header ('HTTP/1.1 500 Internal Server Error');
}
