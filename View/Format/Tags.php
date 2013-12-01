<?php
namespace OEM\View\Format;

abstract class Tags extends \OEM\Data {
	
	public function __toString() {
		return $this->render();
	}
	
}