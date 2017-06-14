<?php

namespace Lora\Content;

/**
	A class to help manage multi-part forms and their state.
*/
abstract class FormPhase
{

	protected	$phase					= 0,
				$nextPhase				= 0,
				$error					= '';

	public function __construct (int $phase) {
		$this->phase = $phase;
		$this->nextPhase = $phase + 1;
	}

	public function getPhase () : int {
		return $this->phase;
	}

	public function nextPhase () : int {
		return $this->nextPhase;
	}

	public function getError () : string {
		return $this->error;
	}

	abstract function gatherData (\RequestData $req, \Lora\Messenger $mess) : void;

	abstract function processData (\RequestData $req) : bool;

	abstract function process () : void;

}
