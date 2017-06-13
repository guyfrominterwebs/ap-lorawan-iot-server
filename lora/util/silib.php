<?php

/**
	A library class for working with International System of Units and their derived units.
	<a href="https://en.wikipedia.org/wiki/SI_base_unit">"SI base units</a>
	<a href="https://en.wikipedia.org/wiki/SI_derived_unit">"SI derived units</a>
	NOTE: Fahrenheit is not an SI unit.
*/
abstract class SILib
{

	private static $symbols = [
				"m" => 0,
				"kg" => 0,
				"s" => 0,
				"A" => 0,
				"K" => 0,
				"mol" => 0,
				"cd" => 0
			],
			$derivedSymbols = [
				"Hz" => 0,
				"rad" => 0,
				"sr" => 0,
				"N" => 0,
				"Pa" => 0,
				"J" => 0,
				"W" => 0,
				"C" => 0,
				"V" => 0,
				"F" => 0,
				"Ω" => 0,
				"S" => 0,
				"Wb" => 0,
				"T" => 0,
				"H" => 0,
				"°C" => [
					"C" => 0
				],
				"lm" => 0,
				"lx" => 0,
				"Bq" => 0,
				"Gy" => 0,
				"Sv" => 0,
				"kat" => 0,
			];

			
	private function __construct () {
	}

	public static function isSymbol (string $symbol) : bool {
		return self::isBaseSymbol ($symbol) || self::isDerivedSymbol ($symbol);
	}

	public static function isBaseSymbol (string $symbol) : bool {
		return isset (self::$symbols [$symbol]);
	}

	public static function isDerivedSymbol (string $symbol) : bool {
		if (isset (self::$derivedSymbols [$symbol])) {
			return true;
		}
		foreach (self::$derivedSymbols as $s) {
			if (is_array ($s) && isset ($s [$symbol])) {
				return true;
			}
		} return false;
	}
}
