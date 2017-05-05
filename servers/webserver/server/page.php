<?php

namespace Lora;

final class Page
{

	private $_path			= '',
			$_template 		= 'default_template',
			$_layout		= 'default_layout',
			$_view			= 'home',
			$_libraries 	= [],
			$_scripts		= [],
			$_block			= [],
			$_styles		= [ 'main' ],
			$_settings		= [];

	public function __construct () {
		$this->_path = Config::path ('server', 'pages')."/views/";
	}

	public function loadView (string $view) : bool {
		$this->_view = $view;
		$file = "{$this->_path}{$this->_view}/view.".Config::ext ('server', 'page');
		if (file_exists ($file)) {
			if (($config = @parse_ini_file ($file, true, INI_SCANNER_TYPED)) === false && ($config = @json_decode (file_get_contents ($file), true)) === false) {
				return false;
			}
		}
		$property = '';
		foreach ($this->configurableFields () as $member) {
			$property = substr ($member, 1);
			if (isset ($config [$property]) && gettype ($config [$property]) === gettype ($this->$member)) {
				$this->$member = $config [$property];
			}
		}
		return true;
	}

	public function addScript (string $script) : void {
		if (!in_array ($script, $this->_scripts)) {
			$this->_scripts [] = $script;
		}
	}

	public function addLibrary (string $lib) : void {
		if (!in_array ($lib, $this->_libraries)) {
			$this->_libraries [] = $lib;
		}
	}

	public function setDetail ($detail, string $key) : void {
		$this->_settings [$key] = $detail;
	}

	public function show (string $subView) : void {
		$this->_settings ['show'] = $subView;
	}

	public function settings () : array {
		return $this->_settings;
	}

	public function path () : string {
		return "{$this->_path}/{$this->_view}";
	}

	public function template () : string {
		return $this->_template = $this->checkExtension ($this->_template, Config::ext ('twig', 'twig'));
	}

	public function layout () : string {
		return $this->_layout = $this->checkExtension ($this->_layout, Config::ext ('twig', 'twig'));
	}

	public function content () : string {
		return $this->_content = $this->checkExtension ("content", Config::ext ('twig', 'twig'));
	}

	public function scripts () : array {
		foreach ($this->_scripts as &$script) {
			$script = $this->checkExtension ($script, 'js');
		} return $this->_scripts;
	}

	public function styles () : array {
		foreach ($this->_styles as &$style) {
			$style = $this->checkExtension ($style, 'css');
		} return $this->_styles;
	}

	public function libraries () : array {
		foreach ($this->_libraries as &$lib) {
			$lib = $this->checkExtension ($lib, 'js');
		} return $this->_libraries;
	}

	public function debug () : bool {
		return \debug ();
	}

	private function checkExtension (string $file, string $extension) : string {
		if (!isset (pathinfo ($file) ['extension'])) {
			return "{$file}.{$extension}";;
		} return $file;
	}

	private function configurableFields (array $exclude = []) {
		return array_filter (
			array_map (function ($field) { return $field->name; }, (new \ReflectionClass ($this))->getProperties ()),
			function ($field) use ($exclude) {
				return @$field [0] === '_' && !in_array ($field, $exclude); }
		);
	}
}
