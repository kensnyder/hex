<?php

interface Hex_App_Interface {
	
	public function __construct(Hex_Port_Interface $port);
	
	public function path($type, $setTo = null);
	
	public function import($class);
	
	public function run();
	
	public function runHooks($name, $objects);
	
	public function runError($code);
	
}
