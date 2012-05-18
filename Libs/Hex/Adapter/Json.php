<?php

class Hex_Adapter_Json extends Hex_Adapter_Abstract {
	
	public function sendHeaders() {
		header('Content-type: text/json; charset=utf-8');
	}	
	
	public function render() {
		echo json_encode($this->app->view->get());
	}
	
}
