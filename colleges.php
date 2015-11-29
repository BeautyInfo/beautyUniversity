<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=utf-8");
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
			$colleges[$count]["name"] = $arr[1];
			$colleges[$count]["count"] = 0;
			$count += 1;
		}

		$data = http_get("https://mywebservice.info/beautyUniversity/data_out.php?school=university", $target = "");
		$data = $data["FILE"];
		for($i=0;$i<count($data);$i++)
		{
			$message = str_replace("台", "臺", $data[$i]["message"]);
			$message = str_replace("表特大學", "", $message);
			for($j=3$j<count($colleges);$j++)
			{
				$value = str_replace("國立", "", $colleges[$j]["name"]);
				if(mb_stristr($message, "科技大學") === true)
				{
					if(mb_strrpos($message, $value) === true)
						$colleges[$j]["count"] += 1;
				}
				else if(mb_stristr($message, "大學") === true)
				{
					if(mb_strrpos($message, $value) === true)
						$colleges[$j]["count"] += 1;
				}
				else if(mb_stristr($message, "科大") === true)
				{
					if(mb_strrpos($message,$value) === true)
						$colleges[$j]["count"] += 1;
				}
				else if(mb_stristr($message, "技術學院") === true)
				{
					if(mb_strrpos($message,$value) === true)
						$colleges[$j]["count"] += 1;
				}
				else if(mb_stristr($message, "專科學校") === true)
				{
					if(mb_strrpos($message, $value) === true)
						$colleges[$j]["count"] += 1;
				}
				else if(mb_stristr($message, "專校") === true)
				{
					if(mb_strrpos($message, $value) === true)
						$colleges[$j]["count"] += 1;

				}
			}
		}

		echo json_encode($colleges);
	}
?>