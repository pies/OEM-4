<?php
namespace OEM\Model\Field\Timestamp;

class LastChanged extends \OEM\Model\Field\Timestamp {

	public function onInsert() {
		return $this->refresh();
	}

	public function onUpdate() {
		return $this->refresh();
	}
	
}