<?php
namespace OEM;

class Web {
	
	/**
	 * Returns the application's root web address.
	 * 
	 * @return string
	 */
	public static function root() {
		$file = $_SERVER['SCRIPT_FILENAME'];
		$name = $_SERVER['SCRIPT_NAME'];
		$root = APP_ROOT_DIR;
		return substr($name, 0, strpos($name, substr($file, strlen($root))));
	}
	
}
