<?php

namespace Lora;

use \RequestData;

class BaseAction
{
	protected	$mess,
				$id,
				$url;

	public function __construct (Messenger $mess) {
		$this->mess 	= $mess;
		$this->id		= md5 (get_class ($this));
	}

	public function getId () {
		return $this->id;
	}

	public function run (RequestData $req, string $method, array $excessUrl) {
		if (method_exists ($this, $method)) {
			$this->url = $excessUrl;
			$this->$method ($req);
		}
	}

}