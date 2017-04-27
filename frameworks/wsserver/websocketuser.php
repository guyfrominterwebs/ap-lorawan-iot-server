<?php

class WebSocketUser {

	public $socket,
			$id,
			$headers 				= [],
			$handshake 				= false,
			$handlingPartialPacket 	= false,
			$partialBuffer 			= "",
			$sendingContinuous 		= false,
			$partialMessage 		= "",
			$hasSentClose 			= false,
			$requestedResource		= "";

	public function __construct ($id, $socket) {
		$this->id = $id;
		$this->socket = $socket;
	}
}