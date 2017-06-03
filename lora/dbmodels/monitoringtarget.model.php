<?php

namespace Lora\Database;

/**
	A database model class for 
*/
class MonitoringTarget extends BaseModel
{

	public const COLLECTION = 'monitoring_targets';

	protected	$name					= '',
				$group					= null,
				$location				= [ 0, 0 ],
				$active					= false,
				$deactivation_time		= 0;

	public static function create (string $name, MonitoringGroup $group = null) : ?self {
		$temp					= new self ();
		$temp->newId ();
		$temp->group			= ($group ?? MonitoringGroup::dummy ())->getId ();
		$temp->name				= $name;
		$temp->active			= true;
		return $temp->verify () ? $temp : null;
	}

	public static function voidTarget () : ?self {
		$target = self::fromName ('void');
		if ($target === null) {
			$target = self::create ('void');
			$target->toDatabase ();
		} return $target;
	}

	public function getId () : \MongoDB\BSON\ObjectID {
		return $this->_id;
	}

	public function setLocation (float $latitude, float $longitude) : bool {
		if (!\DataLib::validGPSCoordinate ($latitude, $longitude)) {
			return false;
		}
		$this->location [0] = $latitude;
		$this->location [1] = $longitude;
		return false;
	}

	public function setGroup (MonitoringGroup $group) : bool {
		if (MonitoringGroup::fromId ($group->getId ()) === null) {
			return false;
		}
		$this->group = $group->getId ();
		return true;
	}

	public function activate () : void {
		$this->deactivation_time = 0;
		$this->active = true;
	}

	public function deactivate () : void {
		$this->deactivation_time = time ();
		$this->active = false;
	}

	public function fetchDevices () : array {
		return self::query ([ "target" => $this->_id ], Device::class, true);
	}

	public function verify () : bool {
		$this->valid = $this->_id instanceof \MongoDB\BSON\ObjectID
				&& ($this->group === null || MonitoringGroup::fromId ($this->group) !== null)
				&& \DataLib::validGPSCoordinate ($this->location [0], $this->location [1])
				&& \DataLib::isInt ($this->deactivation_time) !== false;
		return $this->valid;
	}

}
