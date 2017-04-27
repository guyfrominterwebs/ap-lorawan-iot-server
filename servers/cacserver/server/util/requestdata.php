<?php

/*
	A wrapper for request data arriving from client side. Makes it easier to safely read typed values.
	Another benefit is that since reuest parameters nolonger needn't to be passed around as an array, 
	the parameter array isn't copied on every method call. Might make code cleaner too.

	Each read method returns true, if the value conversion succeeded and false in case of failure.
	$value is set to default in case of failure.

	NOTE! Values read using this class must still be checked for proper value ranges. Take especial 
	care with strings since they are rather complex to verify in some cases.

	TODO: Research how casting the values to their corresponding types would affect the output.
		- Integers can be casted.

*/

final class RequestData
{
	private $data;
	
	public function __construct (array $request_data) {
		$this->data = $request_data;
	}

	public function readInt ($key, &$value, $default = null) : bool {
		$value = $default;
		if (array_key_exists ($key, $this->data) && ($filtered = filter_var ($this->data [$key], FILTER_VALIDATE_INT)) !== false) {
			$value = (int)$filtered;
			return true;
		} return false;
	}

	public function readBool ($key, &$value, $default = null) : bool {
		$value = $default;
		if (array_key_exists ($key, $this->data) && ($filtered = filter_var ($this->data [$key], FILTER_VALIDATE_BOOLEAN)) !== null) {
			$value = $filtered;
			return true;
		} return false;
	}

	public function readString ($key, &$value, $default = null) : bool {
		$value = $default;
		if (array_key_exists ($key, $this->data) && (string)$this->data [$key] === $this->data [$key]) {
			$value = $this->data [$key];
			return true;
		} return false;
	}

	public function readArray ($key, &$value, $default = []) : bool {
		$value = $default;
		if (array_key_exists ($key, $this->data) && is_array ($this->data [$key])) {
			$value = $this->data [$key];
			return true;
		} return false;
	}

	public function getInt ($key, $default = null) : ?int {
		$this->readInt ($key, $val, $default);
		return $val;
	}

	public function getBool ($key, $default = null) : ?bool {
		$this->readBool ($key, $val, $default);
		return $val;
	}

	public function getString ($key, $default = null) : ?string {
		$this->readString ($key, $val, $default);
		return $val;
	}

	public function getArray ($key, $default = null) : ?array {
		$this->readArray ($key, $val, $default);
		return $val;
	}

}
