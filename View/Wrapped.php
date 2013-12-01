<?php
namespace OEM\View;

class Wrapped extends Templated {
	
	public $wrapper;
	public $prefix;

	protected function wrap($content) {
		if (!$this->wrapper) return $content;
		$output = $this->template(compact('content'), $this->wrapper);
		return $this->prefix? $this->prefixHtml($output): $output;
	}
	
	public function render($_data_=null, $_template_=null) {
		return $this->wrap(parent::render($_data_, $_template_));
	}

}