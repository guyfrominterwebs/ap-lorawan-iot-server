<?php

namespace Lora;

use \RequestData;

class BaseAction
{
	protected	$mess			= null,
				$page			= null,
				$id				= '',
				$name			= '',
				$url			= [];

	public function __construct (string $name, Messenger $mess) {
		$this->name				= strtolower ($name);
		$this->mess 			= $mess;
		$this->id				= md5 (get_class ($this));
	}

	public function getId () {
		return $this->id;
	}

	public function getName () {
		return $this->name;
	}

	protected function init () {
	}

	public function run (RequestData $req, string $method, array $excessUrl, Page $page = null) {
		if (method_exists ($this, $method)) {
			$this->url = $excessUrl;
			$this->page = $page;
			$this->init ();
			$this->$method ($req);
		}
	}
}
