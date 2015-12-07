<?php
	require_once "model/model.php";
	class myController extends FlexPress\Components\Controller\AbstractController {
		public function indexAction($request) {
			$model = new myModel();
			$sql = "";
			$result = null;
			switch($request) {
				case "school_university":
					$sql = "SELECT * FROM beauty_info
					WHERE (message LIKE '%技術學院%'
					OR message LIKE '%科技大學%'
					OR message LIKE '%科大%'
					OR message LIKE '%專科%' 
					OR message LIKE '%專校%'
					OR message LIKE '%大學%') 
					AND (message NOT LIKE '%北一女%'
					AND message NOT LIKE '%笑容以融化%'
					AND message NOT LIKE '%女中%'
					AND message NOT LIKE '%高中%'
					AND message NOT LIKE '%高職%'
					AND message NOT LIKE '%家商%'
					AND message NOT LIKE '%高商%'
					AND message NOT LIKE '%高一%'
					AND message NOT LIKE '%高二%'
					AND message NOT LIKE '%高三%'
					AND message NOT LIKE '%高工%'
					AND message NOT LIKE '%#127台灣大學歡迎大家推妹!!%'
					AND message NOT LIKE '%商職%'
					AND message NOT LIKE '%友站正妹推薦%'
					AND message NOT LIKE '%高級中學%'
					AND message NOT LIKE '%這裡有大學正妹%'
					AND message NOT LIKE '%畢業%')";
					$result = $model -> dispatchModel("getData", null, $sql);
					break;
				case "school_FJU":
					$sql = "SELECT * FROM beauty_FJU
						WHERE (message not LIKE '%男%' OR message LIKE '%女神%')
						AND LENGTH(message) <= 200 AND LENGTH(message) > 0
						AND (message NOT LIKE '%影傳四 影傳神丁 丁冠濠個性極佳 僑生之光%'
						AND message NOT LIKE '%光電三張永欣%'
						AND message NOT LIKE '%感謝熱心的同學提供小編%'
						AND message NOT LIKE '%曹佑寧%'
						AND message NOT LIKE '%余文樂%'
						AND message NOT LIKE '%帥%')";
					$result = $model -> dispatchModel("getData", null, $sql);
					break;
				case "colleges_university":
					$result = $model -> dispatchModel("analytic", "university", null);
					break;
				case "colleges_FJU":
					$result = $model -> dispatchModel("analytic", "FJU", null);
					break;
				default:
					$result = "invalid request string";
			}
			
			return $result;
		}
	}
?>
