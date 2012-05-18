<?php

class Hex_Adapter_Csv extends Hex_Adapter_Abstract {
	
	public function sendHeaders() {
		header('Content-type: application/octet-stream');
		header("Content-Disposition: attachment; filename=\"{$this->app->port->action}.csv\"");
	}
	
	public function render() {
		// if longer, do not use php://output?
		$fp = fopen('php://output', 'w');
		ob_end_clean();
		ob_start();
		// TODO: find vars that are recordsets?
		foreach ($this->app->view->get() as $r) {
			fputcsv($fp, $r);
		}
		$contents = ob_get_clean();
		fclose($fp);
		if (substr($contents, 0, 2) == 'ID') {
			$contents = preg_replace('/^(ID.*?)(,|$)/', '"$1"', $contents);
		}

		echo $contents;
	}	
	
}
