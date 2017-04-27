<?php

namespace Lora;

final class PageManager
{

	private $path 				= "",
			$cacheEnabled 		= true,
			$mess				= null;

	public function __construct (Messenger $mess, $enableCache = true) {
		$this->mess 			= $mess;
		$this->path 			= Config::path ('server', 'page_cache');
		$this->cacheEnabled 	= $enableCache;
	}

	public function cache (Page $page, string $id) : bool {
		return $this->cacheEnabled && file_put_contents ("{$this->path}\\${id}", serialize ($page)) !== false;
	}

	public function load (BaseAction $action, string $view) {
		$id = $action->getId ();
		$page = null;
		if (file_exists ($path = "{$this->path}${id}") && ($spage = file_get_contents ($path)) !== false) {
			$page = unserialize ($spage);
		} else if (($page = $this->mess->getPage ()) && $page->loadView ($view)) {
			$this->cache ($page, $id);
		}
		$this->mess->getPage ($page);
		return $page;
	}
}
