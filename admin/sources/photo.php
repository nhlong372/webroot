<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active photo */
if (isset($config['photo'])) {
    $arrCheck = array();
    $actCheck = '';
    if ($act == 'photo_static' || $act == 'save_static' || $act == 'save-watermark' || $act == 'preview-watermark') $actCheck = 'photo_static';
    else $actCheck = 'man_photo';
    foreach ($config['photo'][$actCheck] as $k => $v) $arrCheck[] = $k;
    if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
} else {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

switch ($act) {
        /* Photo static */
    case "photo_static":
        viewPhotoStatic();
        $template = "photo/static/photo_static";
        break;
    case "save_static":
        savePhotoStatic();
        break;

        /* Watermark */
    case "save-watermark":
        saveWatermark();
        break;
    case "preview-watermark":
        previewWatermark();
        break;

        /* Photos */
    case "man_photo":
        viewPhotos();
        $template = "photo/man/photos";
        break;
    case "add_photo":
        $template = "photo/man/photo_add";
        break;
    case "edit_photo":
        editPhoto();
        $template = "photo/man/photo_edit";
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

/* Save watermark */
function saveWatermark()
{
    global $d, $func, $config, $type;

    if (isset($_POST['data'])) {
        parse_str(urldecode($_POST['data']), $data);
        $upload = false;
        if (isset($_FILES['file'])) {
            $file_name = $func->uploadName($_FILES['file']["name"]);
            $photo = $func->uploadImage("file", $config['photo']['photo_static'][$type]['img_type'], UPLOAD_TEMP, "tmp");
            $upload = true;
            $path = UPLOAD_TEMP . $photo;
        } else {
            $item = $d->rawQueryOne("select * from #_photo where act = ? and type = ? limit 0,1", array('photo_static', $type));
            $path = UPLOAD_PHOTO . $item['photo'];
        }
    }

    echo json_encode(
        array(
            "path" => $path,
            "upload" => $upload,
            "data" => $data['data']['options']['watermark'],
            "position" => $data['data']['options']['watermark']['position'],
            "image" => "../assets/images/preview-watermark.jpg"
        )
    );

    exit;
}

/* Preview watermark */
function previewWatermark()
{
    global $func;
    $func->createThumb(500, 0, 1, $_GET['img'], null, "preview", true, $_GET);
}

/* View photo static */
function viewPhotoStatic()
{
    global $d, $item, $type;

    $item = $d->rawQueryOne("select * from #_photo where act = ? and type = ? limit 0,1", array('photo_static', $type));
}

/* Save photo static */
function savePhotoStatic()
{
    global $d, $func, $flash, $config, $type;

    /* Post dữ liệu */
    $row = $d->rawQueryOne("select id, options from #_photo where act = ? and type = ? limit 0,1", array('photo_static', $type));
    $message = '';
    $response = array();
    $id = (!empty($row['id']) && $row['id'] > 0) ? $row['id'] : 0;
    $option = (!empty($row['options']) && $row['options'] != '') ? json_decode($row['options'], true) : null;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            if (is_array($value)) {
                foreach ($value as $k2 => $v2) $option[$k2] = $func->sanitize($v2);
                $data[$column] = json_encode($option);
            } else {
                if (strpos($column, 'content') !== false || strpos($column, 'desc') !== false) {
                    $data[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
                } else {
                    $data[$column] = htmlspecialchars($func->sanitize($value));
                }
            }
        }
    }

    if (isset($_POST['status'])) {
        $status = '';
        foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
        $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
    } else {
        $data['status'] = "";
    }

    $data['type'] = $type;
    $data['act'] = 'photo_static';

    /* Valid data watermark */
    if (!empty($config['photo']['photo_static'][$type]['watermark-advanced'])) {
        if (empty($option['watermark']['position'])) {
            $response['messages'][] = 'Chưa chọn vị trí đóng dấu';
        }

        if (empty($option['watermark']['per'])) {
            $response['messages'][] = 'Tỉ lệ > 300 không được trống';
        }

        if (!empty($option['watermark']['per']) && !$func->isNumber($option['watermark']['per'])) {
            $response['messages'][] = 'Tỉ lệ > 300 không hợp lệ';
        }

        if (empty($option['watermark']['small_per'])) {
            $response['messages'][] = 'Tỉ lệ < 300 không được trống';
        }

        if (!empty($option['watermark']['small_per']) && !$func->isNumber($option['watermark']['small_per'])) {
            $response['messages'][] = 'Tỉ lệ < 300 không hợp lệ';
        }

        if (empty($option['watermark']['max'])) {
            $response['messages'][] = 'Kích thước tối đa không được trống';
        }

        if (!empty($option['watermark']['max']) && !$func->isNumber($option['watermark']['max'])) {
            $response['messages'][] = 'Kích thước tối đa không hợp lệ';
        }

        if (empty($option['watermark']['min'])) {
            $response['messages'][] = 'Kích thước tối thiểu không được trống';
        }

        if (!empty($option['watermark']['min']) && !$func->isNumber($option['watermark']['min'])) {
            $response['messages'][] = 'Kích thước tối thiểu không hợp lệ';
        }
    }

    /* Valid data link */
    if (!empty($config['photo']['photo_static'][$type]['link'])) {
        if (!empty($data['link']) && !$func->isUrl($data['link'])) {
            $response['messages'][] = 'Đường dẫn không hợp lệ';
        }
    }

    /* Valid data video */
    if (!empty($config['photo']['photo_static'][$type]['video'])) {
        if (empty($data['link_video'])) {
            $response['messages'][] = 'Đường dẫn video không được trống';
        }

        if (!empty($data['link_video']) && !$func->isYoutube($data['link_video'])) {
            $response['messages'][] = 'Đường dẫn video không hợp lệ';
        }
    }

    if (!empty($response)) {
        /* Flash data watermark */
        if (!empty($option['watermark'])) {
            foreach ($option['watermark'] as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);
        $func->redirect("index.php?com=photo&act=photo_static&type=" . $type);
    }

    /* Xóa cache watermark */
    if (!empty($config['photo']['photo_static'][$type]['watermark'])) {
        $func->removeDir(WATERMARK);
        $func->RemoveFilesFromDirInXSeconds(UPLOAD_TEMP, 1);
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('photo', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['photo']['photo_static'][$type]['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_photo where id = ? and act = ? and type = ? limit 0,1", array($id, 'photo_static', $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('photo', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=photo&act=photo_static&type=" . $type);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=photo&act=photo_static&type=" . $type, false);
        }
    } else {
        $data['date_created'] = time();

        if ((!empty($config['photo']['photo_static'][$type]['nhac']) && $func->hasFile("file")) ||(!empty($config['photo']['photo_static'][$type]['videomp4']) && $func->hasFile("file")) ||(!empty($config['photo']['photo_static'][$type]['images']) && $func->hasFile("file")) || (isset($data['link_video']) && $data['link_video'] != '')) {
            if ($d->insert('photo', $data)) {
                $id_insert = $d->getLastInsertId();

                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    $file_name = $func->uploadName($_FILES['file']["name"]);

                    if ($photo = $func->uploadImage("file", $config['photo']['photo_static'][$type]['img_type'], UPLOAD_PHOTO, $file_name)) {
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id_insert);
                        $d->update('photo', $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                $func->transfer("Lưu dữ liệu thành công", "index.php?com=photo&act=photo_static&type=" . $type);
            } else {
                $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=photo&act=photo_static&type=" . $type, false);
            }
        } else {
            $func->transfer("Dữ liệu rỗng", "index.php?com=photo&act=photo_static&type=" . $type, false);
        }
    }
}

/* View photo */
function viewPhotos()
{
    global $d, $func, $curPage, $items, $paging, $type;

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_photo where type = ? and act <> ? order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type, 'photo_static'));
    $sqlNum = "select count(*) as 'num' from #_photo where type = ? and act <> ? order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type, 'photo_static'));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=photo&act=man_photo&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit photo */
function editPhoto()
{
    global $d, $func, $curPage, $item, $list_cat, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from #_photo where id = ? and act <> ? and type = ? limit 0,1", array($id, 'photo_static', $type));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
        }
    }
}

/* Save photo */
function savePhoto()
{
    global $d, $func, $flash, $curPage, $config, $type;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    $dataMultiTemp = (!empty($_POST['dataMulti'])) ? $_POST['dataMulti'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            if (strpos($column, 'content') !== false || strpos($column, 'desc') !== false) {
                $data[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
            } else {
                $data[$column] = htmlspecialchars($func->sanitize($value));
            }
        }
    }

    /* Save data */
    if ($id) {
        /* Valid data link */
        if (!empty($config['photo']['man_photo'][$type]['link_photo'])) {
            if (!empty($data['link']) && !$func->isUrl($data['link'])) {
                $response['messages'][] = 'Đường dẫn không hợp lệ';
            }
        }

        /* Valid data video */
        if (!empty($config['photo']['man_photo'][$type]['video_photo'])) {
            if (empty($data['link_video'])) {
                $response['messages'][] = 'Đường dẫn video không được trống';
            }

            if (!empty($data['link_video']) && !$func->isYoutube($data['link_video'])) {
                $response['messages'][] = 'Đường dẫn video không hợp lệ';
            }
        }

        if (!empty($response)) {
            /* Flash data */
            if (!empty($data)) {
                foreach ($data as $k => $v) {
                    if (!empty($v)) {
                        $flash->set($k, $v);
                    }
                }
            }

            /* Errors */
            $response['status'] = 'danger';
            $message = base64_encode(json_encode($response));
            $flash->set('message', $message);
            $func->redirect("index.php?com=photo&act=edit_photo&type=" . $type . "&id=" . $id);
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['date_updated'] = time();
        $data['act'] = 'photo_multi';

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('photo', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['photo']['man_photo'][$type]['img_type_photo'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_photo where id = ? and type = ? limit 0,1", array($id, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('photo', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* file attach */
            if ($func->hasFile("file_attach")) {
                $fileUpdate = array();
                $file_name3 = $func->uploadName($_FILES["file_attach"]["name"]);

                if ($file_attach = $func->uploadImage("file_attach", $config['photo']['man_photo'][$type]['file_type_photo'], UPLOAD_FILE, $file_name3)) {
                    $row = $d->rawQueryOne("select id, file_attach from #_photo where id = ? and type = ? limit 0,1", array($id, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
                    }

                    $fileUpdate['file_attach'] = $file_attach;
                    $d->where('id', $id);
                    $d->update('photo', $fileUpdate);
                    unset($fileUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
        }
    } else {
        $numberPhoto = (isset($config['photo']['man_photo'][$type]['number_photo'])) ? $config['photo']['man_photo'][$type]['number_photo'] : 0;

        if ($numberPhoto && $dataMultiTemp) {
            $success = false;

            for ($i = 0; $i < count($dataMultiTemp); $i++) {
                $success_photo = false;
                $success_video = false;
                $dataMulti = $dataMultiTemp[$i];
                if (!empty($dataMulti['status'])) {
                    $dataStatus = implode(",", $dataMulti['status']);
                    $dataMulti['status'] = (!empty($dataStatus)) ? rtrim($dataStatus, ",") : "";
                } else {
                    $dataMulti['status'] = "";
                }
                $dataMulti['date_created'] = time();
                $dataMulti['type'] = $type;
                $dataMulti['act'] = 'photo_multi';

                if (isset($config['photo']['man_photo'][$type]['images_photo']) && $config['photo']['man_photo'][$type]['images_photo'] == true) {
                    if ($func->hasFile("file" . $i)) {
                        $success_photo = true;
                    }
                }

                if (isset($config['photo']['man_photo'][$type]['notphoto']) && $config['photo']['man_photo'][$type]['notphoto'] == true) {
                    $success_photo = true;
                }

                /* Valid data video */
                if (isset($config['photo']['man_photo'][$type]['video_photo']) && $config['photo']['man_photo'][$type]['video_photo'] == true) {
                    if (!empty($dataMulti['link_video'])) {
                        $success_video = true;
                    }

                    if (!empty($dataMulti['link_video']) && !$func->isYoutube($dataMulti['link_video'])) {
                        $response['messages'][] = 'Đường dẫn video không hợp lệ';
                    }

                    // if (!empty($dataMulti['link_video']) && !$func->isYoutubeShorts($dataMulti['link_video'])) {
                    //     $response['messages'][] = 'Đường dẫn video không hợp lệ';
                    // }
                }

                /* Valid data link */
                if (!empty($config['photo']['man_photo'][$type]['link_photo'])) {
                    if (!empty($dataMulti['link']) && !$func->isUrl($dataMulti['link'])) {
                        $response['messages'][] = 'Đường dẫn không hợp lệ';
                    }
                }

                if (!empty($response)) {
                    /* Flash data */
                    if (!empty($dataMulti)) {
                        foreach ($dataMulti as $k => $v) {
                            if (!empty($v)) {
                                $flash->set($k . $i, $v);
                            }
                        }
                    }
                }

                if (($success_photo || $success_video) && empty($response)) {

                    if (isset($config['photo']['man_photo'][$type]['notphoto']) && $config['photo']['man_photo'][$type]['notphoto'] == true) {

                        if ($dataMulti['namevi']!='') {

                            $d->insert('photo', $dataMulti);                       
                            
                            $success = true;
                        } 

                    }else{


                        if ($d->insert('photo', $dataMulti)) {
                            $id_insert = $d->getLastInsertId();

                            /* Photo */
                            if (isset($config['photo']['man_photo'][$type]['images_photo']) && $config['photo']['man_photo'][$type]['images_photo'] == true) {
                                if ($func->hasFile("file" . $i)) {
                                    $photoUpdate = array();
                                    $file_name = $func->uploadName($_FILES["file" . $i]["name"]);

                                    if ($photo = $func->uploadImage("file" . $i, $config['photo']['man_photo'][$type]['img_type_photo'], UPLOAD_PHOTO, $file_name . $i)) {
                                        $photoUpdate['photo'] = $photo;
                                        $d->where('id', $id_insert);
                                        $d->update('photo', $photoUpdate);
                                        unset($photoUpdate);
                                    }
                                }
                            }

                            /* file attach */
                            if ($func->hasFile("file_attach")) {
                                $fileUpdate = array();
                                $file_name3 = $func->uploadName($_FILES["file_attach"]["name"]);

                                if ($file_attach = $func->uploadImage("file_attach", $config['photo']['man_photo'][$type]['file_type_photo'], UPLOAD_FILE, $file_name3)) {
                                    $row = $d->rawQueryOne("select id, file_attach from #_photo where id = ? and type = ? limit 0,1", array($id, $type));

                                    if (!empty($row)) {
                                        $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
                                    }

                                    $fileUpdate['file_attach'] = $file_attach;
                                    $d->where('id', $id);
                                    $d->update('photo', $fileUpdate);
                                    unset($fileUpdate);
                                }
                            }

                            $success = true;
                        } else {
                            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
                        }
                    }
                }
            }

            if (!empty($response)) {
                /* Errors */
                $response['status'] = 'danger';
                $message = base64_encode(json_encode($response));
                $flash->set('message', $message);
                $func->redirect("index.php?com=photo&act=add_photo&type=" . $type);
            }

            if ($success == false) {
                $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
            } else {
                $func->transfer("Lưu dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage);
            }
        }

        $func->transfer("Dữ liệu rỗng", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
    }
}

/* Delete photo */
function deletePhoto()
{
    global $d, $func, $curPage, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id, photo from #_photo where id = ? and type = ? limit 0,1", array($id, $type));

        if (!empty($row)) {
            $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
            $d->rawQuery("delete from #_photo where id = ? and type = ?", array($id, $type));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id, photo from #_photo where id = ? and type = ? limit 0,1", array($id, $type));

            if (!empty($row)) {
                $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
                $d->rawQuery("delete from #_photo where id = ? and type = ?", array($id, $type));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
    }
}
