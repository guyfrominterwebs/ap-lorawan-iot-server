<?php

namespace Lora;

use Lora\ResponseCrafter;

/**
	A class which processes every request coming to this web server.
*/
final class RequestHandler
{

	private $slim			= null,
			$req			= null,
			$mess			= null,
			$page			= null,
			$pm				= null,
			$method			= '',
			$root			= '';

	public function __construct (\Slim\Slim $slim) {
		$this->slim			= $slim;
		$this->method 		= '_'.strtolower ($this->slim->request->getMethod ()); ///< Convert HTTP method into a BaseAction method name.
		$this->req 			= new \RequestData ($this->slim->request->params ());
		$this->mess			= new Messenger ();
		$this->root			= Config::path ('server', 'root');
	}

	/**
		Processes all requests which would return an HTML document.
		\param $action An array containing the URI path sections.
	*/
	public function handleContentRequest (array $action) : void {
		require "{$this->root}/server/login.php";
		if (!isLoggedIn () && !login ()) {
			return; # Login failed.
		}
		$this->pm = new PageManager ();
		$this->resolveCall ($action, Config::path ('server', 'pages'), "Content", "Lora\Content");
		$this->buildPage ();
	}

	/**
		Processes all API requests and returns responses as JSON.
		\param $action An array containing the URI path sections.
		\todo Possibly add support to return XML responses.
	*/
	public function handleApiRequest (array $action) : void {
		$this->resolveCall ($action, Config::path ('server', 'api'), "Action", "Lora\Api");
		$this->slim->response->header ('Content-Type', 'application/json');
		$this->slim->response->write (json_encode ($this->mess->getData ()));
	}

	/**
		Shared processing logic for both content and api requests.
		\param $action An array containing the URL path section which is not used for routing.
		\param $filePath Path to content and API directory.
		\todo Move page processing somewhere else.
	*/
	private function resolveCall (array $action, string $filePath, string $fileType, string $namespace) : void {
		# TODO: 400, 403, 404, 405, ...
		# TODO: Separate page and action routines.
		$path = '';
		$class = '';
		$className = '';
		$consumed = [];
		$excess = [];
		if (!$this->actionToPath ($action, $consumed, $excess, $path, $filePath)) {
			$excess = $action;
			$this->notFound ($consumed, $path, $filePath);
		}
		if ($this->buildClassName ($consumed, $class, $className, $fileType, $namespace) && $this->loadFile ($path)) {
			if (class_exists ($class, false) && method_exists ($class, $this->method)) {
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

	/**
		A dead simple 404 routine. Should be improved.
	*/
	private function notFound (array &$consumed, string &$path, string $folder) : void {
		$file = '';
		$consumed = [ 'home' ];
		$path = "${folder}/home/home.php";
	}

	/**
		Builds a script path from the URI path section array.
		\param $action URI path section which is not used for routing.
		\param[out] $consumed An array containing the parts of the URI which were used to construct the script path.
		\param[out] $excess An array containing the parts of the URI which where not used to contruct the script path.
		\param[out] $path Script path will be set to this variable. Must not be used if this method returns false.
		\params $folder API or content directory path.
		\return Returns true if the path was succesfully constructed and false if not.
	*/
	private function actionToPath (array $action, array &$consumed, array &$excess, string &$path, string $folder) : bool {
		$file = '';
		$max = ($count = count ($action)) < 6 ? $count : 6;
		$i = 0;
		while ($i++ < $max) {
			if (!empty ($part = array_splice ($action, 0, 1)[0]) && preg_match ('/^[a-z\/]+$/i', $part) === 1) {
				$file .= "${part}";
				if (file_exists ($lastPath = "${folder}/${file}/{$file}.php")) {
					$consumed [] = $part;
					$excess = $action;
					$path = $lastPath;
				}
				$file .= '_';
			}
		}
		return !empty ($path);
	}

	/**
		Loads and configures the Twig framework to build HTML documents which are sent to the browser.
	*/
	private function buildPage () : void {
		require "{$this->root}/frameworks/Twig/Autoloader.php";
		\Twig_Autoloader::register ();
		$paths				= Config::paths ('twig', 'filesystem');
		$paths []			= $this->page->path ();
		$twigEnv			= Config::get ('client', 'paths');
		$twigEnv ['page']	=  $this->page;
		$twigEnv ['data']	= $this->mess->getData ();
		$loader				= new \Twig_Loader_Filesystem ($paths);
		$twig				= new \Twig_Environment ($loader, [
			'debug' => debug (),
			'cache' => Config::path ('twig', 'cache')
		]);
		$twig->addExtension (new \Twig_Extension_Debug ());
		$template = $twig->loadTemplate ($this->page->content ());
		$template->display ($twigEnv);
	}

	/**
		Sets the default subview of a page visible and all the other are hidden.
	*/
	private function defaultVisibility () : void {
		foreach (array_keys ($this->page->subViews ()) as $view) {
			if ($this->req->has ($view)) {
				$this->page->showSingle ($view);
				return;
			}
		}
	}

	/**
		Takes the request URL path and uses that to locate the correct class name.
		\param $action An array containing the URL path section which is not used for routing.
		\param[out] $class A string where the full class name (namespace included) will be set.
		\param[out] $plainName A string where only the class name (namespace excluded) will be set.
		\param $prefix A prefix for the class name. Used to differ between content and api scripts. Possible values 
			are content and action. These strings are formateted properly so case does not have to be accounted when 
			passing them in.
		\param $namespace Namespace of the script. Possible values are Lora\Content and Lora\Api. These are not changed 
			in anyway so they have to be correctly formed when passed in.
		\return A boolean value is returned telling whether or not a class name could be formed. True is returned if 
			a class name could be created and false if not.
	*/
	private function buildClassName (array $action, string &$class, string &$plainName, string $prefix, string $namespace) : bool {
		foreach ($action as $part) {
			if (!empty ($part) && preg_match ('/^[a-z\/]+$/i', $part) === 1) {
				$class .= ucfirst ($part);
			}
		}
		$plainName = $class;
		$class = "${namespace}\\${prefix}_${class}";
		return !empty ($class);
	}

	/**
		Attempts to include a script from the given path.
		\param $path A file path to a content or action script.
		\return Returns true if the script exists and is succesfully included; false otherwise.
	*/
	private function loadFile (string $path) : bool {
		return file_exists ($path = realpath ($path)) && include $path;
	}
}
