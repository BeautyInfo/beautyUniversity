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
			if(mb_strpos($message, "科技大學"))
			{
				//echo($message) . "<br>";
				$result += 1;
				//$colleges = matchCollegeName($message, $colleges);
			}
			else if(mb_strpos($message, "大學") === true)
			{
				//echo($message) . "<br>";
				$result += 1;
				//$colleges = matchCollegeName($message, $colleges);
			}
			else if(mb_strpos($message, "科大") === true)
			{
				//echo($message) . "<br>";
				$result += 1;
				//$colleges = matchCollegeName($message, $colleges);
			}
			else if(mb_strpos($message, "技術學院") === true)
			{
				//echo($message) . "<br>";
				$result += 1;
				//$colleges = matchCollegeName($message, $colleges);
				
			}
			else if(mb_strpos($message, "專科學校") === true)
			{
				//echo($message) . "<br>";
				$result += 1;
				//$colleges = matchCollegeName($message, $colleges);
				
			}
			else if(mb_strpos($message, "專校") === true)
			{
				//echo($message) . "<br>";
				$result += 1;
				//$colleges = matchCollegeName($message, $colleges);

			}
			else
			{
				echo $message . "<br>";
				$result += 1;
			}
		}

		echo($result);
		//echo json_encode($colleges, JSON_PRETTY_PRINT);
	}

	function matchCollegeName($msg, $colleges)
	{
		for($j=2;$j<count($colleges);$j++)
		{
			if(mb_strpos($msg, $colleges[$j]["name"]) !== false)
			{
				$colleges[$j]["count"] += 1;
				break;
			}
		}

		return $colleges;
	}
?>