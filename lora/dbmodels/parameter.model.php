<?php

namespace Lora\Database;

/**
	A database model class for 
*/
class Parameter extends BaseModel
{

	public const COLLECTION = 'parameters';

	/**
		$name A human friendly name for this Parameter. Usually unabbreviated variation of $quantity is used. This, however 
			is not required.
		$symbol A unit symbol of any of the SI units or the derived SI units without special chracters, such as degree (°) symbol.
			<a href="https://en.wikipedia.org/wiki/SI_base_unit">SI base units</a><br>
			<a href="https://en.wikipedia.org/wiki/SI_derived_unit">SI derived units</a>
		$quantity A three letter abbreviation for a measurable metric used in data transfer. Must be unique among all Parameters.
			Military abbreviations are preferred if such are available. '.' is used a filler character if all possible 
			abbreviations are less than three characters long.
	*/
	protected	$name					= '',
				$symbol					= '',
				$quantity				= '';

	public static function create (string $quantity, string $symbol = '', string $name = '') : ?self {
		$temp					= new self ();
		$temp->newId ();
		$temp->name				= $name;
		$temp->symbol			= $symbol;
		$temp->quantity			= $quantity;
		return $temp->verify () ? $temp : null;
	}

	public static function createToDb (string $quantity, string $symbol = '', string $name = '') : ?self {
		if (($temp = self::create ($quantity, $symbol, $name)) !== null) {
			if (!$temp->toDatabase ()) {
				$temp = null;
			}
		} return $temp;
	}

	public static function fromQuantity (string $quantity) : ?self {
		return self::query ([ 'quantity' => $quantity ], self::class, false);
	}

	public function getId () : \MongoDB\BSON\ObjectID {
		return $this->_id;
	}

	public function verify () : bool {
		$this->valid = $this->_id instanceof \MongoDB\BSON\ObjectID
				&& (empty ($this->symbol) || \SILib::isSymbol ($this->symbol))
				&& \DataLib::text ($this->quantity, 3, 3);
		return $this->valid;
	}

}
