<?php
namespace OEM\View\Format;

class Html extends \OEM\View\Wrapped {
	
	public $charset = 'utf-8';
	public $title = '';
	
	/**
	 * @var Meta
	 */
	public $meta;

	/**
	 * @var Javascript
	 */
	public $js;
	
	/**
	 * @var CSS
	 */
	public $css;
	
	public $wrapper = 'OEM/View/Format/Html.html';

	public $contentType = 'text/html';
	
	public function __construct() {
		parent::__construct();
		$this->meta = new MetaTags();
		$this->js = new JavascriptTags();
		$this->css = new CssTags();
	}

}