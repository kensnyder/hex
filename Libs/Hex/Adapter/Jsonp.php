<?php

class Hex_Adapter_Jsonp extends Hex_Adapter_Json {
	
	public function sendHeaders() {
		header('Content-type: text/javascript; charset=utf-8');
	}	
	
	public function render() {
		echo $this->app->port->data['callback'] . '(' . parent::render() . ')';
		return true;
	}
	
}
