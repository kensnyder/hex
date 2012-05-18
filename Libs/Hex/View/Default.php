<?php

class Hex_View_Default implements Hex_View_Interface {
	
	public $app;
	
	protected $___vars = array();
	
	public function __construct(Hex_App_Interface $app) {
		$this->app = $app;
	}
	
	public function set($vars, $val = null) {
		if (is_array($vars)) {
			$this->___vars = array_merge($this->___vars, $vars);
		}
		else {
			$this->___vars[$vars] = $val;
		}
		return $this;
	}
	
	public function get($var = null) {
		if ($var === null) {
			return $this->___vars;
		}
		return isset($this->___vars[$var]) ? $this->___vars[$var] : null;
	}
	
}