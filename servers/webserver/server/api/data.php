<?php

namespace Lora\Api;

use \RequestData;

final class Action_Data extends \Lora\BaseAction
{

	public function _get (RequestData $req) : void {
		if ($req->has ('search')) {
			$this->search ($req);
		} else {
			# Just somee test code.
			try {
				$manager = \DBConnection::connection ('measurements');
				// $manager = new \MongoDB\Driver\Manager ("mongodb://localhost:27017");
				$query = new \MongoDB\Driver\Query ([]);
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

	private function search (RequestData $req) {
		$req->readString ('device', $device);
		$req->readInt ('start', $start, -1);
		$req->readInt ('end', $end, -1);
		$filter = [];
		if ($device !== null) {
			$filter ['dev_id'] = [ '$eq' => $device ];
		}
		if ($start !== -1) {
			$filter ['time']['$gte'] = $start;
		}
		if ($end !== -1 && $end > $start) {
			$filter ['time']['$lte'] = $end;
		}
		$manager = DBConnection::connect ('measurements');
		// $manager = new \MongoDB\Driver\Manager ("mongodb://localhost:27017");
		$query = new \MongoDB\Driver\Query ($filter);
		$cursor = $manager->executeQuery ('lorawan.data', $query);
		$this->mess->addData ($cursor->toArray ());
	}
}
