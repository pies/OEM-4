<?php
namespace OEM\View\Format;

class JavascriptTags extends Tags {

	public function render() {
		$out = array();
		foreach ($this->data as $path) {
			$out[] = "<script src=\"{$path}\" type=\"text/javascript\"></script>";
		}
		return join("\n", $out)."\n";
	}

}