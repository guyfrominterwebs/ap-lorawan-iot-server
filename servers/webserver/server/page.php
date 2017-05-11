<?php

namespace Lora;

final class Page
{

	private $view			= '',
			$_path			= '',
			$_template 		= 'default_template',
			$_layout		= 'default_layout',
			$_libraries 	= [],
			$_scripts		= [],
			$_block			= [],
			$_styles		= [ 'main' ],
			$_settings		= [],
			$_globals		= [],
			$views 			= [],
			$static			= false;

	public function __construct () {
		$this->_path = Config::path ('server', 'pages')."/views/";
	}

	public function name () : string {
		return $this->view;
	}

	public function show (string $view, bool $show) {
		if (isset ($this->views [$view])) {
			$this->views [$view]->show ($show);
		}
	}

	public function showSingle (string $view) {
		foreach ($this->views as $v) {
			$v->show (false);
		}
		$this->views [$view]->show (true);
	}

	public function markStatic () {
		$this->static = true;
	}

	public function isStatic () {
		return $this->static;
	}

	public function addView (PageView $view) : void {
		$this->views [$view->id ()] = $view;
	}

	public function addViews (array $views) : void {
		if (\DataLib::AreInstanceOf ($view, PageView::class)) {
			foreach ($views as $v) {
				$this->view [$v->id ()] = $v;;
			}
		}
	}

	public function subViews () : array {
		return $this->views;
	}

	public function addScript (string $script) : void {
		if (!in_array ($script, $this->_scripts)) {
			$this->_scripts [] = $script;
		}
	}

	public function scripts () : array {
		foreach ($this->views as $view) {
			foreach ($view->components () as $comp) {
				$this->_scripts = array_unique (array_merge ($this->_scripts, $comp->scripts ()));
			}
		}
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
		foreach ($this->views as $view) {
			foreach ($view->components () as $comp) {
				$this->_libraries = array_unique (array_merge ($this->_libraries, $comp->libraries ()));
			}
		}
		foreach ($this->_libraries as &$lib) {
			$lib = \Lib::checkExtension ($lib, 'js');
		} return $this->_libraries;
	}

	public function addGlobal (string $name, $val) : void {
		if (preg_match ("/^[a-z_]+$/i", $name) === 1) {
			$this->_globals [$name] = [ is_scalar ($val), gettype ($val), $val ];
		}
	}

	public function globals () : array {
		/*
		# Might be used later. Components require a way to define global values and there has to be a system for them to request such values.
			foreach ($this->views as $view) {
				foreach ($view->components () as $comp) {
					$this->_globals = array_merge ($this->_globals, $comp->globals ());
				}
			}
		*/
		return $this->_globals;
	}

	public function setSetting ($detail, string $key) : void {
		$this->_settings [$key] = $detail;
	}

	public function settings () : array {
		return $this->_settings;
	}

	public function path () : string {
		return "{$this->_path}/{$this->view}";
	}

	public function template () : string {
		return $this->_template = \Lib::checkExtension ($this->_template, Config::ext ('twig', 'twig'));
	}

	public function layout () : string {
		return $this->_layout = \Lib::checkExtension ($this->_layout, Config::ext ('twig', 'twig'));
	}

	public function content () : string {
		return $this->_content = \Lib::checkExtension ("content", Config::ext ('twig', 'twig'));
	}

	public function styles () : array {
		foreach ($this->views as $view) {
			foreach ($view->components () as $comp) {
				$this->_styles = array_unique (array_merge ($this->_styles, $comp->styles ()));
			}
		}
		foreach ($this->_styles as &$style) {
			$style = \Lib::checkExtension ($style, 'css');
		} return $this->_styles;
	}

	public function debug () : bool {
		return \debug ();
	}

