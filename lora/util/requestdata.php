<?php

/**
	A wrapper for request data arriving from client side. Makes it easier to safely read typed values.
	Another benefit is that since reuest parameters no longer needn't to be passed around as an array,
	the parameter array isn't copied on every method call. Might make code cleaner too.
		- Most definitely makes code cleaner.

	Each read -method returns true, if the value conversion succeeded and false in case of failure.
	$value is set to default in case of failure.

	get -methods return either the requested value or default value. Was added to allow cleaner use.

	getTArray -methods read multiple values with the key array they take as a parameter. One default
	value can be defined which will be assigned to any missing values.

	NOTE! Values read using this class must still be checked for proper value ranges. Take especial
			care with strings since they are rather complex to verify in some cases.

	NOTE! String methods in this class can be used to fetch integer and floating point values as well.
			If you need to get mixed values, use the string methods. Do note that arrays cannot be
			fetched using string methods since PHP raises a notice from converting an array to string.

	TODO: Research how casting the values to their corresponding types would affect the output.
		- Int casting can be done.

	MEMO: If optimization is required, look into filter_var_array

	*********************************************************************************************
	*	NOTE! ONE MUST NOT add a method which allows direct access to $data -array since that 	*
	*			invalidates the whole point of having this class in the first place.			*
	*********************************************************************************************

	\todo Write type checks for default values and resolve to null if they are of incorrect type.
*/

final class RequestData
{
	private $data = [];

	public function __construct ($request_data) {
		if (is_array ($request_data)) {
			$this->data = $request_data;
		}
	}

	public function has ($key) : bool {
		if (is_array ($key)) {
			foreach ($key as $k) {
				if (!array_key_exists ($k, $this->data)) {
					return false;
				}
			} return true;
		}
		return array_key_exists ($key, $this->data);
	}

	public function readInt ($key, &$value, $default = null) : bool {
		$value = $default;
		if (array_key_exists ($key, $this->data) && ($filtered = filter_var ($this->data [$key], FILTER_VALIDATE_INT)) !== false) {
			$value = $filtered;
			return true;
		} return false;
	}

	public function readBool ($key, &$value, $default = null) : bool {
		$value = $default;
		if (array_key_exists ($key, $this->data) && ($filtered = filter_var ($this->data [$key], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)) !== null) {
			$value = $filtered;
			return true;
		} return false;
	}

	public function readString ($key, &$value, $default = null) : bool {
		$value = $default;
		if (array_key_exists ($key, $this->data) && is_string ($this->data [$key])) {
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

	public function getIntArray (array $keys) : ?array {
		return $this->getTypedArray ($keys, 'getInt');
	}

	public function getBoolArray (array $keys) : ?array {
		return $this->getTypedArray ($keys, 'getBool');
	}

	public function getStringArray (array $keys) : ?array {
		return $this->getTypedArray ($keys, 'getString');
	}

	public function getArrayArray (array $keys) : ?array {
		return $this->getTypedArray ($keys, 'getArray');
	}

	/**
		Returns an array with its keys set to provided ones.
		Values are fetched from $data under same keys.
		If no entry is found for a key, the value is set to default.
	*/
	private function getTypedArray (array $keys, string $method) : ?array {
		$values = [];
		foreach ($keys as $key => $value) {
			$values [$key] = $this->$method ($key, $value);
		} return $values;
	}
}
