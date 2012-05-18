<?php

require_once(dirname(__FILE__) . '/../../Libs/Hex/Bootstrap.php');
new Hex_Bootstrap();
$app = new Hex_App_Default( new Hex_Port_Cli() );
require_once(dirname(__FILE__) . '/../Config/bootstrap.php');
$app->run();
