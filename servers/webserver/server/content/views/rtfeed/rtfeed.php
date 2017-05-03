<?php

namespace Lora\Content;

use \Lora\PageManager, \RequestData;

final class Content_Rtfeed extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		$pm = new PageManager ($this->mess);
		$page = $pm->load ($this, 'rtfeed');
		$this->mess->addData ('Get content.');
		$page->setDetail ('Monitoring', 'view_name');
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