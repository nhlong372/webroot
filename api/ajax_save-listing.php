<?php
	include "config.php";
	$id = (isset($_POST["id"])) ? htmlspecialchars($_POST["id"]) : 0;
	if($id > 0) {
		if(!isset($_SESSION['list_saved']) and $_SESSION['list_saved'] == null) {
			$arr = array();
			$arr_insert = array('id' => $id, 'time' => time());
			array_push( $arr, $arr_insert );
			$_SESSION['list_saved'] = json_encode($arr);
		}
		else {
			$arr = json_decode($_SESSION['list_saved'], true);
			$arr_check = array_column($arr, 'id');
			if(!in_array($id, $arr_check)) {
				$arr_insert = array('id' => $id, 'time' => time());
				array_push($arr, $arr_insert);
				$_SESSION['list_saved'] = json_encode($arr);
			}
		}
		echo count(json_decode($_SESSION['list_saved'], true));
	}
?>