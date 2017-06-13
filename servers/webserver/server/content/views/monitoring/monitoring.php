<?php

namespace Lora\Content;

use \Lora\DAO as DAO;
use \Lora\Database\{
	Device,
	Parameter,
	MonitoringTarget,
	DeviceSensor
};
use \RequestData;

final class Content_Monitoring extends \Lora\BaseAction
{

	protected function _get (RequestData $req) : void {
		if ((count ($this->url) > 0 && $this->url [0] === 'monitor-wizard') || $req->has ('monitor-wizard')) {
			$this->page->showSingle ('monitor-wizard');
			$this->_post ($req);
			return;
		}
		if ($req->readString ('id', $id) && ($target = MonitoringTarget::fromId ($id)) !== null) {
			$devices = [];
			foreach ($target->fetchDevices () as $device) {
				$devices [] = $device->toArray ([], true);
			}
			$this->page->showSingle ('monitoring-area');
			$this->mess->addData ($target, 'area');
			$this->mess->addData ($devices, 'devices');
			$this->page->addGlobal ('area', $target->toArray ([], true));
		} else {
			$targets = MonitoringTarget::fetchAll ();
			$this->mess->addData ($targets, 'areas');
		}
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

	protected function _post (RequestData $req) : void {
		$req->readInt ('step', $step, 0);
		switch ($step) {
			case 0:
					$step = $this->createTarget ($req);
				break;
			case 1:
					$step = $this->addDevices ($req);
				break;
		}
		$this->mess->addData ($step, 'phase');
	}

	protected function _put (RequestData $req) : void {
	}

	protected function _delete (RequestData $req) : void {
		if ($req->readString ('id', $target) && $req->readString ('device', $device)) {
			$target = MonitoringTarget::fromId ($target);
			$device = Device::fromId ($device);
			if ($target !== null && $device !== null) {
				if ((string)$device->getTargetId () === (string)$target->getId ()) {
					$device->removeTarget ();
					$device->toDatabase ();
				}
			}
		}
		$this->_get ($req);
	}

	private function createTarget (RequestData $req) : int {
		# Read parameters from request
		if (!$req->readString ('name', $name) || empty ($name)) {
			if ($req->has ('step')) {
				$this->mess->addData ('Could not create new monitoring area; no name given.', 'error');
			}
			return 1;
		}
		# Check parameter validity
		if (MonitoringTarget::fromName ($name) !== null) {
			$this->mess->addData ("Could not create new monitoring area; an area called \"${name}\" already exists.", 'error');
			return 1;
		}
		# Process parameters
		$target = MonitoringTarget::create ($name);
		if (!$target->toDatabase ()) {
			$this->mess->addData ('Could not create new monitoring area.', 'error');
			return 1;
		}
		# Add data required for the form.
		$devices = [];
		foreach (Device::fetchFree () as $dev) {
			$devices [] = $dev->toArray ([], true);
		}
		$this->mess->addData ($target->toArray ([], true), 'target');
		$this->mess->addData ($devices, 'devices');
		return 2;
	}

	private function addDevices (RequestData $req) : int {
		# Read parameters from request
		$req->readString ('area', $targetId, '');
		$devices = $req->getArray ('devices');
		# Check parameter validity
		if (($target = MonitoringTarget::fromId ($targetId)) === null) {
			$this->mess->addData ('Could not add devices; invalid area.', 'error');
			return 2;
		}
		# Process parameters
		$devs = [];
		foreach ($devices as $dev) {
			if (($temp = Device::fromId ($dev)) !== null) {
				if ($temp->setTarget ($target)) {
					$temp->toDatabase ();
				}
			}
		}
		# Add data required for the form.
		$this->mess->addData ($target->toArray ([], true), 'target');
		$devices = [];
		foreach (Device::fetchFree () as $dev) {
			$devices [] = $dev->toArray ([], true);
		}
		$this->mess->addData ($devices, 'devices');
		# Something
		$this->mess->addData (MonitoringTarget::fetchAll (), 'areas');
		if (!$req->has ('devices')) {
			return 2;
		}
		return 3;
	}
}
