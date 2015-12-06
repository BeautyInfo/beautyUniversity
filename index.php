<?php
	// Require composer autoloader
	require __DIR__ . '/vendor/autoload.php';
	require 'controller/controller.php';
	
	// Create Router instance
	$router = new \Bramus\Router\Router();
	
	$router->get('https://mywebservice.info/', function() {
		echo "Welcome to beautyUniversity JSON api";
	});
	
	$router->get('/data_out/school/(\w+)', function($name) {
		header('Content-Type: application/json; charset=utf-8');
		ob_start("ob_gzhandler");
		$req = htmlentities($name);
		$controller = new myController($req);
		echo $controller -> indexAction("school_" . $req);
	});
	
	$router -> get('/data_out/school/colleges/(\w+)', function($name) {
		header('Content-Type: application/json; charset=utf-8');
		ob_start("ob_gzhandler");
		$req = htmlentities($name);
		$controller = new myController($req);
		echo $controller -> indexAction("colleges_" . $req);
	});
	
	$router->set404(function() {
		header('HTTP/1.1 404 Not Found');
		echo "invalid request url";
	});
	
	$router -> run();
	
?>