<?php
session_start();
include('classes/DB.php');
include('classes/Router.php');
include('classes/Message.php');
include('config/constants.php');

// Getting page Tamplate and Title
$page = isset($_GET['page']) ? $_GET['page'] : '';
$Router = new Router();

$route = $Router->getTamplate($page);

$head['title'] = $route->title;
$head['js'] = $route->js;
$head['css'] = $route->css;

$tamplate = $route->tamplate;



// Checking Messages 
$msg['danger'] = Message::getErrorMessage();
$msg['success'] = Message::getSuccessMessage();

// Creating View
include('tamplates/header.php');
require_once($tamplate);
include('tamplates/footer.php');
?>
