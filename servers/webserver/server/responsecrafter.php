<?php

namespace Lora;

use Lora\Messenger;

/**
	A class which supposedly should be use to construct responses.
	This would cause some code to be moved from RequestHandler to this class 
	which in turn would make RequestHandler's responsibilities more consistent.

	Another feature this class could have is to abstract away the need for checking 
	if the request is an API or content request.
*/
class ResponseCrafter
{

	private $mess = null;

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
