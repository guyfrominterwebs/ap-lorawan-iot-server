<?php

namespace Lora;

use Lora\ResponseCrafter;

final class RequestHandler
{

	private $slim,
			$method,
			$req,
			$mess;

	public function __construct (\Slim\Slim $slim) {
		$this->slim			= $slim;
		$this->method 		= strtolower ($this->slim->request->getMethod ());
		$this->req 			= new \RequestData ($this->slim->request->params ());
		$this->mess			= new Messenger ();
	}

	public function handleContentRequest (array $action = null) {
		if (empty ($action)) {
			return;
		}
		$root = Config::path ('server', 'root');
		require "${root}/login.php";
		if (!isLoggedIn () && !login ()) {
			return; # Login failed.
		}
		resolveCall ($this->method, $action, Config::path ('server', 'content'), "Content", "Lora\Content", $this->req, $this->mess);
		// \Lib::dump ($this->mess->getData ());

		require '../frameworks/Twig/Autoloader.php';
		$page = $this->mess->getPage ();
		\Twig_Autoloader::register ();
		$loader 	= new \Twig_Loader_Filesystem ([
			Config::path ('twig', 'templates'),
			Config::path ('twig', 'content'),
			Config::path ('twig', 'macros')
		]);
		$twig 		= new \Twig_Environment ($loader, [ 'debug' => debug (), 'cache' => Config::path ('twig', 'cache') ]);
		$twig->addExtension(new \Twig_Extension_Debug());
		$template 	= $twig->loadTemplate ($page->content ());
		$template->display ([
			'page' 				=> $page,
			'public_ext' 		=> Config::path ('client', 'ext'),
			'public_scripts' 	=> Config::path ('client', 'scripts'),
			'public_styles' 	=> Config::path ('client', 'styles'),
		]);
	}

	public function handleApiRequest (array $action = null) {
		if (empty ($action)) {
			return;
		}
		resolveCall ($this->method, $action, Config::path ('server', 'api'), "Action", "Lora\Api", $this->req, $this->mess);
		\Lib::dump ($this->mess->getData ());
	}

}


function resolveCall (string $method, array $action, string $filePath, string $fileType, string $namespace, \RequestData $req, Messenger $mess) {
	# TODO: 400, 403, 404, 405, 
	$path = '';
	$class = '';
	convertMethod ($method);
	if (actionToPath ($action, $path, $filePath) && buildClassName ($action, $class, $fileType, $namespace) && loadFile ($path)) {
		if (class_exists ($class, false) && method_exists ($class, $method)) {
			(new $class ($mess))->run ($req, $method);
			return;
		}
	}
}

function actionToPath (array $action, string &$path, string $folder) : bool {
	foreach ($action as $part) {
		if (!empty ($part) && preg_match ('/^[a-z\/]+$/i', $part) === 1) {
			$path .= "${part}_";
		}
	}
	$path = "${folder}/".substr ($path, 0, -1).".php";
	return true;
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

function convertMethod (string &$method) {
	$method = "_${method}";
}
