<?php

/*
	A DAO for mongo db.
*/

class DAO
{

	public static function deviceExist (string $device_id) {
		/*
			db.devices.find ({ _id: "myId" }, { _id: 1 }).limit (1)
		*/
		$filter = [ '_id' => $device_id ];
		$manager = \DBConnection::connection ('measurements');
		
	}

}
