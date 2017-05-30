<?php

namespace Lora\Api;

use \RequestData;

final class Action_Device extends \Lora\BaseAction
{

	public function _get (RequestData $req) : void {
		if (!$req->readString ('id', $id)) {
			return;
		}
		if ($req->has ('data')) {
			$this->getData ($req, $id);
		} else {
			# Just somee test code.
			try {
				$manager = \DBConnection::connection ('measurements');
				// $manager = new \MongoDB\Driver\Manager ("mongodb://localhost:27017");
				$query = new \MongoDB\Driver\Query ([ 'device_id' => $id ]);
				$cursor = $manager->executeQuery ('lorawan.data', $query); // $mongo contains the connection object to MongoDB
				// $this->mess->addData ($cursor->toArray ());
				\Lib::dump ($cursor->toArray ());
			} catch (\Exception $e) {
				var_dump ($e->getMessage ());
				$this->mess->error ($e->getMessage ());
			}
			// $this->mess->addData ($req->getInt ('asd', 0));
		}
	}

	public function _post (RequestData $req) : void {
		$this->mess->addData ('Post test.');
	}

	public function _put (RequestData $req) : void {
		$this->mess->addData ('Put test.');
	}

	public function _delete (RequestData $req) : void {
		$this->mess->addData ('Delete test.');
	}

	private function getData (RequestData $req, string $id) {
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
