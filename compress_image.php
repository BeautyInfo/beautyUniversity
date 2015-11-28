<?php
	require 'libs/LIB_http.php';
	require 'libs/LIB_download_images.php';
	header("Content-Type: image/jpeg");
	ob_start("ob_gzhandler");
	$obj_id = filter_input(INPUT_GET, "obj_id");
	$obj_id = htmlentities($obj_id);
	$picture_type = filter_input(INPUT_GET, "picture_type");
	$picture_type = htmlentities($picture_type);

	$page = http_get("graph.facebook.com/" + $obj_id + "/picture?type=" + $picture_type);
	$page = $page["FILE"];
	echo $page;
?>