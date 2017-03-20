<?php

namespace Lora;

use Lora\Messenger;

class ResponseCrafter
{

	private $mess;

	public function __construct (Messenger $mess) {
		$this->mess = $mess;
	}

	public function createApiResponse () {
		return $this->mess->getData ();
	}

	public function createContentResponse () {
		return [];
	}

}