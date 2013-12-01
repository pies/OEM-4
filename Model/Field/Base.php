<?php
namespace OEM\Model\Field;

abstract class Base {
	
	protected $value;
	protected $params = [];
	protected $dirty = false;
	
	public function __construct($params=[]) {
		$this->params = $params;
	}

	public function get() {
		return $this->value;
	}
	
	public function set($value) {
		$this->dirty = true;
		return $this->value = $value;
	}
	
	public function load($value) {
		return $this->value = $value;
	}

	public function onInsert() {}

	public function onUpdate() {}
	
	public function __toString() {
		return (string) $this->value;
	}

	public function isValid() {
		return true;
	}
	
	public function isDirty() {
		return (bool) $this->dirty;
	}
	
	public function clean() {
		return $this->dirty = false;
	}
	
}