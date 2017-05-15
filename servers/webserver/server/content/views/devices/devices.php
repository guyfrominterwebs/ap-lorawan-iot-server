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
		// if (!empty ($this->url)) {
			// switch ($this->url [0]) {
				// case 'graphs':
				// case 'latest':
						// $this->page->show ($this->url [0]);
					// break;
				// default:
						// $this->page->show ('devices');
					// break;
			// }
		// }
		$this->fetchDevices ();
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

	private function fetchDevices () {
		try {
			$manager = \DBConnection::connection ('measurements');
			$query = new \MongoDB\Driver\Query ([]);
			$cursor = $manager->executeQuery ('lorawan.devices', $query); // $mongo contains the connection object to MongoDB
			$this->mess->addData ($cursor->toArray (), 'devices');
		} catch (\Exception $e) {
			var_dump ($e->getMessage ());
			$this->mess->error ($e->getMessage ());
		}
	}
}
