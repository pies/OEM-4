<?php
namespace OEM\Request;

class Rest extends HTTP {
	
	static $apiPrefix = '/api/v1';

	public function __construct() {
		parent::__construct();
		unset($this->params[static::METHOD_OVERRIDE_PARAM]);
	}
		
	const METHOD_OVERRIDE_HEADER = 'X-HTTP-Method-Override';
	const METHOD_OVERRIDE_PARAM = '_type';

	/**
	 * Figure out the request method, which can be overridden in two ways.
	 * 
	 * @return string
	 */
	protected static function getMethod() {
		$method = parent::getMethod();
		
		$header = 'HTTP_'.strtoupper(str_replace('-', '_', static::METHOD_OVERRIDE_HEADER));
		if (!empty($_SERVER[$header])) {
			$method = strtoupper($_SERVER[$header]);
		}

		$param = static::METHOD_OVERRIDE_PARAM;
		if (!empty($_GET[$param])) {
			$method = strtoupper($_GET[$param]);
		}

		return $method;
	}
	
	/**
	 * Get just the base URL, without the application's root URL.
	 * For example, if application is at www.test.com/myApp/ and the requested
	 * URL is /myApp/foo.html, this will return /foo.html.
	 * 
	 * @return string
	 */
	protected static function getBaseUrl() {
		$url = parent::getBaseUrl();
		if (0 === strpos($url, static::$apiPrefix)) {
			$url = substr($url, strlen(static::$apiPrefix));
		}
		return $url;
	}

	private static $ContentTypeExtensionMap = [
		'json' => self::CONTENT_TYPE_JSON,
		'js' => self::CONTENT_TYPE_JSON,
		'xml' => self::CONTENT_TYPE_XML,
		'html' => self::CONTENT_TYPE_HTML,
		'txt' => self::CONTENT_TYPE_TEXT,
		'csv' => self::CONTENT_TYPE_CSV,
	];
	
	/**
	 * Parses the URL for content type derived from file extension.
	 * 
	 * @param type $url
	 * @return string
	 */
	protected static function getAcceptedTypeFromExtension($url) {
		if (!$url) return null;

		$urlLen = strlen($url);
		foreach (self::$ContentTypeExtensionMap as $ext => $type) {
			$len = strlen($ext) + 1;
			if (substr($url, -$len) == '.'.$ext) {
				return $type;
			}
		}
		
		return null;
	}
	
	/**
	 * Adds content type from URL as the most important accepted content type.
	 * 
	 * @return array
	 */
	protected function getAcceptedTypes() {
		$accept = parent::getAcceptedTypes();

		$typeFromUrl = self::getAcceptedTypeFromExtension($this->url);
		if (!$typeFromUrl) {
			return $accept;
		}

		$accept[$typeFromUrl] = 2;
		arsort($accept);

		$this->url = substr($this->url, 0, strpos($this->url, '.'));
		
		return $accept;
	}
	
}
