<?php

namespace Lora\Content;

use \Lora\PageManager, \RequestData;

final class Content_Home extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		if (!empty ($this->url)) {
			switch ($this->url [0]) {
				case 'instructions':
				case 'lorawan':
				case 'why':
				case 'penis':
						$this->page->showSingle ($this->url [0]);
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
