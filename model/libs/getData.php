<?php
	require 'libs/connectDB.php';
	require 'libs/LIB_http.php';
	class getData {
		
		public function __construct() {
			$this -> name = $name;
			$this -> tableName = $tableName;
			$this -> sql = $sql;
		}
		
		public function getJSON() {
			$connection = new connectDB();
			$conn = $connection -> initialDB();
			$result = $connection -> processData($conn, $sql, $data = "", "get-data");
			$connection -> connectClose();
			return $result;
		}
	}
?>