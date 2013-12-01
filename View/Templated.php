<?php
namespace OEM\View;

class Templated extends Base {

	public $template;

	public function prefixHtml($html) {
		$pairs = array(
			// exceptions
			' href="#'        => ' _href_="#',
			' href="mailto:'  => ' _href_="mailto:',
			' href="http:'    => ' _href_="http:',
			' href="https:'   => ' _href_="https:',

			' src=""'         => ' _src_=""',
			' src="#'         => ' _src_="#',
			' src="http:'     => ' _src_="http:',
			' src="https:'    => ' _src_="https:',
			' src="//'        => ' _src_="//',

			' action="#'      => ' _action_="#',
			' action="mailto:'=> ' _action_="mailto:',
			' action="http:'  => ' _action_="http:',
			' action="https:' => ' _action_="https:',

			' href="/'        => ' href="',
			' src="/'         => ' src="',
			' action="/'      => ' action="',

			' href="'         => ' href="'.$this->prefix.'/',
			' src="'          => ' src="'.$this->prefix.'/',
			' action="'       => ' action="'.$this->prefix.'/',

			' _src_="'        => ' src="',
			' _href_="'       => ' href="',
			' _action_="'     => ' action="',
		);

		return str_replace(array_keys($pairs), array_values($pairs), $html);
	}
	
	protected function template($_data_=null, $_template_=null) {
		if (null === $_data_) $_data_ = $this->data;
		if (null === $_template_) $_template_ = $this->template;
		extract($_data_);
		ob_start();
		include($_template_);
		return ob_get_clean();
	}
	
	public function render($_data_=null, $_template_=null) {
		return $this->template($_data_, $_template_);
	}

	public function insert($_template_, $_data_=array()) {
		extract($_data_);
		ob_start();
		include($_template_);
		return ob_get_clean();
	}
	
}