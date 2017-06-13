<?php

namespace Lora\Database;

/**
	A database model class for User. Contains fields commonly found in any user login system.
	Provide utility functions for common session and user management related tasks.
*/
class User extends BaseModel
{

	public const COLLECTION = 'devices';

	protected	$name					= '',
				$password				= '',
				$salt					= '',
				$email					= '';
	/*
		Abstract overrides
	*/

	public function formatId ($id) {
		if (is_string ($id)) {
			return new \MongoDB\BSON\ObjectID ($id);
		} else if (\DataLib::isa ($id, \MongoDB\BSON\ObjectID::class)) {
			return $id;
		} return null;
	}

	public function verify () : bool {
		return true;
	}

}
