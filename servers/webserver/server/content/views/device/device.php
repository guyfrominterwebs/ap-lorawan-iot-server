<?php

namespace Lora\Content;

use \Lora\DAO as DAO;
use \RequestData;

final class Content_Device extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		if ($req->readString ('id', $id)) {
			$this->mess->addData ($id, $this->name);
			$devices = DAO::fetchDevices ([ '_id' => $id ]);
			if (count ($devices) === 1) {
				$this->page->addGlobal ('devices', $devices);
			}
		}
		$this->page->addSubViewParameter ('id', $id);
		if ($req->has ('rt-view')) {
			// TODO: RT view engage.
		} else if ($req->has ('history-view')) {
			$this->fetchData ($req, $id);
		} else if ($req->has ('madness')) {
			$this->fetchData ($req, $id);
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
