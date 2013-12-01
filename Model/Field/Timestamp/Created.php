<?php
namespace OEM\Model\Field\Timestamp;

class Created extends \OEM\Model\Field\Timestamp {

	public function onInsert() {
		return $this->refresh();
	}
	
}