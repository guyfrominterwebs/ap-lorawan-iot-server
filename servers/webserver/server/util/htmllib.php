<?php

namespace Html;

/**
	An HTML library class to contain various HTML related utility functions.
*/
final class HtmlLib
{

	/**
		Ensures validity of an HTML attribute name.
	*/
	public static function attrNameCheck (string $name) {
		return preg_match ('/^[a-z-]+$/', $name) === 1;
	}
}
