<?php
namespace OEM\Model\Mongo;

abstract class Item extends \OEM\Model\Item {
	
	/**
	 * @var \MongoId
	 */
	public $_id;
	
	/**
	 * @return \MongoCollection
	 */
	abstract protected function collection();
	
	private function getDataForInsert() {
		$out = array();
		foreach ($this->value as $key => $value) {
			$value->onInsert();
			if ($value->isDirty()) {
				if (!$value->isValid()) {
					throw new \ErrorException("Value of {$key} is invalid.");
				}
				$method = method_exists($value, '__toMongo')? '__toMongo': 'get';
				$out[$key] = $value->$method();
			}
		}
		return $out;
	}
	
	public function insert() {
		$data = $this->getDataForInsert();
		$success = $this->collection()->insert($data);
		if ($success) {
			$this->clean();
			$this->_id = $data['_id'];
		}
		return $success;
	}

	public function load($data) {
		foreach ($data as $name => $value) {
			if ('_id' === $name) {
				$this->_id = $value;
			}
			else {
				$field = $this->getField($name);
				if (method_exists($field, '__fromMongo')) {
					$value = $field->__fromMongo($value);
				}
				$field->load($value);
			}
		}
		return $this;
	}
	
}
