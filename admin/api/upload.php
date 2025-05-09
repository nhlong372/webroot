<?php
include "config.php";
require_once LIBRARIES . "config-type.php";

/* Xử lý params */
$flag = true;
$param = (!empty($_POST['params'])) ? $_POST['params'] : null;
$params = null;
if ($param) parse_str(base64_decode(addslashes($param)), $params);
$id = (!empty($params['id'])) ? $params['id'] : 0;
$com = (!empty($params['com'])) ? $params['com'] : '';
$type = (!empty($params['type'])) ? $params['type'] : '';
$hash = (!empty($_POST['hash'])) ? addslashes($_POST['hash']) : '';
$numb = (!empty($_POST['numb'])) ? (int)$_POST['numb'] : 0;
$e = (!empty($params['act'])) ? @explode("_", $params['act']) : null;
if ($e) $ex = (count($e) > 1) ? end($e) : '';
else $ex = '';
$kind = "man" . (($ex) ? ("_" . $ex) : '');
$data = array('success' => true, 'msg' => 'Upload thành công');

/* Xử lý $_FILE - Path image */
$myFile = (!empty($_FILES['files'])) ? $_FILES['files'] : null;
$_FILES['file'] = array('name' => $myFile['name'][0], 'type' => $myFile['type'][0], 'tmp_name' => $myFile['tmp_name'][0], 'error' => $myFile['error'][0], 'size' => $myFile['size'][0]);
$file_name = $func->uploadName($_FILES['file']['name']);
$upload_path = array("product" => UPLOAD_PRODUCT, "news" => UPLOAD_NEWS);

/* Xử lý lưu image */
if (!empty($config[$com][$type]['img_type'])) {
    $data_file = array();

    if (empty($id)) {
        $data_file['hash'] = $hash;
    }

    $data_file['numb'] = 0;
    $data_file['namevi'] = "";
    $data_file['id_parent'] = $id;
    $data_file['com'] = $com;
    $data_file['type'] = $type;
    $data_file['kind'] = $kind;
    $data_file['val'] = $type;
    $data_file['status'] = 'hienthi';
    $data_file['date_created'] = time();
    $max_numb = $d->rawQueryOne("select max(numb) as max_numb from #_gallery where com = ? and  type = ? and kind = ? and val = ? and id_parent = ?", array($com, $type, $kind, $type, $id));
    $data_file['numb'] = $max_numb['max_numb'] + 1;

    if ($d->insert('gallery', $data_file)) {
        $id_insert = $d->getLastInsertId();

        if ($func->hasFile("file")) {
            $photoUpdate = array();

            if ($photo = $func->uploadImage("file", $config[$com][$type]['img_type'], '../' . $upload_path[$com], $file_name)) {
                $photoUpdate['photo'] = $photo;
                $d->where('id', $id_insert);
                $d->update('gallery', $photoUpdate);
                unset($photoUpdate);
            }
        }
    } else {
        $flag = false;
    }
} else {
    $flag = false;
}

if (!$flag) {
    $data = array('success' => false, 'msg' => 'Upload thất bại');
}

echo json_encode($data);
