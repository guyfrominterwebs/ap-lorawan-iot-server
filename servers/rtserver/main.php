<?php
/*
	TODO: Write channel functions (classes?) which determine what data is being broadcasted along the socket.
*/
require '../../frameworks/wsserver/websockets.php';

use \Lora\{RealtimeServer, ControlServer};

$rtserver = new RealtimeServer ("0.0.0.0", \Lora\Config::port ('server', 'public_ws'));
$internal = new ControlServer ($rtserver, "127.0.0.1", \Lora\Config::port ('server', 'internal_messaging'));
$rtserver->selfLoop (false);
$internal->selfLoop (false);
try {
	while ($internal->run) {
		$rtserver->run ();
		$internal->run ();
	}
} catch (Exception $e) {
	$rtserver->stdout($e->getMessage());
}

function msg_print ($msg) {
	echo "RT Says: $msg".PHP_EOL;
}