<?php

$routesArray = explode('/', $_SERVER['REQUEST_URI']);
$pos = strpos($_SERVER['REQUEST_URI'], '/', strpos($_SERVER['REQUEST_URI'], '/') + 1);
$route = substr($_SERVER['REQUEST_URI'], $pos);
$route = explode('?', $route);
$route = $route[0];
$routesArray = array_filter($routesArray);
$method = $_SERVER['REQUEST_METHOD'];

if(isset($route)){

//======================================================================
// HERE WE CAN LATER ADD AS MANY ENDPOINTS AS WE NEED
//======================================================================
   switch($route){
    case '/appointments':
        include('appointment.php');
        break;
    }
}

//======================================================================
// ANY OTHER NOT DEFINED ROUTE
//======================================================================
 header("HTTP/1.1 404 Not Found");
 exit();