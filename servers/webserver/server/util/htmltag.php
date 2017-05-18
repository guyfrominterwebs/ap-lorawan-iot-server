<?php

namespace Html;

/**
	An abstract base class for representing HTML tags. Makes certain things 
	easier when working with template engines such as printing comples hyperlinks
	easily.
	\todo Needs improvements and has to better comply HTML structure.
		- Add an array for inner contents.
		- Add utility funtions for certain commonly used attributes such as id and class.
		- A better approach to creating an HTML management system would be to write specialized 
			attribute classes instead of tag classes.
*/
abstract class HtmlTag
{
	protected	$tag			= '',
				$attrs			= [],
				$classes		= [];

	protected function __construct () {
	}

	/**
		\return Returns tag name of this HtmlTag.
	*/
	public function tag () {
		return $this->tag;
	}

	/**
		Checks attribute name and sets it for this HtmlTag if found valid.
		\param $name Name of the attribute.
		\param $value Value of the attribute.
		\return Returns this current instance.
	*/
	public function setAttr (string $name, $value) {
		if (HtmlLib::attrNameCheck ($name)) {
			$this->attrs [$name] = $value;
		}
		return $this;
	}

	/**
		Returns this HtmlTags attributes in either string or array form.
		\param $string A boolean value to determine the return value of this method.
		\return Returns attributes as an array if $string is false and as a string if it is true.
	*/
	public function attrs (bool $string = false) {
		if ($string) {
			$attrs = '';
			foreach ($this->attrs as $name => $value) {
				$attrs .= "${name}=\"${value}\" ";
			} return substr ($attrs, 0, -1);
		} return $this->attrs;
	}

	/**
		A method to print this tag instance as a string.
	*/
	public abstract function print () : string;
}