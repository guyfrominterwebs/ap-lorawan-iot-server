<?php

namespace Lora\Database;

/**
	A database model class for Device.
*/
class Device extends BaseModel
{

	private const NAME_REGEX = '/[^a-z_\-0-9 ]/i';
	public const COLLECTION = 'devices';

	protected	$name					= '',
				$hardware_id			= '',
				$target					= null,
				$active					= false,
				$deactivation_time 		= 0;

	public static function create (string $hardware_id, string $name = '') : ?self {
		$temp					= new self ();
		$temp->_id				= $hardware_id;
		$temp->name				= $name;
		$temp->hardware_id		= $hardware_id;
		$temp->target			= MonitoringTarget::voidTarget ()->getId ();
		$temp->active			= true;
		return $temp->verify () ? $temp : null;
	}

	public static function createToDb (string $hardware_id, string $name = '') : ?self {
		if (($temp = self::create ($hardware_id, $name)) !== null) {
			if (!$temp->toDatabase ()) {
				$temp = null;
			}
		} return $temp;
	}

	public static function fetchFree () : array {
		return self::query ([ 'target' => MonitoringTarget::voidTarget ()->getId () ], Device::class, true);
	}

	public function getId () : string  {
		return $this->_id;
	}

	public function getTargetId () : ?\MongoDB\BSON\ObjectId {
		return $this->target;
	}

	public function setTarget (MonitoringTarget $target) : bool {
		if (MonitoringTarget::fromId ($target->getId ()) === null) {
			return false;
		}
		$this->target = $target->getId ();
		return true;
	}

	public function removeTarget () {
		$target = MonitoringTarget::voidTarget ();
		$this->target = $target->getId ();
	}

	public function setName (string $name) : void {
		$this->name = $name;
	}

	public function activate () : void {
		$this->deactivation_time = 0;
		$this->active = true;
	}

	public function deactivate () : void {
		$this->deactivation_time = time ();
		$this->active = false;
	}

	public function fetchSensors () : array {
		return self::query ([ 'device' => $this->_id ], DeviceSensor::class, true);
	}

	public function fetchTargetHistory () : array {
		/*
			FUCK THIS METHOD!
		*/
		return [];
		$sensors = [];
		try {
			$query = new \MongoDB\Driver\Command ([
				[ '$match' => [ "device" => $this->_id ] ],
				[ '$lookup' => [
						"from" => MonitoringTarget::COLLECTION,
						"localField" => "target",
						"foreignField" => "_id",
						"as" => 'asd'
					]
				]
			]);

			$cursor = \DBConnection::connection ('measurements')->executeCommand (self::collection (MonitoringData::COLLECTION), $query);
			$cursor->setTypeMap ([ 'root' => MonitoringTarget::class ]);
			$sensors = $cursor->toArray ();
		} catch (\Exception | \Error $e) {
			echo $e->getmessage ();
		}
		return $sensors;
	}

	/*
		Abstract overrides
	*/

	public function formatId ($id) {
		if (is_string ($id)) {
			return $id;
		} return null;
	}

	public function verify () : bool {
		return $this->__valid = ($this->_id === $this->hardware_id
				&& \DataLib::isHexString ($this->_id)
				&& \DataLib::regex ($this->_id, self::NAME_REGEX)
				&& \DataLib::isInt ($this->deactivation_time) !== false);
	}
}
