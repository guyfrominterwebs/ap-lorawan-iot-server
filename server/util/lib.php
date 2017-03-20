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
}