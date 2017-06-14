<?php

namespace Lora\Content;

use \Lora\DAO,
	\RequestData;
use \Lora\Database\{
		Device
	};

final class Content_Device extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		if ($req->readString ('id', $id)) {
			$this->mess->addData ($id, $this->name);
			$device = Device::fromId ($id);
			if ($device !== null) {
				$this->page->addGlobal ('devices', [ $device->toArray ([], true) ]);
			}
		}
		$this->page->addSubViewParameter ('id', $id);
		if ($req->has ('rt-view')) {
			// TODO: RT view engage.
		} else if ($req->has ('history-view')) {
			if ($device !== null) {
				$this->mess->addData ($device->fetchData ());
			}
			// $this->fetchData ($req, $id);
		} else if ($req->has ('madness')) {
			if ($device !== null) {
				$this->mess->addData ($device->fetchData ());
			}
			// $this->fetchData ($req, $id);
		}
	}

	public function _post (RequestData $req) {
	}

	public function _put (RequestData $req) {
	}

	public function _delete (RequestData $req) {
	}

	private function fetchData (RequestData $req, $id) {
		$limit = 1000;
		if ($req->readInt ('index', $start, 0)) {
			
		}
		$filter = [
			'device_id' => $id
		];
		$options = [
			'projection' => [
				'_id' => 0,
				'payload' => 1,
				'time' => 1
			],
			'sort' => [
				'time' => 1
			],
			'limit' => $limit,
			'skip' => $start
		];
		$manager = \DBConnection::connection ('measurements');
		$query = new \MongoDB\Driver\Query ($filter, $options);
		$cursor = $manager->executeQuery ('lorawan.data', $query);
		// db.coll.find(queryDoc).sort(sortDoc).skip(x).limit(y)
		// $cursor->skip ();
		$this->mess->addData ($cursor->toArray ());
	}

}
