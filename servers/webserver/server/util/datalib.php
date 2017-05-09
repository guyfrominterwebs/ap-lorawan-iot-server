<?php

final class DataLib
{

	public static function IsInstanceOf ($object, $class) {
		if (self::GetType ($class) !== 'string' || !class_exists ($class, false)) {
			return false;
		} return $object instanceof $class;
	}

	public static function AreInstanceOf (array $objects, $class) {
		foreach ($objects as $object) {
			if (!self::IsInstanceOf ($object, $class)) {
				return false;
			}
		} return count ($objects) > 0;
	}

}
