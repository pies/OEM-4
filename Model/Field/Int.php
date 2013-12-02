<?php
namespace OEM\Model\Field;

class Int extends Base {

	/**
	 * @var int
	 */
	protected $value = 0;
	
	public function set($value) {
		return parent::set((int)$value);
	}
	
	public function __toString() {
		return (string) $this->value;
        }
}
