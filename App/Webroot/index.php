<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

require_once(dirname(__FILE__) . '/../../Libs/Hex/App/Default.php');
$app = new Hex_App_Default( new Hex_Port_Rest() );
require_once(dirname(__FILE__) . '/../Config/bootstrap.php');
//require_once(dirname(__FILE__) . '/../bootstrap.php');
$app->run();
