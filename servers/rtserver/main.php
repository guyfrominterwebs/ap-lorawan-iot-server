<?php
/*
	TODO: Write channel functions (classes?) which determine what data is being broadcasted along the socket.
*/
require '../../frameworks/wsserver/websockets.php';

use \Lora\Server\Command as Command;

class echoServer extends WebSocketServer {
	// protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.

	protected function process ($user, $message) {
		var_dump ($message);
		$this->send ($user, $message);
	}
	
	protected function connected ($user) {
		// Do nothing: This is just an echo server, there's no need to track the user.
		// However, if we did care about the users, we would probably have a cookie to
		// parse at this step, would be looking them up in permanent storage, etc.
		var_dump ($user->requestedResource);
	}
	
	protected function closed ($user) {
		// Do nothing: This is where cleanup would go, in case the user had any sort of
		// open files or other objects associated with them.	This runs after the socket 
		// has been closed, so there is no need to clean up the socket itself here.
	}

	public function broadcast (string $msg) {
		msg_print ('Broadcasting'.$msg);
		foreach ($this->users as $user) {
			if ($user->socket !== $this->master) {
				$this->send ($user, $msg);
			}
		}
	}
}

class ControlServer extends WebSocketServer
{

	public $run = true,
			$publicServer = null;

	public function __construct ($publicServer, $address, $port) {
		parent::__construct ($address, $port);
		$this->publicServer = $publicServer;
	}

	protected function process ($user, $message) {
		$this->send ($user, $message);
		$this->parseMessage ($message);
	}

	protected function connected ($user) {
		
	}

	protected function closed ($user) {
		
	}

	private function parseMessage (string $message) {
		if (($pos = strpos ($message, ':')) === false) {
			return; # Drop message.
		}
		$command = substr ($message, 0, $pos);
		$data = substr ($message, $pos + 1);
		msg_print ("Obey: $command $data");
		$this->resolveCommand ($command, $data);
	}

	private function resolveCommand (string $command, string $data) {
		// $this->broadcast ($command);
		switch ($command) {
			case Command::ACTION:
					$this->terminate ();
				break;
			case Command::DATA:
					$this->publicServer->broadcast ($data);
				break;
		}
	}

	private function terminate () {
		foreach ($this->users as $user) {
			if ($user->socket !== $this->master) {
				$this->disconnect ($user);
			}
		}
		$this->run = false;
	}

	private function broadcast (string $command) {
		foreach ($this->users as $user) {
			if ($user->socket !== $this->master) {
				$this->send ($user, $command);
			}
		}
	}
}

$echo = new echoServer ("0.0.0.0", "9000");
$inter = new ControlServer ($echo, "127.0.0.1", "9001");
$echo->selfLoop (false);
$inter->selfLoop (false);
try {
	while ($inter->run) {
		$echo->run ();
		$inter->run ();
	}
} catch (Exception $e) {
	$echo->stdout($e->getMessage());
}

function msg_print ($msg) {
	echo "RT Says: $msg".PHP_EOL;
}