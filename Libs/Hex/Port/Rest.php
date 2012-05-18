<?php

class Hex_Port_Rest extends Hex_Port_Abstract {
	
	protected $_routes = array();
	
	public function read() {
		$path = trim($_GET['HEXURL'], '/');
		unset($_GET['HEXURL']);
		$this->applyRoutes($path);
		$parts = explode('/', $path);
		if (!$this->controller) {
			$this->controller = $parts[0] ?: 'index';
		}
		if (!$this->action) {
			$this->action = @$parts[1] ?: 'index';
		}
		if (!$this->extension) {
			if (preg_match('/\.([a-z0-9]+)$/', $this->action, $match)) {
				$this->extension = strotolower($match[1]);
			}
			else {
				$this->extension = 'html';
			}
			if ($this->extension == 'html' && @$_SERVER['HTTP_X_REQUESTED_WITH'] == 'xmlhttprequest') {
				$this->extension == 'ajax';
			}
		}
		if (!$this->params) {
			$this->params = array_slice($parts, 2);
		}
	}
	
	public function addRoute($url, $options) {
		$route = $options;
		$route['_params'] = array();
		$url = trim($url, '/');
		$regex = preg_quote($url, '@');
		$idx = 1;
		$regex = preg_replace_callback('/(\:\w+/|\*)/', function($match) use (&$route, &$idx) {
			if ($match[1] == '*') {
				$route['_params'][$i] = $i;
			}
			else {
				$route['_params'][$i] = trim($match[1], ':');
			}
			$i++;
			return '([^/]+)';
		}, $regex);
		$regex = "@^$regex@";
		$this->_routes[$regex] = $route;
		return $this;
	}
	
	public function applyRoutes($path) {
		foreach ($this->_routes as $regex => $route) {
			if (preg_match($regex, $path, $match)) {
				$this->applyRoute($route, $match);
				break;
			}
		}
		return $this;
	}
	
	public function applyRoute($route, $match) {
		if (isset( $route['controller'] )) $this->controller = $route['controller'];
		if (isset( $route['action']     )) $this->action = $route['action'];
		if (isset( $route['extension']  )) $this->extension = $route['extension'];
		if (count($route['_params'])) {
			for ($i = 1; $i < count($match); ++$i) {
				$key = $route['_params'][$i];
				if (is_int($key)) {
					$this->params[] = $match[$i];					
				}
				elseif ($key == 'controller') {
					$this->controller = $match[$i];
				}
				elseif ($key == 'action') {
					$this->action = $match[$i];
				}
				elseif ($key == 'extension') {
					$this->extension = $match[$i];
				}
				else {
					$_REQUEST[$key] = $_GET[$key] = $match[$i];
				}
			}
		}
	}
	
}
