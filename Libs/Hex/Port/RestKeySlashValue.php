<?php

class Hex_Port_RestKeySlashValue extends Hex_Port_Rest {
	
	public function read() {
		parent::read();
		$this->_loadGet();
	}
	
	protected function _loadGet() {
		if (count($parts) > 2) {
			for ($i = 2; $i < count($parts); $i++) {
				if ($i % 2 == 0) {
					$key = $parts[$i];
				}
				else {
					$_GET[$key] = $_REQUEST[$key] = $parts[$i];
					$key = false;
				}
			}
			if ($key === false) {
				// last key has no value
				$_GET[$key] = $_REQUEST[$key] = null;
			}
		}
	}
	
}
