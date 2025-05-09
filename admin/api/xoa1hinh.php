<?php
	include "config.php";
	$table = $_POST['table'];
	$id = $_POST['id'];
	$cot = $_POST['cot'];
	$type = $_POST['type'];
	
	if ($table == 'static') {
		$col = 'photo, photo2, photo3, photo4';
	} elseif($table == 'news') {
		$col = 'photo, videomp4';
	} else {
		$col = 'photo';
	}

	$row = $d->rawQueryOne("select id, ".$col." from #_".$table." where id = ? and type = ? limit 0,1",array($id,$type));


	if($table == 'static' or $table == 'news') {
		$func->deleteFile('../'.UPLOAD_NEWS.$row[$cot]);
	}
	elseif($table == 'photo') {
		$func->deleteFile('../'.UPLOAD_PHOTO.$row[$cot]);
	}
	else {
		$func->deleteFile('../'.UPLOAD_PRODUCT.$row[$cot]);
	}
	
	if (!empty($row[$cot])) {
		$func->deleteFile('../'.UPLOAD_VIDEO . $row[$cot]);
	}
	$data[$cot] = '';
	$d->where('id', $id);
	$d->update($table,$data);
?>