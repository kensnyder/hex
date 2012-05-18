<?php

class Hex_Adapter_Xml extends Hex_Adapter_Abstract {
	
	public function sendHeaders() {
		header('Content-type: text/xml; charset=utf-8');
	}
	
	public function render() {
		echo '<?xml version="1.0" encoding="UTF-8"?><response>' . $this->_toXml($this->view->get()) . '</response>';
	}
	
	public function _toXml($data) {
		if (is_string($data)) {
			if ($data{0} == '<') {
				return "<![CDATA[$data]]>";
			}
			return str_replace("'", '&apos;', htmlspecialchars($data, ENT_QUOTES, 'utf-8'));
		}
		if (is_bool($data)) {
			return (string) (int) $data;
		}
		if (is_numeric($data)) {
			return (string) $data;
		}
		if (is_object($data)) {
			$data = get_object_vars($data);
		}		
		if (!is_array($data)) {
			// resource or something weird
			return '';
		}
		$xml = '';
		foreach ($data as $key => $value) {
			if (is_object($value)) {
				$value = get_object_vars($value);
			}
			if (is_array($value) && is_int(key($value))) {
				// we have a list of items
				$singular = Inflector::singularize($key);
				if ($singular == $key) {
					$key = Inflector::pluralize($key);
					if ($key == $singular) {
						$key = $key . '_group';
					}
				}
				$xml .= "<$key>";
				$i = 0;
				foreach ($value as $k => $v) {					
					$xml .= "<$singular>";
					if ($k != $i++) {
						$xml .= "<value>$k</value>";
					}
					$xml .= self::xmlTagify($v) . "</$singular>";
				}
				$xml .= "</$key>";
			}
			else {
				$xml .= "<$key>" . self::xmlTagify($value) . "</$key>";
			}
		}
		return $xml;
	}		
	
}
