<?php

namespace Lora\Content;

use \Lora\PageManager, \RequestData;

final class Content_Devices extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		foreach (array_keys ($this->page->subViews ()) as $view) {
			if ($req->has ($view)) {
				$this->page->showSingle ($view);
				break;
			}
		}
		$devices = \Lora\DAO::fetchDevices ();
		$this->mess->addData ($devices, 'devices');
		$this->page->addGlobal ('devices', $devices);
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
