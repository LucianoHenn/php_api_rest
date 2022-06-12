<?php
require __DIR__ . "/inc/bootstrap.php";


//======================================================================
// STORE ERRORS
//======================================================================
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log',  PROJECT_ROOT_PATH . '/php_error_log');

require "controllers/RoutesController.php";

$RoutesController = new RoutesController();
$RoutesController->index();
return;
 

?>