<?php

class Hex_Adapter_Txt extends Hex_Adapter_Html {
	
	public $txtExtension = 'txt';
	
	public function getTemplatePath() {
		$base = $this->app->path('Template') . '/' . $this->app->port->controller . '/' . $this->app->port->action;
		if (is_file($base . '.' . $this->txtExtension)) {
			return $base . '.' . $this->txtExtension;
		}
		return parent::getTemplatePath();
	}
	
	public function getLayoutPath() {
		// $this->app->findFile('Layout', $this->app->port->layout, 
		$base = $this->app->path('Layout') . '/' . $this->app->port->layout;
		if (is_file($base . '.' . $this->txtExtension)) {
			return $base . '.' . $this->txtExtension;
		}
		return parent::getLayoutPath();		
	}	
	
	public function render() {
		ob_start();
		parent::render();
		$html = ob_get_clean();
		$txt = strip_tags($html);
		$txt = preg_replace('/ +/', ' ', $txt);
		echo $txt;
	}
	
}
