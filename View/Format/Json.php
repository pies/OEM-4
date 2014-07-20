<?php
namespace OEM\View\Format;

use OEM\View\Base;

class Json extends Base {
	
	public $contentType = 'application/json';

	private function setOK($state, $httpCode=null, $message=null) {
		$this['ok'] = $state;
		if (null !== $httpCode) {
			$this->httpCode = $httpCode;
		}
		if (null !== $message) {
			$this['message'] = $message;
		}
	}
	
	public function isOK($httpCode=null, $message=null) {
		return $this->setOK(true, $httpCode, $message);
	}
	
	public function notOK($httpCode=null, $message=null) {
		return $this->setOK(false, $httpCode, $message);
	}
	
	public function render() {
		return json_encode($this->data);
	}

}