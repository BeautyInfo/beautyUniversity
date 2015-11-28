<?php
	//get data about beauty data
	header("Content-Type: application/json; charset=utf-8");
	require 'libs/connectDB.php';
	$connection = new connectDB();
	$conn = $connection -> initialDB();
	$result = $connection -> processData($conn, $sql, $data, "get-data");
	$connection -> connectClose();
	echo json_decode($result, true);
?>