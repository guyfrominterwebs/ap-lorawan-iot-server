<?php

/**
	A library for hosting data inspection, verification and sanitazition functions which are not bound to any specific code base.
*/
final class DataLib
{

	/**
		Performs a regular expression. Throws an error if an invalid regulat expression is given.
		\param $value A string value to test.
		\param $expression A complete regular expression string.
		\return Returns true if $value matches $expression, false otherwise.
	*/
	public static function regex (string $value, string $expression) : bool {
		return preg_match ($expression, $value) === 1;
	}

	/**
		Checks whether or not given string is a valid JSON string by attempting to parse it into an associative array.
		The parsed JSON array can optionally be return if and only if it was succesfully parsed 
		and while $return is set to true.
		\param $value A string to test for valid JSON.
		\param $return An optional boolean parameter to determine if the parsed JSON should be returned on success.
			$return is not considered on failure cases.
		\param $assoc An optional boolean parameter to decide if $value should be parsed into an associative array 
			($assoc == true) or to an object ($assoc == false). Defaults to associative array.
		\return Returns true if $value was succesfully parsed into JSON form and $return is false.
			If $return is set to true on succesful case, the JSON is returned as an object or an associative array according to $assoc.
			False is returned if $value could not be parsed into JSON.
		
	*/
	public static function isJson (string $value, bool $return = false, bool $assoc = true) {
		$json = json_decode ($value, $assoc);
		$temp = json_last_error () === JSON_ERROR_NONE && is_array ($json);
		if ($temp && $return) {
			return $json;
		} return $temp;
	}

	public static function isHexString (string $val) : bool {
		return ctype_xdigit ($val);
	}

	/**
		Sees if a variable is intance of a certain class without invoking autoloader.
		\param $object A mixed value to test.
		\param $class A class name to test $object against.
		\return Returns boolean true if $object is instance of $class and false if not.
	*/
	public static function isa ($object, string $class) : bool {
		if (!class_exists ($class, false)) {
			return false;
		} return $object instanceof $class;
	}

	/**
		Sees if all items in an array are instances of certain class without invoking autoloader.
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
		NOTE: To test for succesful cases, use DataLib::isInt () !== false.
		\param $value A value to test.
		\return Returns filtered $value as an integer if it can be converted and false if not.
	*/
	public static function isInt ($value) {
		return filter_var ($value, FILTER_VALIDATE_INT);
	}

	/**
		Tests if $text matches given criteria. Throws an error on invalid regular expression.
		\param $text String to test.
		\param $max An inclusive maximum length the $text may have.
		\param $min An optional inclusive minimum length the $text must have.
		\param $regex An optional regular expression to test the $text with. Only used, if not empty.
		\return Returns true if the $text matches given criteria and false if not.
	*/
	public static function text (string $text, int $max, int $min = 0, string $regex = '') : bool {
		$len = strlen ($text);
		return $len <= $max && $len >= $min && (empty ($regex) || self::regex ($text, $regex));
	}

	public static function validGPSCoordinate (float $latitude, float $longitude) {
		return abs ($latitude) <= 90 && abs ($longitude) <= 180;
	}
}
