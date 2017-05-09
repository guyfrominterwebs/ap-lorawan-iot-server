<?php

namespace Html;

final class Link extends HtmlTag
{

	private $text			= '',
			$refs 			= '',
			$params 		= [],
			$attrs 			= [],
			$classes		= [];

	public function __construct (string $text = '', string $ref = '', array $params = [], array $attrs = [], array $classes = []) {
		$this->tag 			= 'a';
		$this->text			= $text;
		$this->refs 		= $ref;
		$this->params 		= $params;
		$this->attrs 		= $attrs;
		$this->classes		= $classes;
	}

	public function tag () {
		return $this->tag;
	}

	public function print () {
		return "<{$this->tag} href=\"".$this->href ()."\" ".$this->attrs (true).">{$this->text}</{$this->tag}>";
	}

	public function href (string $ref = '') {
		if (empty ($ref)) {
			$params = $this->params (true);
			return \Lora\Config::get ('client', 'pages')."{$this->refs}".(!empty ($params) ? "?${params}" : '');
		}
		$this->refs = $ref;
		return $this;
	}

	public function text (string $text = '') {
		if (empty ($text)) {
			return $this->text;
		}
		$this->text = $text;;
		return $this;
	}

	public function setParam (string $name, $value) : Link {
		$this->params [$name] = $value;
		return $this;
	}

	public function params (bool $string = false) {
		return $string ? \Lib::arrayToString ($this->params, '&', true, '=') : $this->params;
	}

	public function setAttr (string $name, $value) : Link {
		if (Html::attrNameCheck ($name)) {
			$this->attrs [$name] = $value;
		}
		return $this;
	}

	public function attrs (bool $string = false) {
		if ($string) {
			$attrs = '';
			foreach ($this->attrs as $name => $value) {
				$attrs .= "${name}=\"${value}\" ";
			} return substr ($attrs, 0, -1);
		} return $this->attrs;
	}

	public function addClass (string $class) {
		$this->classes [] = $class;
		return $this;
	}

	public function classes (bool $string = false) {
		return $string ? \Lib::arrayToString ($this->classes, ' ') : $this->classes;
	}
}
