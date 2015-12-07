<?php
	require 'LIB_http.php';
	class analytic {
		public function __construct($name) {
			$this -> name = $name;
		}
		
		private function parseFile($fileName) {
			if(!file_exists($fileName)) {
				$handle = false;
			}
			else {
				$handle = file_get_contents($fileName);
			}
			
			return $handle;
		}
		
		private function httpGet($url) {
			$data = http_get($url, $target = "");
			$data = $data["FILE"];
			$data = json_decode($data, true);
			return $data;
		}
		
		private function processStr($colleges, $data) {
			$result = 0;
			if($this -> name === "university") {
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
			

					$count = 0;
					for($j=0;$j<count($colleges);$j++) {
						//ignore china university
						if(strpos($message, "中國傳媒大學") !== false)
							continue;
						if(strpos($message, $colleges[$j]["name"]) !== false) {
							$colleges[$j]["count"] += 1;
							$result += 1;
							break;
						}
					}
				}
			}
			
			if($this -> name === "FJU") {
				for($i=0;$i<count($data);$i++) {
					$check = true;
					$message = trim($data[$i]["message"]);
					for($j=0;$j<count($colleges);$j++) {
						$tempArr = explode(",", $colleges[$j]["name"]);
						foreach($tempArr as $value) {
							if(count(explode($value, $message)) > 1) {
								$colleges[$j]["count"] += 1;
								$result += 1;
								$check = false;
								break;
							}
						}
						
						if($check === false)
							break;
					}
				}
			}
			
			$colleges = $this -> calculatePercent($colleges, $result);
			return $colleges;
		}
		
		private function calculatePercent($colleges, $sum) {
			$jsonArr = array();
			$result = 0;
			$counter = 0;
			$len = count($colleges);
			for($count=0;$count<$len;$count++) {
				if($colleges[$count]["count"] === 0) {
					continue;
				}
				else {
					$colleges[$count]["percent"] = round($colleges[$count]["count"] / $sum * 100, 1);
					$colleges[$count]["y"] = $colleges[$count]["percent"];
					
					$jsonArr[$counter]["y"] = $colleges[$count]["y"];
					$temp = explode(",", $colleges[$count]["name"]);
					if(count($temp) > 1)
						$jsonArr[$counter]["name"] = $temp[0];
					else
						$jsonArr[$counter]["name"] = $colleges[$count]["name"];
					$jsonArr[$counter]["count"] = $colleges[$count]["count"];
					$result += $colleges[$count]["y"];
					$counter += 1;
				}
			}
			
			return $jsonArr;
		}
		
		public function getAnalyticRes() {
			$fileName = "";
			$url = "";
			if($this -> name === "university") {
				$fileName = "files/u1_new.json";
				$url = "http://mywebservice.info/beautyUniversity/data_out/school/university";
			}
			
			if($this -> name === "FJU") {
				$fileName = "files/fju.json";
				$url = "http://mywebservice.info/beautyUniversity/data_out/school/FJU";
			}
			
			$handle = $this -> parseFile($fileName);
			if($handle === false) {
				return "cannot open json file";
			}
			else {
				$data = $this -> httpGet($url);
				$colleges = json_decode($handle, true);
				$result = $this -> processStr($colleges, $data);
				return json_encode($result);
			}
		}
	}
?>