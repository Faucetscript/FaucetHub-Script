<?php
require_once 'includes/core.php';

if(isset($_GET['route'])) {
	$route = $_GET['route'];
} else {
	$route = 'home/index';
}

$security = new CSRF;
$token = $security->set(3, 3600);

$routeParts = explode('/', $route);
$controller = ucfirst($routeParts[0]) . 'Controller';
$method = ucfirst($routeParts[1]);

if(count($routeParts) == 1) {
	header("Location: index.php?route=" . $routeParts[0] . '/home');
	exit();
}

$reqMethod = 'get';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['token'])) {
	  if($security->get($token)) {
	    $security->delete($token);
	    $reqMethod = 'post';
	  }
	}
}

$smarty->assign('csrf_field', '<input type="hidden" name="token" value="' . $security->set(3, 3600) . '" />');

$method = $reqMethod . $method;
if(class_exists($controller)) {
	$controller = new $controller($smarty, $security, $db, $controller . '.' . $method);
	if(method_exists($controller, $method)) {
		print $controller->$method();	
	} else {
		echo 404;
	}
} else {
	echo 404;
}