<?php

namespace Lora;

final class PageManager
{

	private $path 				= "",
			$cacheEnabled 		= false;

	public function __construct () {
		$this->path 			= Config::path ('server', 'page_cache');
		$this->cacheEnabled 	= Config::path ('server', 'enable_page_cache');
	}

	public function cache (Page $page, string $id) : bool {
		return $this->cacheEnabled && file_put_contents ("{$this->path}/${id}", serialize ($page)) !== false;
	}

	public function load (BaseAction $action) {
		$id = $action->getId ();
		$page = null;
		if (file_exists ($path = "{$this->path}${id}") && ($spage = file_get_contents ($path)) !== false) {
			$page = unserialize ($spage);
		} else if (($page = new Page ()) && $page->loadView ($action->getName ())) {
			$this->cache ($page, $id);
		} return $page;
	}
}
