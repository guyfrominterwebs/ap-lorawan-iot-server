<?php

final class Lib
{

	private function __construct(){
		throw new Exception('Lib is not an object.');
	}

	public static function dump ($val, $return = false) {
		$val = '<pre>'.print_r ($val, true).'</pre>';
		if ($return) {
			return $val;
		}
		echo $val;
	}

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

	public static function checkExtension (string $file, string $extension) : string {
		if (!empty ($file) && empty (pathinfo ($file, PATHINFO_EXTENSION))) {
			return "{$file}.{$extension}";;
		} return $file;
	}
}
