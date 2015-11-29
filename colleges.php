<?php
	header("Access-Control-Allow-Origin: *");
	//header("Content-Type: application/json; charset=utf-8");
	header("Content-Type: text/html; charset=utf-8");
	ob_start("ob_gzhandler");
	require 'libs/LIB_http.php';
	$handle = fopen("u1_new.csv", "r");
	if(!$handle)
	{
		echo "cannot open txt file";
	}
	else
	{
		$check_line = 0;
		$count = 0;
		$colleges = array();
		
		while (!feof($handle))
		{
			$arr = explode(",", fgets($handle));
			if(isset($arr[1]))
			{
				$colleges[$count]["name"] = $arr[1];
				$colleges[$count]["count"] = 0;
				$count += 1;
			}
		}

		$data = http_get("https://mywebservice.info/beautyUniversity/data_out.php?school=university", $target = "");
		$data = $data["FILE"];
		$data = json_decode($data, true);
		$result = 0;
		for($i=0;$i<count($data);$i++)
		{
			$message = trim($data[$i]["message"]);
			$message = str_replace("台", "臺", $message);
			$message = str_replace("表特大學", "", $message);
			//echo $message . "<br>";
			if(strpos($message, "科大") !== false)
			{
				$message = str_replace("科大", "科技大學", $message);
			}
			else if(strpos($message, "專校") !== false)
			{
				$message = str_replace("專校", "專科學校", $message);
			}
			else
			{
				//$result += 1;
			}
			
			for($j=2;$j<count($colleges);$j++)
			{
				$colleges[$j]["name"] = str_replace("國立", "", $colleges[$j]["name"]);
				if(strpos($message, $colleges[$j]["name"]) !== false)
				{
					$colleges[$j]["count"] += 1;
					$result += 1;
					break;
				}
			}
		}
		
		echo $result . "<br>";
		echo json_encode($colleges, JSON_PRETTY_PRINT);
	}
?>