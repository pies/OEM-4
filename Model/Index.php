<?php
namespace OEM\Model;

abstract class Index implements \Iterator {
	
	protected $cursor;
	
	abstract protected function wrap($result);
	
	public function current() {
		return $this->wrap($this->cursor->current());
	}

	public function key() {
		return $this->cursor->key();
	}

	public function next() {
		return $this->cursor->next();
	}

	public function rewind() {
		return $this->cursor->rewind();
	}

	public function valid() {
		return $this->cursor->valid();
	}	
}
