<?php
	require 'connectDB.php';
	class getData {
		public function getJSON($sql) {
			$connection = new connectDB();
			$conn = $connection -> initialDB();
			if($conn === null) {
				echo "cannot link db.";
			}
			else {
				$result = array();
				$queryResult = $conn -> query($sql);
				$count = 0;
				while($contentRes = $queryResult -> fetch()) {
					if($contentRes["message"] !== null)
						$result[$count]["message"] = $contentRes["message"];
					else
						$result[$count]["message"] = "";
					if($contentRes["obj_id"] !== null)
						$result[$count]["object_id"] = $contentRes["obj_id"];
					else
						$result[$count]["object_id"] = "";
					$result[$count]["created_time"] = $contentRes["created_time"];
					$count += 1;
				}

				$result = json_encode($result);
				$conn = null;
			}
			return $result;
		}
	}
?>
