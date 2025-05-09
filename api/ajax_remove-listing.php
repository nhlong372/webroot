<?php
	include "config.php";
	$id = (isset($_POST["id"])) ? htmlspecialchars($_POST["id"]) : 0;
	if(isset($_SESSION['list_saved'])) {
		$arr = json_decode($_SESSION['list_saved'], true);
		foreach ($arr as $key => $value) {
			if($value['id'] == $id) {
				unset($arr[$key]);
			}
		}
		$arr = array_values($arr);
		$_SESSION['list_saved'] = json_encode($arr);
	}
	echo count(json_decode($_SESSION['list_saved'], true));
?>