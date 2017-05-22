<?php

/**
	A library for hosting data inspection, verification and sanitazition 
	functions.
*/
final class DataLib
{

	public static function isJson (string $value) {
		$json = json_decode ($value, true);
		return json_last_error () === JSON_ERROR_NONE && is_array ($json);
	}

	public static function isHexString (string $val) {
		return ctype_xdigit ($val);
	}
	/**
		Sees if a variable is intance of certain class.
		\param $object A mixed value to test.
		\param $class A class name to test $object against.
		\return Returns boolean true if $object is instance of $class and false if not.
	*/
	public static function IsInstanceOf ($object, string $class) : bool {
		if (!class_exists ($class, false)) {
			return false;
		} return $object instanceof $class;
	}

	/**
		Sees if all items in an array are instances of certain class.
		\param $objects An array of objects to test.
		\param $class A class name to test each object against.
		\return Returns true if and only if all the items in $objects are instances of $class and there are more then 0 items in $objects. False is returned otherwise.
	*/
	public static function AreInstanceOf (array $objects, string $class) : bool {
		if (!class_exists ($class, false)) {
			return false;
		}
		foreach ($objects as $object) {
			if (!($object instanceof $class)) {
				return false;
			}
		} return count ($objects) > 0;
	}

	/**
		A wrapper function for filter_var filtering integers.
		\param $value A value to test.
		\return Returns filtered $value as an integer if it can be converted and false if not.
	*/
	public static function isInt ($value) {
		return filter_var ($value, FILTER_VALIDATE_INT);
	}

}
