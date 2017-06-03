<?php

namespace Lora\Database;

/**
	A base class for all database models. Declares static, instance and abstract methods.
	Late static binding (LSB), introduced in PHP 5.3.0, is used extensively by this class and 
	all classes which inherit from it. <a href="http://php.net/manual/en/language.oop5.late-static-bindings.php">Late static binding</a>
	
*/
abstract class BaseModel implements \MongoDB\BSON\Unserializable
{

	protected	$_id					= null,
				$valid					= true;

	/*
		Abstract methods to ensure data consistency.
	*/

	/**
		Inspects the object's integrity to verify that it is in valid state.
		\return Returns true if the object is in a valid state and false otherwise.
	*/
	public abstract function verify () : bool;

	/*
		Static utility land
	*/

	/**
		Creates a dummy object from any class which inherits from this class using LSB.
		Use only for debuggin unless there is a very good reasons to do otherwise.
		\return An instance of a class which was useddto call this method.
	*/
	public static function dummy () : self {
		return new static ();
	}

	/**
		Attempts to fetch an object from database by id value. The type of the returned object is defined by LSB.
		\param $id An id to match against.
		\return Returns an instance of a class which was used to call this method or null on failure.
	*/
	public static function fromId ($id) : ?self {
		return self::query ([ '_id' => $id ], static::class, false);
	}

	/**
		Attempts to fetch an object from database by name but only if the class used to call this method has a property called name.
		\param $name Name of the object to fetch.
		\return Returns an instance of a class which was used to call this method or null on failure.
	*/
	public static function fromName (string $name) : ?self {
		return property_exists (static::class, 'name') ? self::query ([ 'name' => $name ], static::class, false) : null;
	}

	public static function fetchAll () : array {
		return self::query ([], static::class, true);
	}

	protected static function query (array $filter, string $modelClass, bool $many) {
		$object = null;
		try {
			$query = new \MongoDB\Driver\Query ($filter);
			$cursor = \DBConnection::connection ('measurements')->executeQuery (self::collection ($modelClass::COLLECTION), $query);
			$cursor->setTypeMap ([ 'root' => $modelClass ]);
			$result = $cursor->toArray ();
		} catch (\Exception | \Error $e) {
		}
		if ($many) {
			$object = $result;
		} else if (count ($result) === 1) {
			$object = $result [0];
		}
		return $object;
	}
	/**
		Creates a full collection name/namespace for mongodb using static::$collection member or $collection, if it is not empty.
		\param $collection An optional collection name.
		\return A full collection name to a mongodb collection.
	*/
	public static function collection (string $collection = '') : string {
		return \DBConnection::dbName ('measurements').'.'.(empty ($collection) ? static::COLLECTION : $collection);
	}

	/**
		Returns an associative of class's property names and their values which are database fields.
		\param $exclude An array of field names to be excluded from the result.
		\return An associative array of database fields properties and their values.
	*/
	public static function fields (array $exclude = []) : array {
		$fields = [];
		foreach ((new \ReflectionClass (static::class))->getProperties (\ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE) as $field) {
			if (!$field->isStatic () && strlen ($field->name) > 2 && $field->name [1] !== '_' && !in_array ($field->name, $exclude)) {
				$fields [] = $field->name;
			}
		}
		return $fields;
	}

	/*
		Member functions a.k.a. methods.
	*/

	protected function newId () : \MongoDB\BSON\ObjectId {
		return $this->_id = new \MongoDB\BSON\ObjectId ();
	}

	/**
		Checks if this object is in valid state. Perform an integrity if required.
		\return Returns true if this object is in valid state and false if not.
	*/
	protected function isValid () : bool {
		return $this->valid = !$this->valid ? $this->verify () : $this->valid;
	}
	/**
		Implements \MongoDB\BSON\Unserializable::bsonUnserialize. 
		Used to populate this instance with the provided associative $data array.
		Sets unserialized flag to true.
		\param $data An associative array containing single document's data fetched from a mongodb collection.
	*/
	public function bsonUnserialize (array $data) : void {
		foreach (self::fields () as $field) {
			if (isset ($data [$field])) {
				$this->$field = $data [$field];
			}
		}
		$this->unserialized = true;
	}

	/**
		Writes this object's values to the database by either updating an existing entry or inserting a new one.
		Only objects with valid state are written. See BaseModel::verify () for more information.
		\return Returns true on succesful insert or update and false on error.
	*/
	public function toDatabase () : bool {
		if (!$this->valid) {
			try {
				$writer = new \MongoDB\Driver\BulkWrite ([ 'ordered' => false ]);
				$writer->update ([ '_id' => $this->_id ], $this->toArray (), [ 'upsert' => true, 'multi' => false ]);
				$result = \DBConnection::connection ('measurements')->executeBulkWrite (self::collection (), $writer);
				return $result->getUpsertedCount () > 0 || $result->getMatchedCount () > 0;
			} catch (\Exception | \Error $e) {
			}
		} return false;
	}

	/**
		Creates an associative array with database fields of this object as keys and values from those fields.
		\param $exclude An array of field names to exclude from the result.
		\return An associative array of this objects database fields.
	*/
	public function toArray (array $exclude = []) : array {
		$result = [];
		foreach (self::fields ($exclude) as $field) {
			$result [$field] = $this->$field;
		} return $result;
	}

}
