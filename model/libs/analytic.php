<?php
	require 'libs/connectDB.php';
	require 'libs/LIB_http.php';
	class analytic {
		public function __construct() {
			$this -> name = $name;
		}
		
		private function parseFile($fileName) {
			$handle = fopen($fileName, "r");
			if(!$handle) {
				return false;
			}
			else {
				$colleges = array();
				$count = 0;
				
				while (!feof($handle)) {
					$arr = explode(",", fgets($handle));
					if(isset($arr[1])) {
						if($arr[1] !== "學校名稱" && $arr[1] !== "") {
							$colleges[$count]["name"] = str_replace("台", "臺", $arr[1]);
							$colleges[$count]["name"] = str_replace("國立", "", $colleges[$count]["name"]);
							$colleges[$count]["count"] = 0;
							$count += 1;
					
						}
					}
				}
				
				return $colleges;
			}
		}
		
		private function httpGet($url) {
			$data = http_get($url, $target = "");
			$data = $data["FILE"];
			$data = json_decode($data, true);
			return $data;
		}
		
		private function processStr($colleges, $data) {
			$result = 0;
			$search = array("台", "表特大學", "文化大學", "美和大學", "臺北城市大學", "新生醫護管理學校", "美和護專",
				"元培科技大學", "醒悟科技大學", "德明", "耕莘", "華夏大學", "臺北商業技術學院", "輔英大學");
			$replace = array("臺", "", "中國文化大學", "美和科技大學", "臺北城市科技大學", "新生醫護管理專科學校",
				"美和科技大學", "元培醫事科技大學", "醒吾科技大學", "德明財經科技大學", "耕莘健康管理專科學校", "華夏科技大學",
				"國立臺北商業大學", "輔英科技大學");

			for($i=0;$i<count($data);$i++) {
				$message = trim($data[$i]["message"]);
				$message = str_replace($search, $replace, $message);
		
				if(strpos($message, "科大") !== false) {
					$message = str_replace("科大", "科技大學", $message);
				}
				if(strpos($message, "專校") !== false) {
					$message = str_replace("專校", "專科學校", $message);
				}
			
				$check = false;
				$count = 0;
				for($j=0;$j<count($colleges);$j++) {
					//ignore china university
					if(strpos($message, "中國傳媒大學") !== false)
						continue;
					if(strpos($message, $colleges[$j]["name"]) !== false) {
						$colleges[$j]["count"] += 1;
						$result += 1;
						$check = true;
						break;
					}
				}
			}
			
			return $data;
		}
		
		public function getAnalyticRes() {
			$handle = $this -> parseFile("files/u1_new.csv");
			if($handle === false) {
				return "cannot open txt file";
			}
			else {
				$data = $this -> httpGet("https://mywebservice.info/beautyUniversity/data_out/school/university");
				$colleges = $handle;
				$result = $this -> processStr($colleges, $data);
				return json_encode($result, JSON_PRETTY_PRINT);
			}
		}
	}
?>