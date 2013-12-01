<?php
namespace OEM;

abstract class Data implements \ArrayAccess, \Iterator {
	
	public $data = array();
	
	public function offsetExists($offset) {
		return isset($this->data[$offset]);
	}

	public function offsetGet($offset) {
		return $this->data[$offset];
	}

	public function offsetSet($offset, $value) {
		return $offset === null?
			$this->data[] = $value:
			$this->data[$offset] = $value;
	}

	public function offsetUnset($offset) {
		unset($this->data[$offset]);
	}
	
	public function set(array $data) {
		foreach ($data as $kk => $vv) {
			$this->data[$kk] = $vv;
		}
		return $this->data;
	}
	
	public function clear() {
		return $this->data = array();
	}

	public function rewind() {
		reset($this->data);
	}

	public function current() {
		return current($this->data);
	}

	public function key() {
		return key($this->data);
	}

	public function next() {
		return next($this->data);
	}

	public function valid() {
		$key = key($this->data);
		return ($key !== null && $key !== false);
	}
}
