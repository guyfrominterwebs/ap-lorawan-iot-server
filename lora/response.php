<?php

namespace Lora\Server;

/**
	An enum class for response types used in internal system messaging.
*/
abstract class Response
{
	public const 	OK			= 0,	///< A success response.
					ERROR		= 1;	///< An error response.

	/**
		Collects all constants in Response during the first call and flips received array.
		This collection is then used to see if some value is a Response constant or not.
		\param $value Value to test for constant.
		\return Returns true is $value is a Response value and false if not.
	*/
	public static function isResponse ($value) {
		static $consts = null;
		if (!$consts) {
			$consts = array_flip ((new \ReflectionClass (__CLASS__))->getConstants ());
		}
		return isset ($consts [$value]);
	}
}
