<?php

namespace Lora;

class Messenger
{

	private $data		= [],
			$errors		= [],
			$logs		= [];

	public function __construct () {
	}

	public function getData () {
		return $this->data;
	}

	public function getErrors () {
		return $this->errors;
	}

	public function getLogs () {
		return $this->logs;
	}

	public function addData ($value, $key = false) {
		if ($key !== false) {
			$this->data [$key] = $value;
			return;
		}
		$this->data [] = $value;
	}

	public function error ($error) {
		$this->errors [] = $error;
	}

	public function log ($msg) {
		$this->logs [] = $msg;
	}

}
