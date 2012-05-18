<?php

abstract class Hex_Adapter_Abstract implements Hex_Adapter_Interface {
	
	public $name;
	
	public $app;
	
	public $helpers = array();
	
	public function __construct(Hex_App_Interface $app) {
		$this->app = $app;
		if (!$this->name) {
			$this->name = preg_replace('/^.+Adapter_([\w_]+)$/', '$1', get_class($this));
		}
	}
	
	public function __get($prop) {
		$class = $prop . 'Helper';
		if ($this->app->import($class)) {
			return $this->helpers[$prop] = $this->$prop = new $class($this);
		}
		return null;
	}
	
	public function partial($name, $setVars = array()) {
		//$path = $this->getPartialPath() . "/$name." . $this->getTemplateExtension();
	}
		
}
