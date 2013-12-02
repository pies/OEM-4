<?php
namespace OEM\Model\Field;

class String extends Base {

	/**
	 * @var string
	 */
	protected $value = '';
	
	public function set($value) {
		return parent::set((string)$value);
	}
	
}
