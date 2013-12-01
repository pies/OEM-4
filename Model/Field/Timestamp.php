<?php
namespace OEM\Model\Field;

class Timestamp extends Base {
	
	/**
	 * @var \DateTime
	 */
	protected $value;
	
	public function load($value) {
		$this->value = new \DateTime;
		$this->value->setTimestamp($value);
	}
	
	public function refresh() {
		$this->dirty = true;
		return $this->load(time());
	}

	public function format($format) {
		return $this->value->format($format);
	}
	
	public function __toString() {
		return $this->value?
			$this->value->format('c'):
			'';
	}
	
	public function __toMongo() {
		return new \MongoDate($this->value->getTimestamp());
	}
	
	public function __fromMongo(\MongoDate $value) {
		return $value->sec;
	}
	
	public function set($value) {
		throw new \LogicException(__CLASS__." value can not be directly modified.");
	}
	
}