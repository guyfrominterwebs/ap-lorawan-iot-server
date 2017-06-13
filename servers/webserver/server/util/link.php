<?php

namespace Html;

/**
	A class to represent an HTML hyperlink. Makes creating and managing hyperlinks in twig 
	easier by a magnitude.
	Can be used as an anchor tag aswell.
*/
final class Link extends HtmlTag
{

	private $text			= '',
			$refs 			= '',
			$params 		= [];

	public function __construct (string $text = '', string $ref = '', array $params = [], array $attrs = [], array $classes = []) {
		$this->tag 			= 'a';
		$this->text			= $text;
		$this->refs 		= $ref;
		$this->params 		= $params;
		$this->attrs 		= $attrs;
		$this->classes		= $classes;
	}

	/**
		Print implementation for HTML anchor tag. Overrides HtmlTag::print.
		\return Returns a string representation of an HTML link.
	*/
	public function print (string $webroot = '/') : string {
		return "<{$this->tag} href=\"${webroot}".$this->href ()."\" ".$this->attrs (true).">{$this->text}</{$this->tag}>";
	}

	/**
		Set or get the target location of this Link. If $ref is empty, this method returns a fully constructed hyper reference string.
		\param $ref Target location or an anchor.
		\return Returns this Link instance if $ref is not empty and a string representation of the target if it is empty.
	*/
	public function href (string $ref = '') {
		if (empty ($ref)) {
			$params = $this->params (true);
			return \Lora\Config::get ('client', 'pages')."{$this->refs}".(!empty ($params) ? "?${params}" : '');
		}
		$this->refs = $ref;
		return $this;
	}

	/**
		Sets or gets the inner text of this Link. If $text is empty, current Link::$text is returned. If not, $text replaces current Link::$text.
		\param $text An optional new text for this Link.
		\return Returns this Link if $text is not empty and Link::$text if it is empty.
	*/
	public function text (string $text = '') {
		if (empty ($text)) {
			return $this->text;
		}
		$this->text = $text;;
		return $this;
	}

	/**
		Adds a new or overrides an existing hyper link parameter pair.
		\param $name Name of the paramter.
		\param $value Value of the parameter.
		\return Returns this Link object.
	*/
	public function setParam (string $name, $value) : Link {
		$this->params [$name] = $value;
		return $this;
	}

	/**
		Returns all the parameters this Link has as a string or an array.
		\param $string A boolean value to determine the return value of this method.
		\return Returns an array of parameter values if $string is false and a string presentation of them if it is true.
	*/
	public function params (bool $string = false) {
		return $string ? \Lib::arrayToString ($this->params, '&', true, '=') : $this->params;
	}

	/**
		Adds a new css class to this HtmlTag.
		\param $class Name of the css class to be added.
		\return Returns this HtmlTag.
	*/
	public function addClass (string $class) {
		$this->classes [] = $class;
		return $this;
	}

	/**
		Returns all classes this HtmlTag has as a string or an array.
		\param $string A boolean value to determine the reutrn value of this method.
		\return Returns an array of parameter values if $string is false and a string presentation of them if it is true.
	*/
	public function classes (bool $string = false) {
		return $string ? \Lib::arrayToString ($this->classes, ' ') : $this->classes;
	}
}
