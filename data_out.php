<?php
	//get data about beauty data
	header("Content-Type: application/json; charset=utf-8");
	header("Access-Control-Allow-Origin: *");
	ob_start("ob_gzhandler");
	require 'libs/connectDB.php';
	$school = filter_input(INPUT_GET, "school");
	$school = htmlentities($school);
	if($school === "university") {
		$sql = "SELECT * FROM beauty_info 
			WHERE (message LIKE '%技術學院%'
			OR message LIKE '%科技大學%'
			OR message LIKE '%科大%'
			OR message LIKE '%專科%' 
			OR message LIKE '%專校%'
			OR message LIKE '%大學%') 
			AND (message NOT LIKE '%北一女%'
			AND message NOT LIKE '%笑容以融化%'
			AND message NOT LIKE '%女中%'
			AND message NOT LIKE '%高中%'
			AND message NOT LIKE '%高職%'
			AND message NOT LIKE '%家商%'
			AND message NOT LIKE '%高商%'
			AND message NOT LIKE '%高一%'
			AND message NOT LIKE '%高二%'
			AND message NOT LIKE '%高三%'
			AND message NOT LIKE '%高工%'
			AND message NOT LIKE '%#127台灣大學歡迎大家推妹!!%'
			AND message NOT LIKE '%商職%'
			AND message NOT LIKE '%友站正妹推薦%'
			AND message NOT LIKE '%高級中學%'
			AND message NOT LIKE '%這裡有大學正妹%'
			AND message NOT LIKE '%畢業%')";
	}
	else if($school === "FJU") {
		$sql = "SELECT * FROM beauty_FJU WHERE (message  not LIKE '%男%' OR message LIKE '%女神%') AND LENGTH(message) <= 200 AND LENGTH(message) > 0";
	}
	else {
		echo "invalid school name.";
		exit();
	}

	$connection = new connectDB();
	$conn = $connection -> initialDB();
	$result = $connection -> processData($conn, $sql, $data = "", "get-data");
	$connection -> connectClose();
	echo $result;
?>