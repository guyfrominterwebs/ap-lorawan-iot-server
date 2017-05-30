<?php

namespace Lora;

/**
	A class to represent PageComponents. A component is 
	essentially a collection of few configuration and dependency
	files. Configuration files at the time of writing use component 
	as their extension and their preferred file format is JSON.
	Components also have a twig file of the same name as the 
	component file. Twig files contain the HTML a component 
	requires to display it contents. Configuration file contains 
	all the dependencies and some other properties for the HTML.
	This class might later be moved to \Lora\Content -namespace.
*/
final class PageComponent
{

	private $_id			= '',
			$_template		= '',
			$_libraries 	= [],
			$_scripts		= [],
			$_styles		= [],
			$_classes		= [];

	private function __construct () {
	}

	/**
		Creates a new PageComponent instance from a component name. Also populates all 
		properties using component file of a same name.
		\param $component Name of the component.
		\return Returns a PageComponent instance. This component may be imcomplete if its component 
			or template files are not working.
	*/
	public static function Create (string $component) {
		$temp 				= new PageComponent ();
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
		} else if (file_exists ($file = "$folder/$twig")) {
			$this->_template = $file;
			$this->_id = pathinfo ($component, PATHINFO_FILENAME);
		} else {
			return null;
		}
		return $temp;
	}

	/**
		\return Returns id of this PageComponent.
	*/
	public function id () {
		return $this->_id;
	}

	public function setTemplate (string $template) : void {
		$this->_template = $template;
	}

	/**
		\return Returns a template file name this PageComponent uses and adds file extension to it if required.
	*/
	public function template () : string {
		return $this->_template = \Lib::checkExtension ($this->_template, Config::ext ('twig', 'twig'));
	}

	/**
		Adds a new script to this PageComponent. These scripts are located in public/assets/scripts.
		\param $script Name of the script to be added.
	*/
	public function addScript (string $script) : void {
		if (!in_array ($script, $this->_scripts)) {
			$this->_scripts [] = $script;
		}
	}

	/**
		Returns an array containing all scripts assigned to this component.
		Goes through all of them and adds file extension to them if needed.
		\return Returns an array of file names.
	*/
	public function scripts () : array {
		foreach ($this->_scripts as &$script) {
			$script = \Lib::checkExtension ($script, 'js');
		} return $this->_scripts;
	}

	/**
		Adds a new library to this PageComponent. These libraries are located in public/assets/ext.
		\param $lid Name of the library to be added.
	*/
	public function addLibrary (string $lib) : void {
		if (!in_array ($lib, $this->_libraries)) {
			$this->_libraries [] = $lib;
		}
	}

	/**
		Returns an array containing all libraries assigned to this component.
		Goes through all of them and adds file extension to them if needed.
		\return Returns an array of file names.
	*/
	public function libraries () : array {
		foreach ($this->_libraries as &$lib) {
			$lib = \Lib::checkExtension ($lib, 'js');
		} return $this->_libraries;
	}

	/**
		Returns an array containing all styles assigned to this component.
		Goes through all of them and adds file extension to them if needed.
		\return Returns an array of file names.
	*/
	public function styles () : array {
		foreach ($this->_styles as &$style) {
			$style = \Lib::checkExtension ($style, 'css');
		} return $this->_styles;
	}

	/**
		If $string is provided, it is added to the classes assigned to this PageComponent.
		If $string is not provided, a string consisting of all class names separated by space will be returned.
		\return Returns a string of css classes.
	*/
	public function classes (bool $string = false) {
		if ($string) {
			$classes = '';
			foreach ($this->_classes as $c) {
				$classes .= "$c ";
			} return $classes;
		} return $this->_classes;
	}

	/**
		Returns an array of property field names in this class which can be set using initialization files with PageComponent::populate.
		\param $exclude An array containing field names which are to be excluded from the final collection.
		\return Returns an array of field names. It is possible for this array to be empty.
	*/
	private function configurableFields (array $exclude = []) {
		return array_filter (
			array_map (function ($field) { return $field->name; }, (new \ReflectionClass ($this))->getProperties ()),
			function ($field) use ($exclude) {
				return @$field [0] === '_' && !in_array ($field, $exclude); }
		);
	}

	/**
		Attempts to parse a component file. This file can be either INI or JSON but JSON should be preferred due to its more flexible nature.
		\param $file Full path to a component file.
		\return Returns an array of property values for this class.
	*/
	private function parseFile (string $file) : array {
		if (empty ($config = @parse_ini_file ($file, true, INI_SCANNER_TYPED)) && empty ($config = @json_decode (file_get_contents ($file), true))) {
			return [];
		}
		return $config;
	}

	/**
		Verifies that a loaded component file is sane and can be used.
		\return Returns true if component config is valid and false if not.
	*/
	private function inspectConfig (array $config) : bool {
		# TODO?: Type checks
		return isset ($config ['id'], $config ['template'], $config ['dependencies'], $config ['appearance']);
	}

	/**
		Populates property values with an associative array.
		\param $values An array of property values.
	*/
	private function populate (array $values) : void {
		foreach ($this->configurableFields () as $member) {
			$property = substr ($member, 1);
			if (isset ($values [$property]) && gettype ($values [$property]) === ($type = gettype ($this->$member))) {
				$this->$member = $values [$property];
			}
		}
	}
}
