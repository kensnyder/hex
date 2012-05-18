<?php

interface Hex_View_Interface {
	
	public function __construct(Hex_App_Interface $app);
	
	public function set($vars, $value = null);
	
	public function get($var);
}
