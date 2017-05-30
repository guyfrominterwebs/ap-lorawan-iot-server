<?php

namespace Lora;

/**

	Configuration management class capable of managing multiple cinfiguration sets. Uses singleton pattern.
	Belongs to Lora -namespace.

*/
class Config
{

	const	PATH						= 'path_',	///< Path prefix which can be used in configuration files to allow them to be fetched through path method.
			EXTENSION					= 'ext_',	///< Extension prefix which can be used in configuration files to allow them to be fetched through ext method.
			PORT						= 'port_';	///< Extension prefix which can be used in configuration files to allow them to be fetched through port method.

	private static $instance			= null;

	private $configurations				= [];

	private function __construct () {
	}

	/**
		A method to fetch the singleton object. Initiates the object upon first call.
		\return Returns the singleton instance of Config.
	*/
	public static function instance () : \Lora\Config {
		return self::$instance ?? (self::$instance = new Config ());
	}

	/**
		Adds a new configuration set.
		\param $configs An array of configuration values.
	*/
	public static function loadConfig (array $configs) : void {
		self::instance ()->configurations [] = new Configuration ($configs);
	}

	/**
		Returns any configuration value if it exists.
		\return Returns requested configuration value if such exists or NULL if it is not found.
	*/
	public static function get (...$key) {
		foreach (self::instance ()->configurations as $conf) {
			if ($conf->has ($value, $key)) {
				return $value;
			}
		} return null;
	}

	/**
		Allows path searching.
		\param $key An argument list which is used as keys to locate the value. 
		\return 
			If path is found, it is passed to realpath to make it into an absolute path. 
			If path is not found or it cannot be resolved into an absolute path, an empty 
			string is returned.
	*/
	public static function path (...$key) : string {
		foreach (self::instance ()->configurations as $conf) {
			if ($conf->has ($path, $key)) {
				if (is_string ($path) && ($path = realpath ($path)) !== false) {
					return $path;
				} break;
			}
		} return '';
	}

	/**
		Attempts to fetch an array of paths.
		\param $key An argument list which is used as keys to locate the value. 
		\repturn Returns an array of absolute file paths for those values which can be converted.
	*/
	public static function paths (...$key) : array {
		$result = [];
		foreach (self::instance ()->configurations as $conf) {
			if ($conf->has ($paths, $key)) {
				if (is_array ($paths)) {
					foreach ($paths as $path) {
						if (($path = realpath ($path)) !== false) {
							$result [] = $path;
						}
					}
				}
			}
		}
		return $result;
	}

	/**
		Allows extension searching.
		\param $key An argument list which is used as keys to locate the value.
		\return Returns an extension string if the extension is found and it is a string. An empty string is returned is the extension could not be found.
	*/
	public static function ext (...$key) : string {
		foreach (self::instance ()->configurations as $conf) {
			if ($conf->has ($ext, $key)) {
				if (is_string ($ext)) {
					return $ext;
				} break;
			}
		} return '';
	}

	/**
		Allows port searching.
		\param $key An argument list which is used as keys to locate the value.
		\return Returns a port number as int if the port is found. -1 is returned is the port could not be found.
	*/
	public static function port (...$key) : int {
		foreach (self::instance ()->configurations as $conf) {
			if ($conf->has ($port, $key)) {
				return $port;
			}
		} return -1;
	}

	/**
		Prepares and registers autoloader functions for whole runtime. This includes hub server 
		with all associated scripts and the hosted server.
		\b NOTE: Only works when a server has configuration file with server root value set.
	*/
	public static function registerAutoloaders () : void {
		foreach (self::instance ()->configurations as $conf) {
			$conf->setupAutoloader ();
		}
		spl_autoload_register (__CLASS__.'::autoloader');
	}

	/**
		Autoloader function capable of loading any script file as long as there are no name conflicts.
		See http://php.net/manual/en/language.oop5.autoload.php for more details about autoloaders in PHP.
	*/
	public static function autoloader ($class) : void {
		$class = strtolower (array_slice (explode ('\\', $class), -1)[0]);
		foreach (Config::instance ()->configurations as $conf) {
			if ($conf->includeScript ($class)) {
				return;
			}
		}
	}

}

/**
	A class representing configuration set. Provides all parser functions for processing configurations arrays 
	and some utility functions to access them. Normally there is no need to access this class manually due to 
	Config being an abstraction layer for this class.

	\todo Start using $paths and $exts.
*/
final class Configuration
{

