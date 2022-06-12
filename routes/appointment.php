<?php

require PROJECT_ROOT_PATH . "/controllers/AppointmentController.php";
$appointmentController = new AppointmentController();

switch ($method) {
    case 'GET':
        $appointmentController->findAllByDoctorId();
        break;
    case 'POST':
        $appointmentController->createNew();
        break;
    case 'PUT':
        $appointmentController->updateStatus();
        break;
    }