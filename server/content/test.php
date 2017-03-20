<?php

namespace Lora\Content;

use \Lora\PageManager, \RequestData;

final class Content_Test extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		$pm = new PageManager ();
		if (($page = $pm->load ($this->id))) {
			$this->mess->getPage ($page);
		} else {
			$page = $this->mess->getPage ();
			$page->loadIni ('test');
			$pm->cache ($page, $this->id);
		}
		$this->mess->addData ('Get content.');
		$this->mess->addData ($req->getInt ('asd', 0));
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