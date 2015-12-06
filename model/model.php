<?php
	require "libs/getData.php";
	require "libs/analytic.php";
	class myModel {
		public function dispatchModel($request, $tableName = null, $sql = null) {
			$result = null;
			switch($request) {
				case "getData":
					$data = new getData();
					$result = $data -> getJSON($sql);
					break;
				case "analytic":
					$data = new analytic($name);
					$result = $data -> getAnalyticRes($name);
					break;
			}
			
			return $result;
		}
	}
?>