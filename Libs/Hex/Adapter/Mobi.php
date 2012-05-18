<?php

class Hex_Adapter_Mobi extends Hex_Adapter_Html {
	
	public $mobileTemplateExtension = 'mobi.tpl';
	
	public function getTemplatePath() {
		$base = $this->app->path('Template') . '/' . $this->app->port->controller . '/' . $this->app->port->action;
		if (is_file($base . '.' . $this->mobileTemplateExtension)) {
			return $base . '.' . $this->mobileTemplateExtension;
		}
		return parent::getTemplatePath();
	}
	
	public function getLayoutPath() {
		$base = $this->app->path('Layout') . '/' . $this->app->port->layout;
		if (is_file($base . '.' . $this->mobileTemplateExtension)) {
			return $base . '.' . $this->mobileTemplateExtension;
		}
		return parent::getLayoutPath();		
	}
	
}
