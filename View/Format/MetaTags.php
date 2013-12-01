<?php
namespace OEM\View\Format;

class MetaTags extends Tags {

	private function getLabelName($key) {
		if (
			strpos($key, 'og:') === 0 ||
			strpos($key, 'fb:') === 0
		) return 'property';
		return 'name';
	}

	public function render() {
		$out = array();
		foreach ($this->data as $key=>$val) {
			$label = $this->getLabelName($key);
			$out[] = "<meta {$label}=\"{$key}\" content=\"{$val}\"/>";
		}
		return join("\n", $out)."\n";
	}

}