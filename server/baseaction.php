<?php

namespace Lora;

use \RequestData;

class BaseAction
{
	protected	$mess,
				$id;

	public function __construct (Messenger $mess) {
		$this->mess 	= $mess;
		$this->id		= md5 (get_class ($this));
	}

	public function run (RequestData $req, $method) {
		if (method_exists ($this, $method)) {
			$this->$method ($req);
		}
	}

}