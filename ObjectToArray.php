<?php
namespace OEM;

if (!function_exists('get_obj_vars')) {
	function get_obj_vars($obj) {
		return get_object_vars($obj);
	}
}

trait ObjectToArray {

	public function __toArray($obj = null) {
		if (null === $obj) {
			$obj = $this;
		}

		$out = array();
		foreach (get_obj_vars($obj) as $key => $val) {
			if (is_object($val)) {
				if (method_exists($val, '__toArray')) {
					$out[$key] = $val->__toArray();
				}
				else {
					$out[$key] = $this->__toArray($val);
				}
			}
			else {
				$out[$key] = $val;
			}
		}
		return $out;
	}
}
