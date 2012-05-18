<?php

class Hex_Adapter_Pdf extends Hex_Adapter_Html {
	
	public function sendHeaders() {
		// pdf headers
	}
	
	public function render() {
		ob_start();
		parent::render();
		$html = ob_get_clean();
		$pdf = new DOMPDF($html);
		$pdf->send();
	}
	
}
