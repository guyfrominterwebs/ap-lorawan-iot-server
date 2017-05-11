<?php

namespace Lora;

final class PageComponent
{

	private $_id			= '',
			$_template		= '',
			$_libraries 	= [],
			$_scripts		= [],
			$_styles		= [],
			$_classes		= [];

	private function __construct (string $component) {
	}

	public static function Create (string $component) {
		$temp 				= new PageComponent ($component);
		$twig 				= \Lib::checkExtension ($component, Config::ext ('twig', 'twig'));
		$definition 		= \Lib::checkExtension ($component, Config::ext ('server', 'component'));
		$folder 			= Config::path ('server', 'components');
		$file 				= "$folder/$definition";
		if (file_exists ($file)) {
			if (empty ($config = $temp->parseFile ($file)) || !$temp->inspectConfig ($config)) {
				return null;
			}
			$temp->_id = $config ['id'];
			$temp->_template = $config ['template'];
			$temp->populate ($config ['dependencies']);
			$temp->populate ($config ['appearance']);
		} else {
			if (file_exists ($file = "$folder/$twig")) {
				$this->_template = $file;
				$this->_id = pathinfo ($component, PATHINFO_FILENAME);
			}
		}
		return $temp;
	}

	public function id () {
		return $this->_id;
	}

	public function setTemplate (string $template) : void {
		$this->_template = $template;
	}

	public function template () : string {
		return $this->_template = \Lib::checkExtension ($this->_template, Config::ext ('twig', 'twig'));
	}

	public function addScript (string $script) : void {
		if (!in_array ($script, $this->_scripts)) {
			$this->_scripts [] = $script;
		}
	}

	public function scripts () : array {
		foreach ($this->_scripts as &$script) {
			$script = \Lib::checkExtension ($script, 'js');
		} return $this->_scripts;
	}

	public function addLibrary (string $lib) : void {
		if (!in_array ($lib, $this->_libraries)) {
			$this->_libraries [] = $lib;
		}
	}

	public function libraries () : array {
		foreach ($this->_libraries as &$lib) {
			$lib = \Lib::checkExtension ($lib, 'js');
		} return $this->_libraries;
	}

	public function styles () : array {
		foreach ($this->_styles as &$style) {
			$style = \Lib::checkExtension ($style, 'css');
		} return $this->_styles;
	}

	public function classes (bool $string = false) {
		if ($string) {
			$classes = '';
			foreach ($this->_classes as $c) {
				$classes .= "$c ";
			} return $classes;
		} return $this->_classes;
	}

	private function configurableFields (array $exclude = []) {
		return array_filter (
			array_map (function ($field) { return $field->name; }, (new \ReflectionClass ($this))->getProperties ()),
			function ($field) use ($exclude) {
				return @$field [0] === '_' && !in_array ($field, $exclude); }
		);
	}

	private function parseFile (string $file) : array {
		if (empty ($config = @parse_ini_file ($file, true, INI_SCANNER_TYPED)) && empty ($config = @json_decode (file_get_contents ($file), true))) {
			return [];
		}
		return $config;
	}

	private function inspectConfig (array $config) : bool {
		# TODO?: Type checks
		return isset ($config ['id'], $config ['template'], $config ['dependencies'], $config ['appearance']);
	}

	private function populate (array $values) : void {
		foreach ($this->configurableFields () as $member) {
			$property = substr ($member, 1);
			if (isset ($values [$property]) && gettype ($values [$property]) === ($type = gettype ($this->$member))) {
				$this->$member = $values [$property];
			}
		}
	}
}
