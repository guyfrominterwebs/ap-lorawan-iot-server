<?php

namespace Lora\Api;

use \RequestData;

final class Action_Test extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		$this->mess->addData ('Get test.');
		$this->mess->addData ($req->getInt ('asd', 0));
	}

	public function _post (RequestData $req) {
		$this->mess->addData ('Post test.');
	}

	public function _put (RequestData $req) {
		$this->mess->addData ('Put test.');
	}

	public function _delete (RequestData $req) {
		$this->mess->addData ('Delete test.');
	}

}