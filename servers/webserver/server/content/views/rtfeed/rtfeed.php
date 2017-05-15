<?php

namespace Lora\Content;

use \Lora\PageManager, \RequestData;

final class Content_Rtfeed extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
	}

	public function _post (RequestData $req) {
		$this->mess->addData ('Post content.');
	}

	public function _put (RequestData $req) {
		$this->mess->addData ('Put content.');
	}

	public function _delete (RequestData $req) {
		$this->mess->addData ('Delete content.');
	}

}