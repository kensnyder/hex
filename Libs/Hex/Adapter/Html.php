<?php

class Hex_Adapter_Html extends Hex_Adapter_Abstract {
	
	public $templateExtension = 'tpl';
	
	public function sendHeaders() {
		header('Content-type: text/html; charset=utf-8');
	}	
	
	public function render() {
		extract($this->app->view->get());
		$__tpl = $this->getTemplatePath();
		ob_start();
		include($__tpl);
		$pageContent = ob_get_clean();
		
		$__layout = $this->getLayoutPath();
		ob_start();
		include($__layout);
		echo ob_get_clean();
		return true;
	}
	
	public function getTemplatePath() {
pprd($this->app->path('Template'), $this->app->port);		
		return $this->app->path('Template') . '/' . $this->app->port->controller . '/' . $this->app->port->action . '.' . $this->templateExtension;
	}
	
	public function getLayoutPath() {
pprd($this->app->path('Layout'), $this->app->port);		
		$layout = isset($this->app->controller->layout) && $this->app->controller->layout ? $this->app->controller->layout : 'default';
		return $this->app->path('Layout') . '/' . $layout . '.' . $this->templateExtension;
	}	
	
}
