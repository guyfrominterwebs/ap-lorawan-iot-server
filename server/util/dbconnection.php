<?php

final class DBConnection
{
	private const MONGO = 1;
	private const MYSQL = 2;

	private static $instance = null;

	private $connections = [
				'measurements' => [
					"type"			=> DBConnection::MONGO,
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

	private static function obj () {
		return self::$instance ?? (self::$instance = new DBConnection ());
	}

	public static function connection (string $db) {
		$obj = self::obj ();
		if (isset ($obj->connections [$db])) {
			return $obj->connect ($obj->connections  [$db]);
		} return null;
	}

	private function connect (array &$db) {
		if ($db ['connection'] !== null) {
			return $db ['connection'];
		}
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

	private function mongoConnect (&$db) {
		// 'user' => isset ($db ['user']) ? $db ['user'] : '',
		// 'pass' => isset ($db ['pass']) ? $db ['pass'] : '',
		return $db ['connection'] = new \MongoDB\Driver\Manager ("mongodb://{$db ['host']}:{$db ['port']}");
	}

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