	public function loadView (string $view) : bool {
		$this->view = $view;
		$file = "{$this->_path}{$this->view}/view.".Config::ext ('server', 'page');
		if (!file_exists ($file) || empty ($config = $this->parseFile ($file)) || !$this->verifyConfig ($config)) {
			return false;
		}
		foreach ($this->configurableFields () as $member) {
			$property = substr ($member, 1);
			if (isset ($config [$property]) && gettype ($config [$property]) === gettype ($this->$member)) {
				$this->$member = $config [$property];
			}
		}
		if (is_array ($config ['views'])) {
			$this->parseViews ($config ['views']);
		}
		return true;
	}

	public function sidePanel () {
		return $this->_settings ['side_nav'];
	}

	public function addSubViewParameter (string $name, $value) : void {
		foreach ($this->_settings ['side_nav'] as $entry) {
			foreach ($entry ['items'] as $link) {
				$link->setParam ($name, $value);
			}
		}
	}

	public function finalize () : void {
		# TODO: Write more complete page parser utility somewhere else.
		if (isset ($this->_settings ['side_nav']) && is_array ($this->_settings ['side_nav'])) {
			foreach ($this->_settings ['side_nav'] as &$entry) {
				foreach ($entry ['items'] as $key => &$link) {
					if (!is_array ($link)) {
						continue;
					}
					$params = isset ($link ['params']) ? $link ['params'] : [];
					$target = isset ($link ['target']) ? $link ['target'] : $this->name ();
					if (!isset ($link ['text'], $link ['target']) || !is_string ($link ['text']) || !is_string ($link ['target']) || !is_array ($params)) {
						unset ($entry ['items'][$key]);
						continue;
					}
					$entry ['items'][$key] = new \Html\Link ($link ['text'], $link ['target'], $params);
				}
			}
		}
	}

	private function parseViews (array $views) {
		if (!isset ($views ['views']) || !is_array ($views ['views'])) {
			return;
		}
		foreach ($views ['views'] as $view) {
			if (!is_array ($view) || !isset ($view ['name'])) {
				continue;
			}
			$pv = new PageView ();
			$pv->load ($view);
			if (isset ($view ['default'])) {
				$pv->show ($view ['default'] === true);
			}
			$this->views [$pv->id ()] = $pv;
		}
		$this->_settings ['side_nav'] = [];
		if (isset ($views ['navigation']) && is_array ($views ['navigation'])) {
			foreach ($views ['navigation'] as $entry) {
				if (!is_array ($entry)) {
					continue;
				}
				$heading = isset ($entry ['heading']) && is_string ($entry ['heading']) ? $entry ['heading'] : '';
				$items = isset ($entry ['items']) && is_array ($entry ['items']) ? $entry ['items'] : [];
				$entry = [ 'heading' => $heading, 'items' => [] ];
				foreach ($items as $link) {
					$view = isset ($link ['view']) && is_string ($link ['view']) ? $link ['view'] : '';
					$text = isset ($link ['text']) && is_string ($link ['text']) ? $link ['text'] : '';
					if (!empty ($temp = $this->views [$link ['view']])) {
						$entry ['items'][] = $temp->link ($this, $text);
					} else {
						$target = isset ($link ['target']) && is_string ($link ['target']) ? $link ['target'] : '';
						$params = isset ($link ['params']) && is_array ($link ['params']) ? $link ['params'] : [];
						$entry ['items'][] = [ 'text' => $text, 'params' => $params, 'target' => $target ];
					}
				}
				$this->_settings ['side_nav'][] = $entry;
			}
		}
	}

	private function parseFile (string $file) : array {
		if (empty ($config = @parse_ini_file ($file, true, INI_SCANNER_TYPED)) && empty ($config = @json_decode (file_get_contents ($file), true))) {
			return [];
		}
		return $config;
	}

	private function verifyConfig (array $config) {
		return isset ($config ['views']);
	}

	private function configurableFields (array $exclude = []) {
		return array_filter (
			array_map (function ($field) { return $field->name; }, (new \ReflectionClass ($this))->getProperties ()),
			function ($field) use ($exclude) {
				return @$field [0] === '_' && !in_array ($field, $exclude); }
		);
	}

}
