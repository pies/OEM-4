<?php
namespace OEM\Controller;

class Rest {
	
	protected $request;

	protected $view;
	
	public function __construct($request, $view) {
		$this->request = $request;
		$this->view = $view;
	}
	
}
