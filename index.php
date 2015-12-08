<?php
	// Require composer autoloader
	require __DIR__ . '/vendor/autoload.php';
	require 'controller/controller.php';
	
	// Create Router instance
	$router = new \Bramus\Router\Router();
	

	$router -> before('GET', '/.*', function() {
		header('X-Powered-By: router');
	});

	$router->get('/', function() {
		echo "Welcome to beautyUniversity JSON api";
	});
	
	$router->get('/v1/school/(\w+)/analytic/(\w+)', function($name, $bool) {
		header('Content-Type: application/json; charset=utf-8');
		ob_start("ob_gzhandler");
		$req = htmlentities($name);
		$check = htmlentities($bool);
		$controller = new myController($req);
		
		if($check === "yes")
			echo $controller -> indexAction("colleges_" . $req);
		if($check === "no")
			echo $controller -> indexAction("school_" . $req);
	});
	
	$router->set404(function() {
		header('HTTP/1.1 404 Not Found');
		echo "invalid request url";
	});
	
	$router -> run();
?>