<?php

namespace Lora;

/**
	A class to represent and construct HTML pages. 
	A page may have 0 to n PageViews (also referred to as subviews)
	which can be visible or hidden. All subviews are sent to the 
	requesting client as HTML but only certain parts are shown.
	It is possible to show multiple subviews at once.
	This class might later be moved to \Lora\Content -namespace.
*/
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
		$this->_path = Config::path ('server', 'pages');
	}

	/**
		\return Returns view name for this Page.
	*/
	public function name () : string {
		return $this->view;
	}

	/**
		Changes visibility of a subview (PageView).
		\param $view Name of the subview to apply the visibility status to.
		\param $show A boolean value to determine the visibility of the subview.
	*/
	public function show (string $viewName, bool $show) : void {
		if (isset ($this->views [$viewName])) {
			$this->views [$viewName]->show ($show);
		}
	}

	/**
		Hides all but one subview if a subview with a given name exist.
		As a side effect, if a view with the given name does not exist, 
		all the views are hidden.
		\param $viewName Name of the view that becomes visible.
	*/
	public function showSingle (string $viewName) : void {
		foreach ($this->views as $v) {
			$v->show (false);
		}
		$this->show ($viewName, true);
	}

	/**
		Marks this Page as static meaning that its contents will not change 
		despite it being dynamically generated using a Content -class. 
		This enables caching the results and potentially skip the whole 
		generation process.
	*/
	public function markStatic () : void {
		$this->static = true;
	}

	/**
		\return Returns whether or not this Page is considered static.
	*/
	public function isStatic () : bool {
		return $this->static;
	}

	/**
		Adds a new PageView to this Page's $views array.
		\param $view A PageView object to add.
	*/
	public function addView (PageView $view) : void {
		$this->views [$view->id ()] = $view;
	}

	/**
		Adds multiple PageViews to this Page.
		\param $views An array of PageView objects.
	*/
	public function addViews (array $views) : void {
		if (\DataLib::AreInstanceOf ($view, PageView::class)) {
			foreach ($views as $v) {
				$this->view [$v->id ()] = $v;
			}
		}
	}

	/**
		\return Returns all PageView objects this Page has.
	*/
	public function subViews () : array {
		return $this->views;
	}

	/**
		Adds a new javascript file to this Page.
		\param $scriptName Name of the script file to be added.
	*/
	public function addScript (string $scriptName) : void {
		if (!in_array ($scriptName, $this->_scripts)) {
			$this->_scripts [] = $scriptName;
		}
	}

	/**
		Collects all javascript file names from PageViews and their 
		PageComponents, inspects if they already exist within the 
		collection and if not, adds them to it. Once all the scripts 
		have been collected, they're given file extensions as necessary.
		\return Returns all scripts this Page has.
	*/
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

	/**
		Adds a new javascript library to this Page.
		\param $libName Name of the javacsript library file to be added.
	*/
	public function addLibrary (string $libName) : void {
		if (!in_array ($libName, $this->_libraries)) {
			$this->_libraries [] = $libName;
		}
	}

	/**
		Collects all javascript files from PageViews and their PageComponents, 
		inspects if they already exist within the collection and if not, 
		adds them to it. Once all the scripts have been collected, they're 
		given file extensions as necessary.
		\return Returns all scripts this Page has.
	*/
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

	/**
		Adds a new global javascript variable to this Page. Both, variable name 
		and its value are inspected for injections. Only letters and underscores 
		are allowed for variable name and val must be JSON encodable.
		\param $name Name of the global variable which will be added to the page.
		\param $val Value of the global variable.
	*/
	public function addGlobal (string $name, $val) : void {
		if (preg_match ("/^[a-z_]+$/i", $name) === 1) {
			$this->_globals [$name] = [ is_scalar ($val), gettype ($val), $val ];
		}
	}

	/**
		Returns an array containing all global values in this Page.
		\return An array of global javascript variables.
	*/
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

	/**
		Allows settings a value to this Page under certain key. An outdated method 
		but still required in some places.
		\param $detail A value to be stored in this Page.
		\param $key A key under which the value is stored.
	*/
	public function setSetting ($detail, string $key) : void {
		$this->_settings [$key] = $detail;
	}

	/**
		Quite out dated function but some functionality still relies on it so it shall remain here for now.
		Overall better solutions are required for multiple sections of the Page management system.
		\return Returns all settings this Page has.
	*/
	public function settings () : array {
		return $this->_settings;
	}

	/**
		\return Returns path to this Page's view folder.
	*/
	public function path () : string {
		return "{$this->_path}/{$this->view}";
	}

	/**
		\return Returns name of the template file for this Page.
	*/
	public function template () : string {
		return $this->_template = \Lib::checkExtension ($this->_template, Config::ext ('twig', 'twig'));
	}

	/**
		\return Returns name of the layout file for this Page.
	*/
	public function layout () : string {
		return $this->_layout = \Lib::checkExtension ($this->_layout, Config::ext ('twig', 'twig'));
	}

	/**
		Returns the content file name of this page. Since all pages use the same base naming for files, 
		there is no need to store it in any variable.
		\return Name of the content twig file.
	*/
	public function content () : string {
		return "content.".Config::ext ('twig', 'twig');
	}

	/**
		Collects all css files from PageViews and their PageComponents, 
		inspects if they already exist within the collection and if not, 
		adds them to it. Once all the css files have been collected, 
		they're given file extensions as necessary.
		\return Returns all css files this Page has.
	*/
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

	/**
		A wrapper function to allow twig to check if debugging is on.
	*/
	public function debug () : bool {
		return \debug ();
	}

	/**
		\todo Rename to load.
		Loads a Page 
	*/
	public function loadView (string $view) : bool {
		$this->view = $view;
		$file = "{$this->_path}/{$this->view}/view.".Config::ext ('server', 'page');
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

	/**
		This is a bit hacky solution and a better one should be created which supports all 
		panels and not just a single one.
		\return Returns left side panel related data, mostly hyperlink objects.
	*/
	public function sidePanel () {
		return $this->_settings ['side_nav'];
	}

	/**
		Another bit hacky method to allow adding parameters to all left side panel's links.
		\param $name Name of the parameter to be added.
		\param $value Value of the parameter.
	*/
	public function addSubViewParameter (string $name, $value) : void {
		foreach ($this->_settings ['side_nav'] as $entry) {
			foreach ($entry ['items'] as $link) {
				$link->setParam ($name, $value);
			}
		}
	}

	/**
		Finalizes page object loading and parses certain data structures into objects.
		\todo Should be relocated. A possible place would be PageManager.
	*/
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

	/**
		Parses PageView data and creates new instances of them based on the page configuration file.
		Succesfully created PageViews are added to this Page.
		\todo Needs cleaning
		\param $views An array containing view configurations from which new PageViews will be created
	*/
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
					if (isset ($this->views [$link ['view']]) && !empty ($temp = $this->views [$link ['view']])) {
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

	/**
		Reads in a value file comtaining property values for this object.
		\param $file Full path of the file containing property values. Can be an INI or JSON file.
		\return Returns an array of property values on success or an empty array on failure.
	*/
	private function parseFile (string $file) : array {
		if (empty ($config = @parse_ini_file ($file, true, INI_SCANNER_TYPED)) && empty ($config = @json_decode (file_get_contents ($file), true))) {
			return [];
		}
		return $config;
	}

	/**
		Verifies that a loaded page file is sane and can be used.
		\return Returns true if page config is valid and false if not.
	*/
	private function verifyConfig (array $config) {
		return isset ($config ['views']);
	}

	/**
		Returns an array of property field names in this class which can be set using initialization files with Page::loadView.
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

}
