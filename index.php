<?php
	// Require composer autoloader
	require __DIR__ . '/vendor/autoload.php';
	require 'controller/controller.php';
	
	// Create Router instance
	$router = new \Bramus\Router\Router();
	$controller = new myController($router);
	
	$router->get('/data_out/school/(\w+)', function($name) {
		$req = htmlentities($name);
		echo $controller -> indexAction("school_" . $req);
	});
	
	$router -> get('/data_out/school/colleges/(\w+)', function($name) {
		ob_start("ob_gzhandler");
		$req = htmlentities($name);
		echo $controller -> indexAction("colleges_" . $req);
	});
	
	$router->set404(function() {
		header('HTTP/1.1 404 Not Found');
		echo "invalid request url";
	});
	
?>