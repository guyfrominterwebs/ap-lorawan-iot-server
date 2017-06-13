<?php

namespace Lora\Database;

/**
	A database model class for 
*/
class MonitoringGroup extends BaseModel
{

	public const COLLECTION = 'monitoring_groups';

	protected	$name					= '',
				$description			= '';


	public static function create (string $name, string $description = '') : ?self {
		$temp					= new self ();
		$temp->newId ();
		$temp->name				= $name;
		$temp->description		= $description;
		return $temp->verify () ? $temp : null;
	}

	public function getId () : ?\MongoDB\BSON\ObjectID {
		return $this->_id;
	}

	public function fetchTargets () : array {
		self::query ([ 'group' => $this->_id ], MonitoringTarget::class, true);
	}

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
		return $this->__valid = $this->_id instanceof \MongoDB\BSON\ObjectID;
	}

}