	private $root						= '',
			$systemFiles 				= [], ///< An associative array having all script names as keys and their path as values. Used during autoloading for performance gains.
			$configs					= [],
			$paths						= [],
			$exts						= [],
			$ports						= [],
			$exclude					= [ 'frameworks' ]; ///< A blacklist of words which must not occure in a scripts path in order for it to become autolodable.

	/**
		Configuration set constructor. Takes care of configuration parsing.
	*/
	public function __construct (array $configs) {
		$this->configs = $this->processConfigs ($configs, []);
	}

	/**
		\TODO Change this into a stack based routine instead of recursive.
		A recursive method which goes through the configuration set and converts all the keys in the process.
		\param $config An array containing configuration values.
		\param $keyChain An array of key values to locate correct array when converting prefixes.
	*/
	private function processConfigs (array $config, array $keyChain) : array {
		$result = [];
		foreach ($config as $key => $value) {
			if (is_array ($value)) {
				$keyChain [] = $key;
				$value = $this->processConfigs ($value, $keyChain);
				array_pop ($keyChain);
			}
			if (is_string ($key)) {
				$key = $this->parse ($keyChain, $key, $value);
			}
			$result [$key] = $value;
		}
		return $result;
	}
	/**
		Parses the configuration set and takes care of prefix processing.
		\param $keyChain An array of key values to locate correct array in typed collections.
		\param $key Name/key of the configuration value.
		\param $value A single configuration value.
	*/
	private function parse (array $keyChain, $key, $value) {
		$len = 0;
		$prefix = null;
		$prefixes = [
			Config::PATH => &$this->paths,
			Config::EXTENSION => &$this->exts,
			Config::PORT => &$this->ports
		];
		foreach ($prefixes as $pre => $col) {
			if (strpos ($key, $pre) === 0) {
				$len = strlen ($pre);
				$prefix = $pre;
				break;
			}
		}
		$key = substr ($key, $len);
		if ($prefix !== null) {
			$target =& $prefixes [$prefix];
			foreach ($keyChain as $k) {
				if (!isset ($target [$k])) {
					$target [$k] = [];
				}
				$target =& $target [$k];
			}
			$target [$key] = $value;
		}
		return $key;
	}

	/**
		Checks ifa script  with given name exists in systeFiles collection and includes it if it does.
		\return Returns true if script was found and included; false otherwise.
	*/
	public function includeScript (string $class) : bool {
		if (isset ($this->systemFiles [$class]) && file_exists ($this->systemFiles [$class])) {
			require_once $this->systemFiles [$class];
			return true;
		} return false;
	}

	/**
		Compiles blacklist for unallowed directory paths and initiates direcotry scanning.
		All script files found by the scan are then added to $systemFiles.
	*/
	public function setupAutoloader () : void {
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

	/**
		Scans through the directories and checks all found files if they are PHP scripts based on extension.
		\param $path Starting folder for the scan.
		\param $fileReg Regular expressions to detect a php file name/path
		\param $pathReg Regular expressio to check the path against blacklisted path parts.
		\return Returns an array of full file paths to PHP scripts.
	*/
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
					// } else if (preg_match ($fileReg, $temp) === 1) {
					} else if (substr ($temp, -3) === "php") {
						$files [] = $temp;
					}
				}
				closedir ($dh);
			// } else if (preg_match ($fileReg, $path) === 1) {
			} else if (substr ($path, -3) === "php") {
				$files [] = $path;
			}
		} return $files;
	}

	/**
		A method to determine whether or not a ceraint value exist within this configuration set.
		\params[out] $value If value exist it will be set to this variable.
		\params $key An array containing a key to the configuration value.
		\return Returns a boolean true if value exists within this collection and false if not.
	*/
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

	/**
		A more primitive method when compared to Configuration::has for fetching configuration values from this set.
		\param $key An argument collection which is used as keys to locate a configuration value.
		\return Returns the value behind $key if it is found; otherwise NULL is returned.
	*/
	public function find (...$key) {
		$temp = $this->configs;
		foreach ($key as $k) {
			if (!isset ($temp [$k])) {
				$temp = null;
				break;
			}
			$temp = $temp [$k];
		} return $temp;
	}
}
