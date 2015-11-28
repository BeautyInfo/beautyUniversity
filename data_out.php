<?php
	//get data about beauty data
	header("Content-Type: application/json; charset=utf-8");
	header("Access-Control-Allow-Origin: *");
	ob_start("ob_gzhandler");
	require 'libs/connectDB.php';
	$connection = new connectDB();
	$conn = $connection -> initialDB();
	$result = $connection -> processData($conn, $sql = "SELECT * FROM beauty_info", $data = "", "get-data");
	$connection -> connectClose();
	echo $result;
?>