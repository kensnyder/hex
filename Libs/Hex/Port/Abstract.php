<?php

abstract class Hex_Port_Abstract implements Hex_Port_Interface {
	
	public $name;
	
	public $controller;
	
	public $action;
	
	public $extension;
	
	public $params;	

	public function __construct() {
		if (!$this->name) {
			$this->name = preg_replace('/^.+Port_([\w_]+)$/', '$1', get_class($this));
		}
	}
	
	public function setApp(Hex_App_Interface $app) {
		$this->app = $app;
	}
	
}
