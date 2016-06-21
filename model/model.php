<?php
	require "libs/getData.php";
	require "libs/analytic.php";
	class myModel {
		public function dispatchModel($request, $name, $sql) {
			$result = null;
			switch($request) {
				case "getData":
					$data = new getData();
					$result = $data -> getJSON($sql);
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
