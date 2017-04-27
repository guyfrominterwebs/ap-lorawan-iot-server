<?php

namespace Lora;

class Messenger
{

	private $data		= [],
			$errors		= [],
			$logs		= [],
			$page		= null;

	public function __construct () {
	}

	public function getPage (Page $page = null) {
		return $page !== null ? $this->page = $page : $this->page ?? $this->page = new Page ();
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
