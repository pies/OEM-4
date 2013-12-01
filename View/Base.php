<?php
namespace OEM\View;

abstract class Base extends \OEM\Data {
	
	public $httpCode = 200;

	public $contentType = 'text/html';
	
	/**
	 * HTTP headers to send.
	 * 
	 * @var OEM\View\HttpHeaders;
	 */
	public $headers;

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

}
