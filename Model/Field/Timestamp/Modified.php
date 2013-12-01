<?php
namespace OEM\Model\Field\Timestamp;

class Modified extends \OEM\Model\Field\Timestamp {

	public function onUpdate() {
		return $this->refresh();
	}
	
}