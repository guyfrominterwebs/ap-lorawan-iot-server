<?php

namespace Lora;

class Config
{

	const	PATH						= 'path_',
			EXTENSION					= 'ext_';

	private static $instance			= null;

	private $configurations				= [];

	private function __construct () {
	}

	public static function instance () {
		return self::$instance ?? (self::$instance = new Config ());
	}

	public static function loadConfig (array $configs) : void {
		self::instance ()->configurations [] = new Configuration ($configs);
	}

	public static function get (...$key) {
		$temp = self::instance ();
		foreach ($temp->configurations as $conf) {
			if ($conf->has ($value, $key)) {
				return $value;
			}
		} return null;
	}

	public static function path (...$key) {
		foreach (self::instance ()->configurations as $conf) {
			if ($conf->has ($path, $key) && is_string ($path)) {
				return realpath ($path);
			}
		} return '';
	}

	public static function ext (...$key) {
		foreach (self::instance ()->configurations as $conf) {
			if ($conf->has ($ext, $key) && is_string ($ext)) {
				return $ext;
			}
		} return '';
	}

	public static function registerAutoloaders () : void {
		$temp = self::instance ();
		foreach ($temp->configurations as $conf) {
			$conf->setupAutoloader ();
		}
		spl_autoload_register (__CLASS__.'::autoloader');
	}

	public static function autoloader ($class) : void {
		$class = strtolower (array_slice (explode ('\\', $class), -1)[0]);
		foreach (Config::instance ()->configurations as $conf) {
			if ($conf->includeScript ($class)) {
				return;
			}
		}
	}

}

final class Configuration
{

	private static $serverRoot			= [];

	private $root						= '',
			$systemFiles 				= [],
			$configs					= [],
			$paths						= [],
			$exts						= [],
			$exclude					= [ 'frameworks' ];

	public function __construct (array $configs) {
		foreach ($configs as $section => $conf) {
			if (is_array ($conf)) {
				foreach ($conf as $key => $c) {
					$this->parse ($section, $c, $key);
				}
			} else {
				$this->parse ($section, $conf);
			}
		}
	}

	private function parse ($section, $val, $key = false) {
		if (!$key) {
			$this->configs [$section][] = $val;
			return;
		}
		$len = 0;
		$collection = null;
		if (($i = strpos ($key, Config::PATH)) !== false && $i === 0) {
			$len = strlen (Config::PATH);
			$collection = &$this->paths;
		} else if (($i = strpos ($key, Config::EXTENSION)) !== false && $i === 0) {
			$len = strlen (Config::EXTENSION);
			$collection = &$this->exts;
		}
		$key = substr ($key, $len);
		$this->configs [$section][$key] = $val;
		if ($collection !== null) {
			$collection [$section][$key] = $val;
		}
	}

	public function includeScript (string $class) {
		var_dump ($class, $this->systemFiles);
		if (isset ($this->systemFiles [$class]) && file_exists ($this->systemFiles [$class])) {
			require_once $this->systemFiles [$class];
			return true;
		} return false;
	}

	public function setupAutoloader () {
		if ($this->has ($exclude, [ 'server', 'autoload_exclude' ]) && is_array ($exclude)) {
			$this->exclude = array_unique (array_merge ($this->exclude, $exclude));
		}
		$this->root = realpath ($this->find ('server', 'root'));
		$fileReg = '/.*?\.php/';
		$pathReg = '/.*?/';
		if (!empty ($this->exclude)) {
			$temp = '';
			foreach ($this->exclude as $ex) {
				$temp .= preg_quote (str_replace ('/', DIRECTORY_SEPARATOR, $ex), '/').'|';
			}
			$pathReg = '/(?!.*('.substr ($temp, 0, -1).'))^.+$/';
		}
		foreach ($this->findFiles ($this->root, $fileReg, $pathReg) as $file) {
			$a = strrpos ($file, DIRECTORY_SEPARATOR) + 1;
			$this->systemFiles [strtolower (substr ($file, $a, strpos ($file, '.') - $a))] = $file;
		}
	}

	private function findFiles (string $path, string $fileReg, string $pathReg) : array {
		$stack = [ $path ];
		$files = [];
		while (!empty ($stack)) {
			$path = array_pop ($stack).DIRECTORY_SEPARATOR;
			if (is_dir ($path) && preg_match ($pathReg, $path) === 1 && $dh = opendir ($path)) {
				while (($file = readdir ($dh)) !== false) {
					if (preg_match ($pathReg, $path) !== 1 || $file === '.' || $file === '..') {
						continue;
					}
					$temp = $path.$file;
					if (is_dir ($temp)) {
						$stack [] = $temp;
					} else if (preg_match ($fileReg, $temp) === 1) {
						$files [] = $temp;
					}
				}
				closedir ($dh);
			} else if (preg_match ($fileReg, $path) === 1) {
				$files [] = $path;
			}
		} return $files;
	}

	public function has (&$value, array $key) : bool {
		$temp = $this->configs;
		foreach ($key as $k) {
			if (!isset ($temp [$k])) {
				return false;
			} $temp = $temp [$k];
		}
		$value = $temp;
		return true;
	}

	public function find (...$key) {
		$temp = $this->configs;
		foreach ($key as $k) {
			if (!isset ($temp [$k])) {
				break;
			}
			$temp = $temp [$k];
		} return $temp;
	}
}
