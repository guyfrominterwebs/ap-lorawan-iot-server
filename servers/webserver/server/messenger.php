<?php

namespace Lora;

/**
	A class used to pass data and system state information from actions to higher level systems.
*/
class Messenger
{

	private $data		= [],
			$errors		= [],
			$logs		= [];

	public function __construct () {
	}

	/**
		Returns all the data that has been added to this messenger.
		\return An array of data.
	*/
	public function getData () : array {
		return $this->data;
	}

	/**
		Get errors.
		\return Returns an array of all errors that occured during one request.
	*/
	public function getErrors () : array {
		return $this->errors;
	}

	/**
		Get logs.
		\return Returns an array of all log entries which were generated during one request.
	*/
	public function getLogs () : array {
		return $this->logs;
	}

	/**
		A method to add more data to the messenger.
		\param $value A new value to be added.
		\param $key An optional key for the value. If not provided, the $value is simply appended to the data array.
	*/
	public function addData ($value, $key = false) : void {
		if ($key !== false) {
			$this->data [$key] = $value;
			return;
		}
		$this->data [] = $value;
	}

	/**
		Replaces current data array with one given as parameter.
		\param An array of data.
	*/
	public function setData (array $data) : void {
		$this->data = $data;
	}

	/**
		Adds a new error message.
		\param $error A string containing an error message. Might later on be changed to integer.
	*/
	public function error (string $error) : void {
		$this->errors [] = $error;
	}

	/**
		Adds a new log message.
		\param $msg A string containing a message.
	*/
	public function log (string $msg) : void {
		$this->logs [] = $msg;
	}

}
