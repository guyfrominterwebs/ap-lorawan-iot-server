<?php

namespace Lora;

class Config
{

	const	PATH						= 'path_',
			EXTENSION					= 'ext_';

	private static	$instance			= null,
					$root 				= '',
					$systemFiles 		= [];

	private $configs					= [],
			$paths						= [],
			$exts						= [],
			$exclude					= [ 'frameworks' ];

	private function __construct () {
	}

	public static function instance () {
		return self::$instance ?? (self::$instance = new Config ());
	}

	public function init (array $configs) {
		foreach ($configs as $section => $conf) {
			$this->configs [$section] = [];
			if (is_array ($conf)) {
				foreach ($conf as $key => $c) {
					$this->parse ($section, $c, $key);
				}
			} else {
				$this->parse ($section, $conf);
			}
		}
	}

	public function setExclude (array $excludes) {
		$this->exclude = array_unique (array_merge ($this->exclude, $excludes));
	}

	private function parse ($section, $val, $key = false) {
		if (!$key) {
			$this->configs [$section][] = $val;
			return;
		}
		$len = 0;
		$collection = null;
		if (($i = strpos ($key, self::PATH)) !== false && $i === 0) {
			$len = strlen (self::PATH);
			$collection = &$this->paths;
		} else if (($i = strpos ($key, self::EXTENSION)) !== false && $i === 0) {
			$len = strlen (self::EXTENSION);
			$collection = &$this->exts;
		}
		$key = substr ($key, $len);
		$this->configs [$section][$key] = $val;
		if ($collection !== null) {
			$collection [$section][$key] = $val;
		}
	}

	public static function get (...$key) {
		$temp = self::instance ();
		return $temp->find ($key, $temp->configs);
	}

	public static function path (...$key) {
		$temp = self::instance ();
		return $temp->find ($key, $temp->paths);
	}

	public static function ext (...$key) {
		$temp = self::instance ();
		return $temp->find ($key, $temp->exts);
	}

	public function registerAutoloaders () {
		self::$root 	= realpath (Config::path ('server', 'root'));
		$reg 			= empty ($this->exclude) ? $reg = '/^.+\.php$/' : '/(?!.*('.implode ('|', $this->exclude).'))^.+\.php$/';
		$iterator 		= new \RegexIterator (new \RecursiveIteratorIterator (new \RecursiveDirectoryIterator (self::$root)), $reg, \RecursiveRegexIterator::GET_MATCH);
		foreach ($iterator as $file) {
			$name = $file [0];
			do {
				$name = pathinfo ($name)['filename'];
			} while (strpos ($name, '.') !== false);
			self::$systemFiles [$name] = $file [0];
		} spl_autoload_register (__CLASS__.'::autoloader');
	}

	public static function autoloader ($class) {
		$class = strtolower (array_slice (explode ('\\', $class), -1)[0]);
		isset (self::$systemFiles [$class]) && file_exists (self::$systemFiles [$class]) && require_once self::$systemFiles [$class];
	}

	private function find ($key, $temp) {
		foreach ($key as $k) {
			$temp = $temp [$k];
		} return $temp;
	}

}
