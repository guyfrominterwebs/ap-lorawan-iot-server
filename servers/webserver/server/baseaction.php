<?php

namespace Lora;

use \RequestData;

/**
	A class from which all API and content scripts inherit.
*/
class BaseAction
{
	protected	$mess			= null,
				$page			= null,
				$id				= '',
				$name			= '',
				$url			= []; ///< This should be moved to RequestData since that class was specifically created for this kind of data.

	/**
		\param $name Non-prefixed name of this class.
		\param $mess An instance of messenger.
	*/
	public function __construct (string $name, Messenger $mess) {
		$this->name				= strtolower ($name);
		$this->mess 			= $mess;
		$this->id				= md5 (get_class ($this));
	}

	/**
		Returns in id value of this class generated its name using md5.
		\return Id value unique to this action.
	*/
	public function getId () {
		return $this->id;
	}

	/**
		In order to create an instance of this class, a shorted non-prefixed variation of its name must be given as parameter.
		This method returns that name.
		\return Non-prefixed name of this class.
	*/
	public function getName () {
		return $this->name;
	}

	/**
		Overridable initialization method. Called before running HTTP method corresponding method.
	*/
	protected function init () : void {
	}

	/**
		Runs the action and executes an HTTP paired method.
		\param $req An instance of RequestData containing all the retquest parameters.
		\param $method Converted HTTP method to be used as a method name to run the correct method.
		\param $excessUrl An array containing the parts of the URI which were not used to resolve correct class name.
		\param $page An optional instance of Page passed only to Content_ classes.
	*/
	public function run (RequestData $req, string $method, array $excessUrl, Page $page = null) : void {
		if (method_exists ($this, $method)) {
			$this->url = $excessUrl;
			$this->page = $page;
			$this->init ();
			$this->$method ($req);
		}
	}
}
