<?php
if (!defined('SOURCES')) die("Error");

switch ($act) {
    case "man_photo":
        viewPhotos();
        $template = "gallery/man/photos";
        break;
    case "add_photo":
        $template = "gallery/man/photo_add";
        break;
    case "edit_photo":
        editPhoto();
        $template = "gallery/man/photo_edit";
        break;
    case "save_photo":
        savePhoto();
        break;
    case "delete_photo":
        deletePhoto();
        break;
    default:
        $template = "404";
}

/* View photo */
function viewPhotos()
{
    global $d, $func, $curPage, $items, $paging, $type, $kind, $val, $id_parent, $com;

    $where = "id_parent = ? and com = ? and type = ? and kind = ? and val = ?";

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_gallery where $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($id_parent, $com, $type, $kind, $val));
    $sqlNum = "select count(*) as 'num' from #_gallery where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($id_parent, $com, $type, $kind, $val));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit photo */
function editPhoto()
{
    global $d, $func, $curPage, $item, $type, $kind, $val, $id_parent, $com;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from #_gallery where id_parent = ? and com = ? and type = ? and kind = ? and val = ? and id = ? order by numb,id desc limit 0,1", array($id_parent, $com, $type, $kind, $val, $id));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage, false);
        }
    }
}

/* Save photo */
function savePhoto()
{
    global $d, $curPage, $func, $config, $dfgallery, $type, $kind, $val, $id_parent, $com;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage, false);
    }

    /* Post dữ liệu */
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    $dataMultiTemp = (!empty($_POST['dataMulti'])) ? $_POST['dataMulti'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Save data */
    if ($id) {
        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('com', $com);
        $d->where('type', $type);
        $d->where('kind', $kind);
        $d->where('val', $val);
        if ($d->update('gallery', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config[$com][$type][$dfgallery][$val]['img_type_photo'], "../upload/" . $com . "/", $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_gallery where id_parent = ? and com = ? and type = ? and kind = ? and val = ? and id = ? order by numb,id desc limit 0,1", array($id_parent, $com, $type, $kind, $val, $id));

                    if (!empty($row)) {
                        $func->deleteFile("../upload/" . $com . "/" . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('gallery', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* File attach */
            if ($func->hasFile("file_attach")) {
                $fileUpdate = array();
                $file_name = $func->uploadName($_FILES["file_attach"]["name"]);

                if ($file_attach = $func->uploadImage("file_attach", $config[$com][$type][$dfgallery][$val]['file_type_photo'], UPLOAD_FILE, $file_name . "-attach")) {
                    $row = $d->rawQueryOne("select id, file_attach from #_gallery where id_parent = ? and com = ? and type = ? and kind = ? and val = ? and id = ? order by numb,id desc limit 0,1", array($id_parent, $com, $type, $kind, $val, $id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
                    }

                    $fileUpdate['file_attach'] = $file_attach;
                    $d->where('id', $id);
                    $d->update('gallery', $fileUpdate);
                    unset($fileUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage, false);
        }
    } else {
        $numberPhoto = (isset($config[$com][$type][$dfgallery][$val]['number_photo'])) ? $config[$com][$type][$dfgallery][$val]['number_photo'] : 0;

        if ($numberPhoto && $dataMultiTemp) {
            $success = 0;

            for ($i = 0; $i < count($dataMultiTemp); $i++) {
                $success_file = 0;
                $success_photo = 0;
                $success_video = 0;
                $dataMulti = $dataMultiTemp[$i];
                $dataMulti['id_color'] = (isset($data['id_color'])) ? $data['id_color'] : 0;
                if (!empty($dataMulti['status'])) {
                    $dataStatus = implode(",", $dataMulti['status']);
                    $dataMulti['status'] = (!empty($dataStatus)) ? rtrim($dataStatus, ",") : "";
                } else {
                    $dataMulti['status'] = "";
                }
                $dataMulti['com'] = $com;
                $dataMulti['type'] = $type;
                $dataMulti['kind'] = $kind;
                $dataMulti['val'] = $val;
                $dataMulti['date_created'] = time();
                $dataMulti['id_parent'] = $id_parent;

                if (isset($config[$com][$type][$dfgallery][$val]['file_photo']) && $config[$com][$type][$dfgallery][$val]['file_photo'] == true) {
                    if ($func->hasFile("file_attach" . $i)) {
                        $success_file = 1;
                    }
                }

                if (isset($config[$com][$type][$dfgallery][$val]['images_photo']) && $config[$com][$type][$dfgallery][$val]['images_photo'] == true) {
                    if ($func->hasFile("file" . $i)) {
                        $success_photo = 1;
                    }
                }

                if (isset($config[$com][$type][$dfgallery][$val]['video_photo']) && $config[$com][$type][$dfgallery][$val]['video_photo'] == true) {
                    if (!empty($dataMulti['link_video'])) {
                        $success_video = 1;
                    }
                }

                if ($success_file || $success_photo || $success_video) {
                    if ($d->insert('gallery', $dataMulti)) {
                        $id_insert = $d->getLastInsertId();

                        /* File attach */
                        if (isset($config[$com][$type][$dfgallery][$val]['file_photo']) && $config[$com][$type][$dfgallery][$val]['file_photo'] == true) {
                            if ($func->hasFile("file_attach" . $i)) {
                                $fileUpdate = array();
                                $file_name = $func->uploadName($_FILES["file_attach" . $i]["name"]);

                                if ($file_attach = $func->uploadImage("file_attach" . $i, $config[$com][$type][$dfgallery][$val]['file_type_photo'], UPLOAD_FILE, $file_name . "-attach" . $i)) {
                                    $fileUpdate['file_attach'] = $file_attach;
                                    $d->where('id', $id_insert);
                                    $d->update('gallery', $fileUpdate);
                                    unset($fileUpdate);
                                }
                            }
                        }

                        /* Photo */
                        if (isset($config[$com][$type][$dfgallery][$val]['images_photo']) && $config[$com][$type][$dfgallery][$val]['images_photo'] == true) {
                            if ($func->hasFile("file" . $i)) {
                                $photoUpdate = array();
                                $file_name = $func->uploadName($_FILES["file" . $i]["name"]);

                                if ($photo = $func->uploadImage("file" . $i, $config[$com][$type][$dfgallery][$val]['img_type_photo'], "../upload/" . $com . "/", $file_name . $i)) {
                                    $photoUpdate['photo'] = $photo;
                                    $d->where('id', $id_insert);
                                    $d->update('gallery', $photoUpdate);
                                    unset($photoUpdate);
                                }
                            }
                        }

                        $success = 1;
                    } else {
                        $func->transfer("Lưu dữ liệu thất bại", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage, false);
                    }
                }
            }

            if ($success) {
                $func->transfer("Lưu dữ liệu thành công.", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage);
            } else {
                $func->transfer("Lưu dữ liệu thất bại", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage, false);
            }
        } else {
            $func->transfer("Dữ liệu rỗng", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage, false);
        }
    }
}

/* Delete photo */
function deletePhoto()
{
    global $d, $curPage, $func, $type, $kind, $val, $id_parent, $com;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id, photo, file_attach from #_gallery where id = ? and com = ? and type = ? and kind = ? and val = ? limit 0,1", array($id, $com, $type, $kind, $val));

        if (!empty($row)) {
            $func->deleteFile("../upload/" . $com . "/" . $row['photo']);
            $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
            $d->rawQuery("delete from #_gallery where id = ?", array($id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "Dữ liệu không có thực", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id, photo, file_attach from #_gallery where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                $func->deleteFile("../upload/" . $com . "/" . $row['photo']);
                $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
                $d->rawQuery("delete from #_gallery where id = ? and com = ? and type = ? and kind = ? and val = ?", array($id, $com, $type, $kind, $val));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val . "&p=" . $curPage, false);
    }
}
