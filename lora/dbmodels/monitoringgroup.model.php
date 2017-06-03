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

	public function getId () : \MongoDB\BSON\ObjectID {
		return $this->_id;
	}

	public function fetchTargets () : array {
		self::query ([ 'group' => $this->_id ], MonitoringTarget::class, true);
	}

	public function verify () : bool {
		$this->valid = $this->_id instanceof \MongoDB\BSON\ObjectID;
		return $this->valid;
	}

}
