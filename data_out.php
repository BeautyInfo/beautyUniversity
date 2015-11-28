<?php
	//get data about beauty data
	require 'libs/connectDB.php';
	header("Content-Type: application/json; charset=utf-8");
	$connection = new connectDB();
	$conn = $connection -> initialDB();
	$result = $connection -> processData($conn, $sql, $data, "get-data");
	$connection -> connectClose();
	echo json_decode($result, true);
?>