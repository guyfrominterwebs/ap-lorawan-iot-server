<?php

namespace Lora;

use \Lora\Server\Command as Command;

class RealtimeServer extends \WebSocketServer
{

	protected function process ($user, $message) {
		// $this->send ($user, $message);
	}
	
	protected function connected ($user) {
		// var_dump ($user->requestedResource);
	}
	
	protected function closed ($user) {
		# Cleanup goes here.
	}

	public function broadcast (string $msg) {
		foreach ($this->users as $user) {
			if ($user->socket !== $this->master) {
				$this->send ($user, $msg);
			}
		}
	}
}
