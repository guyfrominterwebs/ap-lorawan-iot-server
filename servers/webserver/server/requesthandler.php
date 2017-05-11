<?php

namespace Lora;

use Lora\ResponseCrafter;

final class RequestHandler
{

	private $slim = null,
			$req = null,
			$mess = null,
			$page = null,
			$pm = null,
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
		$this->pm = new PageManager ();
		$this->resolveCall ($this->method, $action, Config::path ('server', 'content'), "Content", "Lora\Content");
		$this->buildPage ();
	}

	public function handleApiRequest (array $action = null) : void {
		if (empty ($action)) {
			return;
		}
		$this->resolveCall ($this->method, $action, Config::path ('server', 'api'), "Action", "Lora\Api");
		# TODO: Use out buffer processing instead of echo.
		echo json_encode ($this->mess->getData ());
		// \Lib::dump ($this->mess->getData ());
	}

	private function resolveCall (string &$method, array $action, string $filePath, string $fileType, string $namespace) {
		# TODO: 400, 403, 404, 405, ...
		# TODO: Separate page and action routines.
		$path = '';
		$class = '';
		$className = '';
		$consumed = [];
		$excess = [];
		convertMethod ($method);
		if (!$this->actionToPath ($action, $consumed, $excess, $path, $filePath)) {
			$this->notFound ($consumed, $path, $filePath);
		}
		if (buildClassName ($consumed, $class, $className, $fileType, $namespace) && loadFile ($path)) {
			if (class_exists ($class, false) && method_exists ($class, $method)) {
				$action = new $class ($className, $this->mess);
				if ($this->pm !== null && ($this->page = $this->pm->load ($action)) !== null) {
					$this->page->finalize ();
					$this->defaultVisibility ();
					$this->pm->cache ($this->page, $action->getId ());
				}
				$action->run ($this->req, $this->method, $excess, $this->page);
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

	private function buildPage () {
		require "{$this->root}/frameworks/Twig/Autoloader.php";
		\Twig_Autoloader::register ();
		$loader = new \Twig_Loader_Filesystem ([
			Config::path ('twig', 'templates'),
			Config::path ('twig', 'layouts'),
			Config::path ('twig', 'content'),
			Config::path ('twig', 'macros'),
			Config::path ('twig', 'common'),
			Config::path ('twig', 'components'),
			$this->page->path ()
		]);
		$twig = new \Twig_Environment ($loader, [ 'debug' => debug (), 'cache' => Config::path ('twig', 'cache') ]);
		$twig->addExtension (new \Twig_Extension_Debug ());
		$template = $twig->loadTemplate ($this->page->content ());
		$template->display ([
			'page' 				=> $this->page,
			'data'				=> $this->mess->getData (),
			'public_pages' 		=> Config::get ('client', 'pages'),
			'public_ext' 		=> Config::get ('client', 'ext'),
			'public_scripts' 	=> Config::get ('client', 'scripts'),
			'public_styles' 	=> Config::get ('client', 'styles'),
			'public_images' 	=> Config::get ('client', 'images'),
		]);
	}

	private function defaultVisibility () {
		foreach (array_keys ($this->page->subViews ()) as $view) {
			if ($this->req->has ($view)) {
				$this->page->showSingle ($view);
				return;
			}
		}
	}
}

function buildClassName (array $action, string &$class, string &$plainName, string $prefix, string $namespace) : bool {
	foreach ($action as $part) {
		if (!empty ($part) && preg_match ('/^[a-z\/]+$/i', $part) === 1) {
			$class .= ucfirst ($part);
		}
	}
	$plainName = $class;
	$class = "${namespace}\\${prefix}_${class}";
	return true;
}

function loadFile (string $path) : bool {
	return file_exists ($path = realpath ($path)) && include $path;
}

function convertMethod (string &$method) : void {
	$method = "_${method}";
}
