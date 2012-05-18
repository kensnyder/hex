<?php

class Hex_App_Default implements Hex_App_Interface {
	
	public $port;
	
	public $view;
	
	public $adapter;
	
	protected $_paths = array();
	
	public function __construct(Hex_Port_Interface $port) {
		$this->port = $port;
		$port->setApp($this);
		$this->setupDefaultPaths();
	}
	
	public function setupDefaultPaths() {
		foreach (array('Port','Adapter','Controller','Component','Helper') as $type) {
			$this->path($type, realpath(__DIR__ . "/../../../App/$type"));
		}		
	}	
	
	public function path($type, $setTo = null) {
		if ($setTo === null) {
			return isset($this->_paths[$type]) ? $this->_paths[$type] : null;
		}
		$this->_paths[$type] = $setTo;
	}
	
	public function findFile() {
		
	}
	
	public function import($class) {
		if (preg_match('/^(Port|Controller|Component|View|Helper|Adapter)_(.+)$/', $class, $match)) {
			list (, $type, $child) = $match;
			$child = str_replace('_', '/', $child);
			$userPath = $this->path($type) . "/$child.php";			
			if (is_file($userPath)) {
				require_once($userPath);
				return $class;
			}
			$hexPath = __DIR__ . "/../$type/$child.php"; 
			if (is_file($hexPath)) {
				require_once($hexPath);
				return "Hex_$class";
			}			
		}
ppr('import failed', $class, @$userPath, @$hexPath);
		if (class_exists($class, true)) {
			return $class;
		}
		return false;
	}
	
	public function run() {
		$this->runHooks('BeforeRead', array('port'));
		$this->port->read();
		$this->runHooks('AfterRead', array('port'));
		$name = ucwords($this->port->controller);
		$controllerClass = $this->import("Controller_$name");
		if (!$controllerClass) {
			$this->runError('controller_not_found');
		}		
		$this->useAdapter($this->port->extension);
		$viewClass = $this->import('View_Default');
		if (!$viewClass) {
			$this->runError('view_not_found');
		}
		$this->runHooks('BeforeController', array('port','adapter'));
		$this->view = new $viewClass($this);
		$this->controller = new $controllerClass($this);
		if (!is_callable(array($this->controller, $this->port->action))) {
			$this->runError('action_not_found');
		}
		$this->runHooks('BeforeAction', array('port','controller','adapter'));
		call_user_func_array(array($this->controller, $this->port->action), $this->port->params);
		$this->runHooks('BeforeRender', array('port','controller','adapter'));
		$this->adapter->sendHeaders();
		$this->adapter->render();
		$this->runHooks('AfterRender', array('port','controller','adapter'));
	}
	
	public function useAdapter($name) {
		$name = ucwords($name);
		$adapterClass = $this->import("Adapter_$name");
		if (!$adapterClass) {
			$this->runError('adapter_not_found');
		}
		return $this->adapter = new $adapterClass($this);
	}
	
	public function runHooks($name, $objects) {
		$event = 'on' . $name;
		foreach ($objects as $o) {
			if (is_callable(array($this->$o, $event))) {
				$this->$o->$event();
			}
		}
		return $this;
	}
	
	public function runError($code) {
		$class = get_class($this);
pprd('runError', $code);		
		$app = new $class($this->port);
		$port->controller = 'Error';
		$port->action = $code;
		
	}
	
}
