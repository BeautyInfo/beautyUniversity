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
		$count = 0;
		$colleges = array();
		
		while (!feof($handle))
		{
			$arr = explode(",", fgets($handle));
			if(isset($arr[1]))
			{
				if($arr[1] !== "學校名稱" && $arr[1] !== "")
				{
					$colleges[$count]["name"] = str_replace("台", "臺", $arr[1]);
					$colleges[$count]["name"] = str_replace("國立", "", $colleges[$count]["name"]);
					$colleges[$count]["count"] = 0;
					$count += 1;
					
				}
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
			$message = str_replace("文化大學", "中國文化大學", $message);
			$message = str_replace("美和大學", "美和科技大學", $message);
			$message = str_replace("臺北城市大學", "臺北城市科技大學", $message);
			$message = str_replace("新生醫護管理學校", "新生醫護管理專科學校", $message);
			$message = str_replace("美和護專", "美和科技大學", $message);
			$message = str_replace("元培科技大學", "元培醫事科技大學", $message);
			$message = str_replace("醒悟科技大學", "醒吾科技大學", $message);
			$message = str_replace("德明科技大學", "德明財經科技大學", $message);
			$message = str_replace("華夏大學", "華夏科技大學", $message);
			$message = str_replace("臺北商業技術學院", "國立臺北商業大學", $message);
			$message = str_replace("輔英大學", "輔英科技大學", $message);
			$message = str_replace("耕莘專科學校", "耕莘健康管理專科學校", $message);
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
			
			$check = false;
			$count = 0;
			for($j=0;$j<count($colleges);$j++)
			{
				if(strpos($message, $colleges[$j]["name"]) !== false)
				{
					$colleges[$j]["count"] += 1;
					$result += 1;
					$check = true;
					break;
				}
			}
			
			if(!$check)
			{
				echo $message . "<br>";
				$count += 1;
			}
		}
		
		//echo $result . "<br>";
		//echo json_encode($colleges, JSON_PRETTY_PRINT);
	}
?>