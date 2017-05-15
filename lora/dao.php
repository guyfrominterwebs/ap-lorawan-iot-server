<?php

/*
	A DAO for mongo db.
*/

class DAO
{

	public static function deviceExist (string $device_id) : ?bool {
		try {
			$filter = [ '_id' => $device_id ];
			$manager = \DBConnection::connection ('measurements');
			$command = new \MongoDB\Driver\Command ([ 'count' => 'devices', 'query' => $filter ]);
			$cursor = $manager->executeCommand ('lorawan', $command);
			return $cursor->toArray ()[0]->n === 1;
		} catch (Exception $e) {
		}
		return null;
	}

	public static function insertMeasurement (string $device_id, $measurements) {
		try {
			# Insert parsed measurement data for actual use.
			$manager = \DBConnection::connection ('measurements');
			$writer = new MongoDB\Driver\BulkWrite ([ 'ordered' => true ]);
			$writer->insert ([ 'device' => $device_id, $measurements ]);
			$result = $manager->executeBulkWrite ('lorawan.data', $writer);
		} catch (Exception $e) {
			return false;
		} return true;
	}

}
