<?php
namespace OEM\Request;

use OEM\Web;

class HTTP {
	
	/**
	 * Possible HTTP methods.
	 */
	const METHOD_HEAD = 'HEAD';
	const METHOD_GET = 'GET';
	const METHOD_PUT = 'PUT';
	const METHOD_POST = 'POST';
	const METHOD_DELETE = 'DELETE';
	
	public static $allMethods = [
		self::METHOD_HEAD,
		self::METHOD_GET,
		self::METHOD_PUT,
		self::METHOD_POST,
		self::METHOD_DELETE
	];
	
	/**
	 * Various basic content types.
	 */
	const CONTENT_TYPE_JSON = 'application/json';
	const CONTENT_TYPE_XML = 'application/xml';
	const CONTENT_TYPE_HTML = 'text/html';
	const CONTENT_TYPE_TEXT = 'text/plain';
	const CONTENT_TYPE_CSV = 'text/csv';
	
	/**
	 * Successful and returning data.
	 */
	const STATUS_OK = 200;
	
	/**
	 * Resource created, adding Location header.
	 */
	const STATUS_CREATED = 201;
	
	/**
	 * Successful and not returning data.
	 */
	const STATUS_NO_CONTENT = 204;
	
	/**
	 * Incorrect parameters.
	 */
	const STATUS_BAD_REQUEST = 400;
	
	/**
	 * Resource not found.
	 */
	const STATUS_NOT_FOUND = 404;
	
	/**
	 * HTTP method not supported for selected resource, adding Allow header.
	 */
	const STATUS_METHOD_NOT_ALLOWED = 405;
	
	/**
	 * Output format not supported.
	 */
	const STATUS_NOT_ACCEPTABLE = 406;
	
	/**
	 * Unexpected server error.
	 * Also known as "database died error".
	 */
	const STATUS_INTERNAL_SERVER_ERROR = 500;
	
	/**
	 * HTTP method not supported by server
	 */
	const STATUS_NOT_IMPLEMENTED = 501;

	public $url = '/';
	public $params = [];
	public $method = self::METHOD_GET;
	public $accept = [];
	public $data = [];
	
	public $isContentTypeFromUrl = false;
	
	public function __construct() {
		$this->parse();
	}
	
	public function parse($uri=null) {
		$this->method = static::getMethod();

		if (!$uri) $uri = static::getBaseUrl();
		$elements = parse_url($uri);
		$this->url = $elements['path'];

		if (isset($elements['query'])) {
			parse_str($elements['query'], $this->params);
		}
		
		$this->accept = $this->getAcceptedTypes();
		$this->data = static::getData($this->method);
	}
	
	/**
	 * Get just the base URL, without the application's root URL.
	 * For example, if application is at www.test.com/myApp/ and the requested
	 * URL is /myApp/foo.html, this will return /foo.html.
	 * 
	 * @return string
	 */
	protected static function getBaseUrl() {
		$root = Web::root();
		$url = $_SERVER['REQUEST_URI'];
		if (false !== $pos = strpos($url, $root)) {
			$url = substr($url, $pos + strlen($root));
		}
		return $url;
	}
	
	/**
	 * Return the request method.
	 * 
	 * @return string
	 */
	protected static function getMethod() {
		return strtoupper($_SERVER['REQUEST_METHOD']);
	}
	
	/**
	 * Parses the Accept header to get a list of acceptable content types.
	 * 
	 * @return array
	 */
	protected function getAcceptedTypes() {
		$accept = array();

		// Accept header is case insensitive, and whitespace isn’t important
		$header = strtolower(str_replace(' ', '', $_SERVER['HTTP_ACCEPT']));
		
		// divide it into parts in the place of a ","
		foreach (explode(',', $header) as $type) {
			// the default quality is 1.
			$quality = (float) 1;
			// check if there is a different quality
			if (strpos($type, ';q=')) {
				// divide "mime/type;q=X" into two parts: "mime/type" i "X"
				list($type, $quality) = explode(';q=', $type);
			}
			// mime-type $a is accepted with the quality $q
			// WARNING: $q == 0 means, that mime-type isn’t supported!
			$accept[$type] = (float) $quality;
		}

		arsort($accept);
		return $accept;
	}

	/**
	 * Returns the data array appropriate to the request method.
	 * 
	 * @param string $method
	 * @return array
	 */
	private static function getData($method) {
		$data = array();
		switch ($method) {
			case static::METHOD_PUT:
				parse_str(file_get_contents("php://input"), $data);
				break;
			case static::METHOD_POST:
				$data = $_POST;
				break;
		}
		return $data;
	}
	
	/**
	 * Compares provided list of possible content types with the client's
	 * list of accepted types and figures out which is the best match.
	 * 
	 * @param array $possibleTypes
	 * @return string
	 */
	public function getBestContentType(array $possibleTypes) {
		$possibleTypes = array_map('strtolower', $possibleTypes);

		// let’s check our supported types:
		foreach ($this->accept as $type => $quality) {
			if ($quality && isset($possibleTypes[$type])) {
				return $type;
			}
		}
		// no mime-type found
		return null;
	}

	
}

