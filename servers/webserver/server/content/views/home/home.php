<?php

namespace Lora\Content;

use \Lora\PageManager, \RequestData;

final class Content_Home extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		$pm = new PageManager ($this->mess);
		$page = $pm->load ($this, 'home');
		if (!empty ($this->url)) {
			switch ($this->url [0]) {
				case 'instructions':
						$page->show ('instructions');
					break;
				case 'lorawan':
						$page->show ('lorawan');
					break;
			}
		}
	}

	public function _post (RequestData $req) {
	}

	public function _put (RequestData $req) {
	}

	public function _delete (RequestData $req) {
	}

}
