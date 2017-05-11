<?php

namespace Lora;

use \Lora\{Page, PageComponent};

final class PageView
{

	private $_name			= '',
			$_sub_layout	= '', # TODO: Use this if css can not be used.
			$_content		= '',
			$components		= [],
			$visible		= false,
			$link 			= null;

	public function __construct (string $name = '') {
		$this->_name = $name;
	}

	public function link (Page $page, string $text) {
		return $this->link ?? $this->link = new \Html\Link ($text, $page->name (), [ $this->_name => '' ], [ 'data-view-name' => $this->_name ]);
	}

	public function show (bool $show = null) {
		if ($show === null) {
			return $this->visible;
		} $this->visible = $show;
	}

	public function id () {
		return $this->_name;
	}

	public function setLayout (string $layout) : void {
		$this->_sub_layout = $layout;
	}

	public function layout () : string {
		return $this->_sub_layout = \Lib::checkExtension ($this->_sub_layout, Config::ext ('twig', 'twig'));
	}

	public function content () : string {
		return $this->_content = \Lib::checkExtension ($this->_content, Config::ext ('twig', 'twig'));
	}

	public function addComponent (string $component) : void {
		if (($comp = PageComponent::Create ($component)) !== null) {
			$this->components [] = $comp;
		}
	}

	public function components () : array {
		return $this->components;
	}

	public function load (array $config) {
		foreach ($this->configurableFields () as $member) {
			$property = substr ($member, 1);
			if (isset ($config [$property]) && gettype ($config [$property]) === gettype ($this->$member)) {
				$this->$member = $config [$property];
			}
		}
		if (isset ($config ['components']) && is_array ($config ['components'])) {
			foreach ($config ['components'] as $comp) {
				if (gettype ($comp) === "string") {
					$this->addComponent ($comp);
				}
			}
		}
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

}
