<?php
	set_time_limit(0);
	//connectDB library
	$filePath = __DIR__.'/../model/libs/';
	require $filePath.'connectDB.php';
	//curl helper function library
	require $filePath.'LIB_http.php';
	
	class storeData {
		//get Fan's page
		public function getPage($url, $target) {
			$webPage = http_get($url, $target);
			$webPage = $webPage["FILE"];
			return json_decode($webPage, true);
		}
	}
	
	$storeData = new storeData();
	$token = "922569917793667|KTu9S6oja2E6yYbP0fbAD8wnHNA";
	$counter = 0;
	//get fan's page
	$page_arr = array(
		"477809915685496",
		"476194535860239"
	);

	$connection = new connectDB();
	$conn = $connection -> initialDB();
	while($counter < count($page_arr)) {
		$url = "https://graph.facebook.com/" . $page_arr[$counter] . "/feed?access_token=" . $token;
		$data = array();
		$page = $storeData -> getPage($url, "");
	
		$count = count($page["data"]);
		while($count !== 0) {
			for($count_data=0;$count_data<$count;$count_data++) {
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
			
				if($page_arr[$counter] === "477809915685496")
					$sql = "INSERT INTO beauty_info(message,obj_id,created_time) VALUES(:message,:object_id,:created_time)";
				else
					$sql = "INSERT INTO beauty_FJU(message,obj_id,created_time) VALUES(:message,:object_id,:created_time)";

				$result = $connection -> processData($conn, $sql, $data, "insert-record");
			
				switch($result) {
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
		
		$counter += 1;
	}
	
	$conn = null;
?>
