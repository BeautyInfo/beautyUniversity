<?php
	require "libs/getData.php";
	require "libs/analytic.php";
	class myModel {
		public function dispatchModel($request, $tableName, $sql) {
			$result = null;
			switch($request) {
				case "getData":
					$data = new getData($name, $tableName, $sql);
					$result = $data -> getJSON();
					break;
				case "analytic":
					$data = new analytic($name);
					$result = $data -> getAnalyticRes();
					break;
			}
			
			return $result;
		}
	}
?>