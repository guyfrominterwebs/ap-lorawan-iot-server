<?php

namespace Lora;

/**
	A subview for page. Subview may have 0 to n PageComponents 
	(or components for short when talking about pages) assigned 
	to them. These components are added to the page by Twig.
	This class might later be moved to \Lora\Content -namespace.
*/
final class PageView
{

	private $_name			= '',
			$_sub_layout	= '',
			$_content		= '',
			$components		= [],
			$visible		= false,
			$link 			= null;

	/**
		\param $name Name of this PageView
	*/
	public function __construct (string $name = '') {
		$this->_name = $name;
	}

	/**
		Generates an \Html\Link object to this view.
		\param $page The page to which this view belongs to. This might be removed in the future if PageViews are made aware of their containing Page.
		\param $text Visible text of the link.
	*/
	public function link (Page $page, string $text) {
		return $this->link ?? $this->link = new \Html\Link ($text, $page->name (), [ $this->_name => '' ], [ 'data-view-name' => $this->_name ]);
	}

	/**
		If $show is defined, the $visible property is set to value of $show. If not, this method return $visible property value.
		\param $show An optional boolean value to determine if this view is visible or not.
		\return Returns a boolean determining this view's visibility.
	*/
	public function show (bool $show = null) {
		if ($show === null) {
			return $this->visible;
		} $this->visible = $show;
	}

	/**
		\todo This method should be renamed to 'name'.
		\return Returns the name of this view.
	*/
	public function id () {
		return $this->_name;
	}

	/**
		An unused feature but it is possible to define a layout for views.
		\param $layout Name of a layout file for this view with or without extension.
	*/
	public function setLayout (string $layout) : void {
		$this->_sub_layout = $layout;
	}

	/**
		\return Returns the name of the file containing this PageView's layout and adds extension to it if one does not exist.
	*/
	public function layout () : string {
		return $this->_sub_layout = \Lib::checkExtension ($this->_sub_layout, Config::ext ('twig', 'twig'));
	}

	/**
		\return Returns the name of the file containing this PageView's content and adds extension to it if one does not exist.
	*/
	public function content () : string {
		return $this->_content = \Lib::checkExtension ($this->_content, Config::ext ('twig', 'twig'));
	}

	/**
		Adds a new component to this PageView if such exist.
		\param $componentName Name of the PageComponet which is wished to be added to this PageView.
	*/
	public function addComponent (string $componentName) : void {
		if (($comp = PageComponent::Create ($componentName)) !== null) {
			$this->components [] = $comp;
		}
	}

	/**
		\return Returns an array containing all components of this view.
	*/
	public function components () : array {
		return $this->components;
	}

	/**
		Reads preoperty values for this instance from an array. Capable of creating new PageComponent instances 
		by name.
		\param $config An array containing property values for this object.
	*/
	public function load (array $config) : void {
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

	/**
		Returns an array of property field names in this class which can be set using initialization files with PageView::load.
		\param $exclude An array containing field names which are to be excluded from the final collection.
		\return Returns an array of field names. It is possible for this array to be empty.
	*/
	private function configurableFields (array $exclude = []) : array {
		return array_filter (
			array_map (function ($field) { return $field->name; }, (new \ReflectionClass ($this))->getProperties ()),
			function ($field) use ($exclude) {
				return @$field [0] === '_' && !in_array ($field, $exclude); }
		);
	}

	/**
		Reads in a value file containing property values for this object.
		Not in use.
		\param $file Full path of the file containing property values. Can be an INI or JSON file.
		\return Returns an array of property values on success or an empty array on failure.
	*/
	private function parseFile (string $file) : array {
		if (empty ($config = @parse_ini_file ($file, true, INI_SCANNER_TYPED)) && empty ($config = @json_decode (file_get_contents ($file), true))) {
			return [];
		}
		return $config;
	}

}
