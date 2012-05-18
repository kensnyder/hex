<?php

abstract class Hex_Controller_Abstract implements Hex_Controller_Interface {

	public $app;
	
	public $adapter;
	
	public $components = array();
	
	public function __construct(Hex_App_Interface $app) {
		$this->app = $app;
	}
	
	public function __get($prop) {
		$class = $prop . 'Component';
		if ($this->app->import($class)) {
			return $this->components[$prop] = $this->$prop = new $class($this);
		}
		return null;
	}
		
}
