<?php

namespace Lora;

use Lora\ResponseCrafter;

final class RequestHandler
{

	private $slim = null,
			$req = null,
			$mess = null,
			$method = '',
			$root = '';

	public function __construct (\Slim\Slim $slim) {
		$this->slim			= $slim;
		$this->method 		= strtolower ($this->slim->request->getMethod ());
		$this->req 			= new \RequestData ($this->slim->request->params ());
		$this->mess			= new Messenger ();
		$this->root			= Config::path ('server', 'root');
	}

	public function handleContentRequest (array $action = null) {
		if (empty ($action)) {
			$action = [ 'home' ];
		}
		require "{$this->root}/server/login.php";
		if (!isLoggedIn () && !login ()) {
			return; # Login failed.
		}
		$this->resolveCall ($this->method, $action, Config::path ('server', 'content'), "Content", "Lora\Content", false, $this->req, $this->mess);
		// \Lib::dump ($this->mess->getData ());
		require "{$this->root}/frameworks/Twig/Autoloader.php";
		$page = $this->mess->getPage ();
		\Twig_Autoloader::register ();
		$loader = new \Twig_Loader_Filesystem ([
			Config::path ('twig', 'templates'),
			Config::path ('twig', 'layouts'),
			Config::path ('twig', 'content'),
			Config::path ('twig', 'macros'),
			Config::path ('twig', 'common'),
			$page->path ()
		]);
		$twig = new \Twig_Environment ($loader, [ 'debug' => debug (), 'cache' => Config::path ('twig', 'cache') ]);
		$twig->addExtension (new \Twig_Extension_Debug ());
		$template = $twig->loadTemplate ($page->content ());
		$template->display ([
			'page' 				=> $page,
			'data'				=> $this->mess->getData (),
			'public_pages' 		=> Config::get ('client', 'pages'),
			'public_ext' 		=> Config::get ('client', 'ext'),
			'public_scripts' 	=> Config::get ('client', 'scripts'),
			'public_styles' 	=> Config::get ('client', 'styles'),
			'public_images' 	=> Config::get ('client', 'images'),
		]);
	}

	public function handleApiRequest (array $action = null) : void {
		if (empty ($action)) {
			return;
		}
		$this->resolveCall ($this->method, $action, Config::path ('server', 'api'), "Action", "Lora\Api", true, $this->req, $this->mess);
		# TODO: Use out buffer processing instead of echo.
		echo json_encode ($this->mess->getData ());
		// \Lib::dump ($this->mess->getData ());
	}

	private function resolveCall (string $method, array $action, string $filePath, string $fileType, string $namespace, bool $apiCall, \RequestData $req, Messenger $mess) : void {
		# TODO: 400, 403, 404, 405, 
		$path = '';
		$class = '';
		$consumed = [];
		$excess = [];
		convertMethod ($method);
		if (!$this->actionToPath ($action, $consumed, $excess, $path, $filePath)) {
			$this->notFound ($consumed, $path, $filePath);
		}
		if (buildClassName ($consumed, $class, $fileType, $namespace) && loadFile ($path)) {
			if (class_exists ($class, false) && method_exists ($class, $method)) {
				(new $class ($mess))->run ($req, $method, $excess);
				return;
			}
		}
	}

	private function notFound (array &$consumed, string &$path, string $folder) : void {
		$file = '';
		$consumed = [ 'home' ];
		$path = "${folder}/views/home/home.php";
	}

	private function actionToPath (array $action, array &$consumed, array &$excess, string &$path, string $folder) : bool {
		$file = '';
		$max = ($count = count ($action)) < 6 ? $count : 6;
		$i = 0;
		while ($i++ < $max) {
			if (!empty ($part = array_splice ($action, 0, 1)[0]) && preg_match ('/^[a-z\/]+$/i', $part) === 1) {
				$file .= "${part}";
				if (file_exists ($lastPath = "${folder}/views/${file}/{$file}.php")) {
					$consumed [] = $part;
					$excess = $action;
					$path = $lastPath;	
				}
				$file .= '_';
			}
		} return !empty ($path);
	}
}

function buildClassName (array $action, string &$class, string $prefix, string $namespace) : bool {
	foreach ($action as $part) {
		if (!empty ($part) && preg_match ('/^[a-z\/]+$/i', $part) === 1) {
			$class .= ucfirst ($part);
		}
	}
	$class = "${namespace}\\${prefix}_${class}";
	return true;
}

function loadFile (string $path) : bool {
	return file_exists ($path = realpath ($path)) && include $path;
}

function convertMethod (string &$method) : void {
	$method = "_${method}";
}
