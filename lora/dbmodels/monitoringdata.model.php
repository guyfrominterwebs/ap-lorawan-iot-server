<?php

namespace Lora\Database;

/**
	A database model class for monitoring data.
*/
class MonitoringData extends BaseModel
{

	public const COLLECTION = 'monitoring_data';

	protected	$device					= null,
				$sensor					= null,
				$target					= null,
				$parameter				= null,
				$timestamp				= 0,
				$value					= 0;

	public static function create (DeviceSensor $sensor, MonitoringTarget $target, Parameter $parameter, int $timestamp, $value) : ?self {
		$temp					= new self ();
		$temp->newId ();
		$temp->device			= $sensor->getDeviceId ();
		$temp->sensor			= $sensor->getId ();
		$temp->target			= $target->getId ();
		$temp->parameter		= $parameter->getId ();
		$temp->timestamp		= $timestamp;
		$temp->value			= $value;
		return $temp->verify () ? $temp : null;
	}

	public static function createToDb (DeviceSensor $sensor, MonitoringTarget $target, Parameter $parameter, int $timestamp, $value) : ?self {
		if (($temp = self::create ($sensor, $target, $parameter, $timestamp, $value)) !== null) {
			if (!$temp->toDatabase ()) {
				$temp = null;
			}
		} return $temp;
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
		return $this->__valid = $this->_id instanceof \MongoDB\BSON\ObjectID
				&& $this->target instanceof \MongoDB\BSON\ObjectID
				&& $this->parameter instanceof \MongoDB\BSON\ObjectID
				&& Device::fromId ($this->device) !== null
				&& MonitoringTarget::fromId ($this->target) !== null
				&& Parameter::fromId ($this->parameter) !== null
				&& \DataLib::isInt ($this->timestamp) !== false;
	}

}
