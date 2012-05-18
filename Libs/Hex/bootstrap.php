<?php

spl_autoload_register(function($class) {
	$path = realpath(__DIR__ . '/../' . str_replace('_', '/', $class) . '.php');
	if (is_file($path)) {
		require_once($path);
	}
	else {
		echo "cant autoload $class at `$path`";
	}
});

require_once(__DIR__ . '/ppr.php');