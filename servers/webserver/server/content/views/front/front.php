<?php

namespace Lora\Content;

use \Lora\PageManager, \RequestData;

final class Content_Front extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		$pm = new PageManager ($this->mess);
		$page = $pm->load ($this, 'front');
		if ($req->readString ('show', $view)) {
			switch ($view) {
				case 'instructions':
						$page->show ('instructions');
					break;
				case 'lorawan':
						$page->show ('lorawan');
					break;
				default:
						$view = '';
					break;
			}
			$page->show ($view);
		}
	}

	public function _post (RequestData $req) {
	}

	public function _put (RequestData $req) {
	}

	public function _delete (RequestData $req) {
	}

}
