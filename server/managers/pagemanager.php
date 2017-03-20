<?php

namespace Lora;

final class PageManager
{

	private $path = "";

	public function __construct () {
		$this->path = Config::path ('server', 'page_cache');
	}

	public function cache (Page $page, string $id) : bool {
		file_put_contents ("{$this->path}${id}", serialize ($page));
		return true;
	}

	public function load (string $id) {
		if (file_exists ($path = "{$this->path}${id}") && ($page = file_get_contents ($path)) !== false) {
			return unserialize ($page);
		} return false;
		
	}
}