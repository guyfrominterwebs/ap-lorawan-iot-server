<?php

namespace Html;

final class Html
{

	public static function link () {
		return new Link ();
	}

	public static function attrNameCheck (string $name) {
		return preg_match ('/^[a-z-]+$/', $name) === 1;
	}
}
