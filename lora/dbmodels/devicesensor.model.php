<?php

namespace Lora\Database;

/**
	A database model class for DeviceSensors.
*/
class DeviceSensor extends BaseModel
{

	public const COLLECTION = 'device_sensors';

	protected	$device					= null,
				$parameter				= null,
				$pin_number				= -1,
				$description			= '';

	public static function create (Device $device, Parameter $parameter, int $pinNumber) : ?self {
		$temp					= new self ();
		$temp->newId ();
		$temp->device			= $device->getId ();
		$temp->parameter		= $parameter->getId ();
		$temp->pin_number		= $pinNumber;
		return $temp->verify () ? $temp : null;
	}

	public static function createToDb (Device $device, Parameter $parameter, int $pinNumber) : ?self {
		if (($temp = self::create ($device, $parameter, $pinNumber)) !== null) {
			if (!$temp->toDatabase ()) {
				$temp = null;
			}
		} return $temp;
	}
	public static function fromMeasurement (Device $device, Parameter $parameter, int $pin) : ?self {
		return self::query ([ 'device' => $device->getId (), 'parameter' => $parameter->getId (), 'pin_number' => $pin ], self::class, false);
	}

	public function getId () : \MongoDB\BSON\ObjectID {
		return $this->_id;
	}

	public function getDeviceId () : string {
		return $this->device;
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
				&& Device::fromId ($this->device) !== null
				&& Parameter::fromId ($this->parameter) !== null
				&& \DataLib::isInt ($this->pin_number) !== false;
	}

}  
