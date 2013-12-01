<?php
namespace OEM\View\Format;

class CssTags extends Tags {

	public function render() {
		$out = array();
		foreach ($this->data as $path) {
			$out[] = "<link rel=\"stylesheet\" href=\"{$path}\"/>";
		}
		return join("\n", $out)."\n";
	}

}