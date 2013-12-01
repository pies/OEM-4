<?php
namespace OEM\Model;

abstract class Item {

	protected $value = [];

	protected function getField($name) {
		if (!isset($this->value[$name])) {
			throw new \LogicException("Class ".__CLASS__." does not have field {$name}");
		}
		return $this->value[$name];
	}

	public function set($name, $value) {
		return $this->getField($name)->set($value);
	}

	public function __set($name, $value) {
		return $this->set($name, $value);
	}

	public function get($name = null) {
		return null === $name ? $this->value : $this->getField($name);
	}

	public function __get($name) {
		return $this->get($name);
	}

	public function __toString() {
		return json_encode($this->get());
	}

	public function load($data) {
		foreach ($data as $name => $value) {
			$this->getField($name)->load($value);
		}
		return $this;
	}

	protected function clean() {
		foreach ($this->value as $key=>$value) {
			$value->clean();
		}
	}
	
	abstract public function insert();
}