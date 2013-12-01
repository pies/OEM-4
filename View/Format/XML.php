<?php
namespace OEM\View\Format;

class XML extends \OEM\View\Base {

	public $contentType = 'application/xml';
	protected $xml;

	public function render() {
		$xml = new \SimpleXMLElement('<response/>');
		$this->addToXML($xml, $this->data);
		return $xml->asXML();
	}

	protected function addToXML(\SimpleXMLElement $node, $array) {
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$new = $node->addChild($key);
				$this->addToXML($new, $value);
			}
			else {
				$node->addChild($key, $value);
			}
		}
	}
}