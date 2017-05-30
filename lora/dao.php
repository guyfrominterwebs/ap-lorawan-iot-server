<?php

/*
	A DAO for mongo db.
*/

namespace Lora;

abstract class DAO
{

	/**
		Returns an array containing all devices found in the database.
		\param $projection An optional projection parameter to define the fields which are fetched for each device
		\return An array containing all the devices with fields defined by projection. An empty array is returned in case of an error.
	*/
	public static function fetchDevices (array $projection = []) {
		$result = [];
		try {
			$manager = \DBConnection::connection ('measurements');
			$query = new \MongoDB\Driver\Query ([], [ 'projection' => $projection ]);
			$cursor = $manager->executeQuery ('lorawan.devices', $query);
			$result = $cursor->toArray ();
		} catch (\Exception $e) {
		}
		return $result;
	}

	/**
		\return Returns a boolean indiciation existence of a device. Null is returned is query failed.
	*/
	public static function deviceExist (string $device_id) : ?bool {
		try {
			$manager = \DBConnection::connection ('measurements');
			$command = new \MongoDB\Driver\Command ([
				'count' => 'devices',
				'query' => [
					'_id' => $device_id
				]
			]);
			$cursor = $manager->executeCommand ('lorawan', $command);
			return $cursor->toArray ()[0]->n === 1;
		} catch (Exception $e) {
		}
		return null;
	}

	/**
		Insert a new measurement set for a device.
		\param $device_id Hardware id of the device.
		\param $time Unix timestamp in seconds.
		\param $measurement Measurement data in parsed form.
		\return Returns true on succesful insert, false otherwise.
	*/
	public static function insertMeasurement (string $device_id, int $time, array $measurements) : bool {
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

	/**
		Insert a new device or update an existing one.
		\param $device Device hardware id.
		\return True on success, false on error.
	*/
	public static function insertDevice (string $device) : bool {
		try {
			# Insert device information or update existing.
			$manager = \DBConnection::connection ('measurements');
			$writer = new MongoDB\Driver\BulkWrite ([ 'ordered' => true ]);
			$writer->update ([ '_id' => $device ['dev']['_id'] ], $device ['dev'], [ 'upsert' => true ]);
			$result = $manager->executeBulkWrite ('lorawan.devices', $writer);
		} catch (Exception $e) {
			return false;
		} return true;
	}

	/**
		Stores raw data from sensor nodes for archiving and inspection purposes.
		\return True on success, false on error.
	*/
	public static function insertRaw (array $raw) : bool {
		try {
			# Insert whole data blob for archiving purposes
			$manager = \DBConnection::connection ('measurements');
			$writer = new MongoDB\Driver\BulkWrite ([ 'ordered' => true ]);
			$writer->insert ($raw);
			$result = $manager->executeBulkWrite ('lorawan.raw_data', $writer);
		} catch (Exception $e) {
			return false;
		} return true;
	}

}
