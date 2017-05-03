<?php

namespace Lora\Content;

use \Lora\PageManager, \RequestData;

final class Content_Info extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		$pm = new PageManager ($this->mess);
		$page = $pm->load ($this, 'info');
		$page->setDetail ('Info', 'view_name');
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