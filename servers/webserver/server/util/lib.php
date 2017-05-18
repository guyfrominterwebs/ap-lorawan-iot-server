<?php

/**
	A class to contain more or less universal library functions which can be used in any project.
*/
final class Lib
{

	private function __construct(){
		throw new Exception('Lib is not an object.');
	}

	/**
		Pretty prints the given value as HTML, wrapped in pre -tags.
		Optionally, returns the pretty printed data instead of appending 
		to the out buffer with echo.
		\param $val Value to be printed.
		\param $return An optional boolean value defaulting to false to choose if the pretty printed value should be returned.
	*/
	public static function dump ($val, bool $return = false) {
		$val = '<pre>'.print_r ($val, true).'</pre>';
		if ($return) {
			return $val;
		}
		echo $val;
	}

	/**
		Builds a string from an array of data. Only works with one dimensional arrays and scalar types.
		\param $data An array of data to be concatenated into a string.
		\param $delim Delimiter string added between values.
		\param $keyed A boolean value to dictate if array keys should be included in the final string.
		\param $glue A string to be added between key and value pairs. Used only if keyed is true.
	*/
	public function arrayToString (array $data, string $delim, bool $keyed = false, string $glue = '') {
		$string = '';
		if ($keyed) {
			foreach ($data as $key => $value) {
				if (empty ($value)) {
					$string .= $key.$delim;
				} else {
					$string .= $key.$glue.$value.$delim;
				}
			}
		} else {
			foreach ($data as $value) {
				$string .= $value.$delim;
			}
		} return substr ($string, 0, -strlen ($delim));
	}

	/**
		A function to check if a file name has given extension in it and adds one if it is not found.
		\param $file A file name to be checked for extension.
		\param $extension An extension to check against and to add if not found.
	*/
	public static function checkExtension (string $fileName, string $extension) : string {
		if (!empty ($fileName) && empty (pathinfo ($fileName, PATHINFO_EXTENSION))) {
			return "{$fileName}.{$extension}";;
		} return $fileName;
	}
}
