<?php

namespace Html;

abstract class HtmlTag
{
	protected	$tag			= '',
				$attrs			= [],
				$classes		= [];

	protected function __construct () {
	}
}