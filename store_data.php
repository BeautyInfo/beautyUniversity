<?php
	set_time_limit(0);
	//connectDB library
	require 'libs/connectDB.php';
	//curl helper function library
	require 'libs/LIB_http.php';
	
	class storeData
	{
		//get Fan's page
		public function getPage($url, $target)
		{
			$webPage = http_get($url, $target);
			$webPage = $webPage["FILE"];
			return json_decode($webPage, true);
		}
	}
	
	$storeData = new storeData();
	
	//get fan's page
	$data = array();
	$page = $storeData -> getPage("https://graph.facebook.com/477809915685496/feed?access_token=253357841540620|CSpNBptAuQNfS7_2jXjSZ-455tE", "");
	
	$count = count($page["data"]);
	$connection = new connectDB();
	$conn = $connection -> initialDB();
	while($count !== 0)
	{
		for($count_data=0;$count_data<$count;$count_data++)
		{
			if(isset($page["data"][$count_data]["message"]))
				$message = $page["data"][$count_data]["message"];
			else
				$message = "";
			if(isset($page["data"][$count_data]["object_id"]))
				$object_id = $page["data"][$count_data]["object_id"];
			else
				$object_id = "";
			if(isset($page["data"][$count_data]["created_time"]))
				$created_time = $page["data"][$count_data]["created_time"];
			else
				$created_time = "";
			
			$data["message"] = str_replace("☺ ", "", trim($message));
			$data["message"] = str_replace("\n", "", $data["message"]);
			$data["object_id"] = $object_id;
			$data["created_time"] = $created_time;
			
			$sql = "INSERT INTO beauty_info(message,obj_id,created_time) VALUES(:message,:object_id,:created_time)";
			$result = $connection -> processData($conn, $sql, $data, "insert-record");
			
			switch($result)
			{
				case "insert-fail":
					file_put_contents("log/error.log", "insert-fail,".$message.",".$object_id."\r\n", FILE_APPEND);
					break;
				case "duplicate-entry":
					file_put_contents("log/error.log", "duplicate-entry,".$message.",".$object_id."\r\n", FILE_APPEND);
					break;
			}
		}
		
		$page = $storeData -> getPage($page["paging"]["next"], "");
		$count = count($page["data"]);
	}
	
	$connection -> connectClose();
?>