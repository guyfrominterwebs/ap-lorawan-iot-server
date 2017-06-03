<?php

namespace Lora\Content;

use \Lora\DAO as DAO;
use \Lora\Database\{
	Device,
	Parameter,
	MonitoringGroup,
	MonitoringTarget,
	DeviceSensor
};
use \RequestData;

final class Content_Monitoring extends \Lora\BaseAction
{

	public function _get (RequestData $req) : void {
		// $this->asd ();
		$device = Device::fromId ('0039ABFB7C0F69F5');
		$asd = $device->fetchTargetHistory ();
		var_dump ($asd);
		die ();
		foreach (Device::fetchAll () as $device) {
			var_dump ($device);
			echo '<br>';
			echo '<br>';
		}
		foreach (Parameter::fetchAll () as $device) {
			var_dump ($device);
			echo '<br>';
			echo '<br>';
		}
		die ();
		$asd = Device::fromName ('asds');
		var_dump ($asd);
		$parameter = Parameter::fromQuantity ("TMP");
		if ($parameter === null) {
			$parameter = Parameter::create ("C", "TMP");
			$parameter->toDatabase ();
		}
		var_dump (DeviceSensor::create ($device, $parameter, 1));
		die ();
		// if ($req->readString ('id', $id)) {
			// $this->mess->addData ($id, $this->name);
			// $devices = DAO::fetchDevices ([ '_id' => $id ]);
			// if (count ($devices) === 1) {
				// $this->page->addGlobal ('devices', $devices);
			// }
		// }
		// $this->page->addSubViewParameter ('id', $id);
		// if ($req->has ('rt-view')) {
			// // TODO: RT view engage.
		// } else if ($req->has ('history-view')) {
			// $this->fetchData ($req, $id);
		// } else if ($req->has ('madness')) {
			// $this->fetchData ($req, $id);
		// }
		
		
	}

	function asd () {
		try {
			$query = new \MongoDB\Driver\Query ([]);
			$cursor = \DBConnection::connection ('measurements')->executeQuery ('lorawan.data', $query);
			$durr = null;
			foreach ($cursor as $c) {
				$durr = $c->_id;
				// var_dump ($c, $c->_id instanceof \MongoDB\BSON\ObjectID);
				// echo '<br>';
			}
			$query = new \MongoDB\Driver\Query ([ '_id' => $durr ]);
			$cursor = \DBConnection::connection ('measurements')->executeQuery ('lorawan.data', $query);
			foreach ($cursor as $c) {
				var_dump ('aaaaaaaaaaaaaaa', (string)$c->_id === (string)$durr, $c->_id === $durr, $c, $c->_id instanceof \MongoDB\BSON\ObjectID);
				echo '<br>';
			}
		} catch (\Exception | \Error $e) {
			echo $e->getmessage ();
		}
	}

	public function _post (RequestData $req) : void {
	}

	public function _put (RequestData $req) : void {
	}

	public function _delete (RequestData $req) : void {
	}

}
