<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");
 
// include main configuration file
require_once PROJECT_ROOT_PATH . "/inc/config.php";
 
// include the base controller file
require_once PROJECT_ROOT_PATH . "/controllers/BaseController.php";
 
// include interfaces
require_once PROJECT_ROOT_PATH . "/interfaces/AppointmentInterface.php";

// include the models file
require_once PROJECT_ROOT_PATH . "/models/AppointmentModel.php";
?>