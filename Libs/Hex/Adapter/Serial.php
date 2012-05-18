<?php

class Hex_Adapter_Serial extends Hex_Adapter_Abstract {
	
	public function sendHeaders() {
		header('Content-type: application/x-serialized-php; charset=utf-8');
	}	
	
	public function render() {
		echo serialize($this->app->view->get());
	}
	
}
