<?php

namespace Lora\Content;

use \Lora\{PageManager, PageView};
use \RequestData;

final class Content_Device extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		if ($req->readString ('id', $id)) {
			$this->mess->addData ($id, $this->name);
		}
		$this->page->addSubViewParameter ('id', $id);
		if ($req->has ('rt-view')) {
			// TODO: RT view engage.
		} else if ($req->has ('history-view')) {
			$this->fetchData ($req, $id);
		} else if ($req->has ('madness')) {
			$this->fetchData ($req, $id);
		}
		// $rt->addComponent ('graph');
		// $history->addComponent ('device_history');
		// $left_nav = [[
				// 'heading' => 'Data',
				// 'items' => [
					// $rt->link ($this->page, 'Realtime data', [ 'id' => $id ]),
					// $history->link ($this->page, 'Existing data', [ 'id' => $id ]),
					// new \Html\Link ('Absolute madness!', $this->page->name (), [ 'madness' => '', 'id' => $id ])
				// ]
		// ]];
		// $this->page->setSetting ($left_nav, 'side_nav');
		// $this->page->addView ($rt);
		// $this->page->addView ($history);
		$this->page->addGlobal ('device_id', $id);
	}

	public function _post (RequestData $req) {
	}

	public function _put (RequestData $req) {
	}

	public function _delete (RequestData $req) {
	}

	private function fetchData (RequestData $req, $id) {
		$limit = 1000;
		if ($req->readInt ('index', $start, 0)) {
			
		}
		$filter = [
			'device_id' => $id
		];
		$options = [
			'projection' => [
				'_id' => 0,
				'payload' => 1,
				'time' => 1
			],
			'sort' => [
				'time' => 1
			],
			'limit' => $limit,
			'skip' => $start
		];
		$manager = \DBConnection::connection ('measurements');
		$query = new \MongoDB\Driver\Query ($filter, $options);
		$cursor = $manager->executeQuery ('lorawan.data', $query);
		// db.coll.find(queryDoc).sort(sortDoc).skip(x).limit(y)
		// $cursor->skip ();
		$this->mess->addData ($cursor->toArray ());
	}
}
