<?php

/**
	An enclosed singleton class accessible through static wrapper methods for managing 
	active database connections. Keeps connections alive to reduce overhead which would 
	otherwise occure if a new connection were to be opened for every query. Holds all 
	database credentials and connection information.
	\todo Move database access credentials to external file.
*/

final class DBConnection
{
	private const MONGO = 1;
	private const MYSQL = 2;

	private static $instance = null;

	private $connections = [ ///< $connections holds all available database credentials.
				'measurements' => [
					"type"			=> DBConnection::MONGO,
					"databasename"	=> "lorawan",
					"host" 			=> "localhost",
					"port" 			=> "27017",
					"connection"	=> null
				]
				/*
				'something' => [
					"type"			=> DBConnection::MYSQL,
					"host"			=> "",
					"port"			=> "",
					"user"			=> "",
					"password"		=> "",
					"database"		=> "",
					"connection"	=> null
					
				]
				*/
			];

	private function __construct () {
	}

	/**
		\return Returns a singleton instance of this class which is created upon first call to this method.
	*/
	private static function obj () {
		return self::$instance ?? (self::$instance = new DBConnection ());
	}

	/**
		Attempts to retrieve a database connection or create one if it has not been extablished yet.
		\return Returns a database connection object which may vary from database to database.
			For older and commonly used databases, <a href="http://php.net/manual/en/class.pdo.php">PDO</a> is used when ever possible.
			For MongoDB, a <a href="http://php.net/manual/en/class.mongodb-driver-manager.php">\Mongp\Driver\Manager</a> is returned.
			Null is returned if database credentials are not found or connection establishing fails.
	*/
	public static function connection (string $db) {
		$obj = self::obj ();
		if (isset ($obj->connections [$db])) {
			return $obj->connect ($obj->connections [$db]);
		} return null;
	}

	public static function dbName (string $db) : string {
		$obj = self::obj ();
		if (isset ($obj->connections  [$db])) {
			return $obj->connections [$db]['databasename'];
		} return '';
	}

	private function connect (array &$db) {
		if ($db ['connection'] !== null) {
			return $db ['connection'];
		}
		/**
			\todo Automatize database type fetching so that this switch statement does not require updating everytime a new database type is added.
		*/
		switch ($db ['type']) {
			case DBConnection::MONGO:
					return $this->mongoConnect ($db);
				break;
			case DBConnection::MYSQL:
					return $this->mysqlConnect ($db);
				break;
			default: return null;
		}
	}

	/**
		Connect to a MongoDB -database.
	*/
	private function mongoConnect (&$db) {
		// 'user' => isset ($db ['user']) ? $db ['user'] : '',
		// 'pass' => isset ($db ['pass']) ? $db ['pass'] : '',
		return $db ['connection'] = new \MongoDB\Driver\Manager ("mongodb://{$db ['host']}:{$db ['port']}");
	}

	/**
		Connect to a MySQL -database.
	*/
	private function mysqlConnect (&$db) {
		$pdo = null;
		try {
			$pdo = new PDO ("mysql:host={$db ['host']};dbname={$db ['database']};port={$db ['port']}", $db ['user'], $db ['password']);
			$pdo->setAttribute (PDO::ATTR_STRINGIFY_FETCHES, false);
			$pdo->setAttribute (PDO::ATTR_EMULATE_PREPARES, false);
			$pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			// $pdo->errorCode () === '00000' => success
			// echo 'Connection failed: ' . $e->getMessage();
			$pdo = null;
		} return $db ['connection'] = $pdo;
	}
}
