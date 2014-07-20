<?php
namespace OEM\View;

use OEM\Data;

abstract class Base extends Data {
	
	public $httpCode = 200;

	public $contentType = 'text/html';
	
	/**
	 * HTTP headers to send.
	 * 
	 * @var HttpHeaders;
	 */
	public $headers;

	
	protected $params;

	public function __construct() {
		$this->headers = new HttpHeaders;
	}
	
	abstract public function render();
	
	public function sendHeaders() {
		header('Content-Type: '.$this->contentType);
		http_response_code($this->httpCode);
		foreach ($this->headers as $name => $value) {
			header($name.': '.$value);
		}
	}
	
	public function __toString() {
		$this->sendHeaders();
		return $this->render();
	}
	
	public function __invoke($params=array()) {
		$this->params = $params;
		return (string) $this;
	}
	
}
