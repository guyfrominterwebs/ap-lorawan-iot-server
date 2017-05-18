<?php

namespace Lora\Server;

/**
	An enum class for message types used in internal system messaging.
*/
abstract class Command
{
	public const 	INVALID		= 0,	///< An invalid message.
					DATA		= 1,	///< Data message containing data.
					ACTION		= 2;	///< Action message containing a action to perform.

	/**
		Collects all constants in Command during the first call and flips received array.
		This collection is then used to see if some value is a Command constant or not.
		\param $value Value to test for constant.
		\return Returns true is $value is a Command value and false if not.
	*/
	public static function isCommand ($value) {
		static $consts = null;
		if (!$consts) {
			$consts = array_flip ((new ReflectionClass (__CLASS__))->getConstants ());
		}
		return isset ($consts [$value]);
	}
}
