<?php

namespace Lora;

use \Lora\Server\{
	Command as Command,
	Response as Response
};

class ControlServer extends \WebSocketServer
{

	public 	$run 			= true,
			$publicServer 	= null;

	public function __construct (RealtimeServer $publicServer, string $address, int $port) {
		parent::__construct ($address, $port);
		$this->publicServer = $publicServer;
	}

	protected function process ($user, $message) : void {
		// $this->send ($user, $message);
		$command = \InternalMSG::decomposeMsg ($message);
		$this->resolveCommand ($command, $user, $message);
		$this->send ($user, Response::OK);
	}

	protected function connected ($user) : void {
		
	}

	protected function closed ($user) : void {
		
	}

	private function resolveCommand (array $command, $user, string $message) : void {
		switch ($command [0]) {
			case Command::ACTION:
					$this->terminate ();
				break;
			case Command::DATA:
					$this->publicServer->broadcast (\InternalMSG::extractMsg ($message));
				break;
		}
	}

	/**
		Graceful shotdown routine. Disconnects all clients and finally terminates this process by setting run to false.
	*/
	private function terminate () {
		foreach ($this->users as $user) {
			if ($user->socket !== $this->master) {
				$this->disconnect ($user);
			}
		}
		$this->run = false;
	}

	/**
		Broadcast a message to all interested clients.
		\todo Write message subscription system.
	*/
	private function broadcast (string $command) : void {
		if (empty ($command)) {
			return;
		}
		foreach ($this->users as $user) {
			if ($user->socket !== $this->master) {
				$this->send ($user, $command);
			}
		}
	}
}
