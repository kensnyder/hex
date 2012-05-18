<?php

class Controller_Test extends Hex_Controller_Abstract {
	
	public function test() {
		$a = 1;
		$b = '2';
		$this->app->view->set(compact('a','b'));
	}
	
}