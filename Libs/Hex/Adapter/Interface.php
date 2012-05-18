<?php

interface Hex_Adapter_Interface {
	
	public function __construct(Hex_App_Interface $app);
	
	public function sendHeaders();
	
	public function render();
	
}
