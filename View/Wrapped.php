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
	
	public function render($data=null, $template=null) {
		return $this->wrap(parent::render($data, $template));
	}

}