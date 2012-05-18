<?php

class Hex_Port_Cli extends Hex_Port_Abstract {
	
	public function read() {
		$options = get_opt(array(), array(
			'controller:',
			'action:',
			'adapter::',
			'params::',
			'GET::',
			'POST::',
			'COOKIE::',
			'ENV::',
			'SERVER::',
			'SESSION::',
		));
		$this->controller = $options['controller'];
		$this->action = $options['action'];
		$this->extension = strtolower(isset($options['adapter']) ? $options['adapter'] : 'txt');
		$this->params = isset($options['params']) ? $options['params'] : 'txt';
		foreach (array('GET','POST','COOKIE','ENV','SERVER') as $opt) {
			${"_$opt"} = isset($options[$opt]) ? parse_str($options[$opt]) : array();
		}
		if (isset($options['SESSION'])) {
			if (is_array($_SESSION)) {
				$existing = $_SESSION;
			}
			$_SESSION = array_merge($existing, parse_str($options['SESSION']));
		}
		//$order = ini_get('variables_order') ?: 'GPCES';
		$_REQUEST = array_merge($_GET, $_POST, $_COOKIE);
		$this->data = $_REQUEST;
	}
	
}
