<?php

namespace Lora\Content;

use \Lora\PageManager, \RequestData;

final class Content_Device extends \Lora\BaseAction
{

	public function _get (RequestData $req) {
		if ($req->readString ('id', $id)) {
			$this->mess->addData ($id, 'device');
		}
		$pm = new PageManager ($this->mess, false);
		$page = $pm->load ($this, 'device');
		$visible = 'rt';
		if ($req->has ('rt')) {
			// TODO: RT view engage.
			$page->addScript ('ws');
			$page->addScript ('rt');
			$page->addLibrary ('smoothie');
		} else if ($req->has ('history')) {
			$this->fetchData ($req, $id);
			$visible = 'history';
		}
		$page->setDetail ($visible, 'show');
		$page->setDetail ('Device', 'view_name');
		$left_nav = [[
				'heading' => 'Data',
				'items' => [
					[ 'text' => 'Realtime data', 'target' => 'device?rt' ],
					[ 'text' => 'Existing data', 'target' => 'device?history' ]
				]
		]];
		$page->setDetail ($left_nav, 'side_nav');
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
