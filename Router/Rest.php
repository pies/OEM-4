<?php
namespace OEM\Router;

use OEM\Request\HTTP;

class Rest {
	
	/**
	 * @var \OEM\Request\HTTP
	 */
	public $request;

	public $url = '/';
	public $method = HTTP::METHOD_GET;
	public $params = [];
	public $data = [];
	public $contentType = HTTP::CONTENT_TYPE_JSON;
	
	protected $supportedContentTypes = [
		HTTP::CONTENT_TYPE_JSON => '\OEM\View\Format\Json',
		HTTP::CONTENT_TYPE_XML =>  '\OEM\View\Format\XML', 
	];
	
	protected $routes = [];
	
	public function add($route, $handler) {
		$this->routes[$route] = $handler;
		return $this;
	}
	
	protected function findRoute($url) {
		foreach ($this->routes as $route => $class) {
			$regexp = '|^'.$route.'$|';
			if (preg_match($regexp, $url, $regs)) {
				$regs[0] = $class;
				return $regs;
			}
		}
		return null;
	}

	/**
	 * 
	 * @param \OEM\Request\HTTP $request
	 * @return \OEM\View\Base
	 */
	protected function createView(HTTP $request) {
		$contentType = $request->getBestContentType($this->supportedContentTypes);
		if (!$contentType) {
			return null;
		}
		$viewClass = $this->supportedContentTypes[$contentType];
		return new $viewClass();
	}
	
	public function route(HTTP $request) {
		$view = $this->createView($request);
		
		// Client only requests content types that we don't have a view for.
		if (!$view) {
			$view = new View\Format\Json;
			$view->notOK(HTTP::STATUS_NOT_ACCEPTABLE, 'No available content type matches your ACCEPT header.');
			return $view;
		}
		
		$args = $this->findRoute($request->url);
		
		// Client requests a route we don't understand.
		if (null === $args) {
			$view->notOK(HTTP::STATUS_NOT_FOUND, 'No route matches your request.');
			return $view;
		}

		$class = array_shift($args);
		$controller = new $class($request, $view);
		
		// Client request uses a method that is not supported by the controller.
		if (!method_exists($controller, $request->method)) {
			$view->notOK(HTTP::STATUS_METHOD_NOT_ALLOWED, "Requested HTTP method {$request->method} is not available for this route.");
			$view['allow'] = array_values(array_intersect(HTTP::$allMethods, get_class_methods($controller)));
			return $view;
		}
		
		call_user_method_array($request->method, $controller, $args);

		return $view;
	}
	
}
