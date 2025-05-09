<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active one signal */
if (!isset($config['onesignal']) || $config['onesignal'] == false) $func->transfer("Trang không tồn tại", "index.php", false);

switch ($act) {
    case "man":
        viewMans();
        $template = "pushOnesignal/man/mans";
        break;
    case "add":
        $template = "pushOnesignal/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "pushOnesignal/man/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "sync":
        sendSync();
        break;
    case "delete":
        deleteMan();
        break;
    default:
        $template = "404";
}

/* View onesignal */
function viewMans()
{
    global $d, $func, $curPage, $items, $paging;

    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (name LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_pushonesignal where id<>0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_pushonesignal where id<>0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=pushOnesignal&act=man";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit onesignal */
function editMan()
{
    global $d, $func, $curPage, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=pushOnesignal&act=man&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from #_pushonesignal where id = ? limit 0,1", array($id));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=pushOnesignal&act=man&p=" . $curPage, false);
        }
    }
}

/* Save onesignal */
function saveMan()
{
    global $d, $func, $flash, $curPage;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=pushOnesignal&act=man&p=" . $curPage, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = !empty($_POST['data']) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        $data['date_created'] = time();
    }

    /* Valid data */
    if (empty($data['name'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (empty($data['link'])) {
        $response['messages'][] = 'Liên kết không được trống';
    }

    if (!empty($data['link']) && !$func->isUrl($data['link'])) {
        $response['messages'][] = 'Liên kết không hợp lệ';
    }

    if (empty($data['description'])) {
        $response['messages'][] = 'Mô tả không được trống';
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

        if ($id) {
            $func->redirect("index.php?com=pushOnesignal&act=edit&p=" . $curPage . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=pushOnesignal&act=add&p=" . $curPage);
        }
    }

    /* Save data */
    if ($id) {
        $d->where('id', $id);
        if ($d->update('pushonesignal', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", '.jpg|.gif|.png|.jpeg|.gif', UPLOAD_SYNC, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_pushonesignal where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_SYNC . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('pushonesignal', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=pushOnesignal&act=man&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=pushOnesignal&act=man&p=" . $curPage, false);
        }
    } else {
        if ($d->insert('pushonesignal', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", '.jpg|.gif|.png|.jpeg|.gif', UPLOAD_SYNC, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('pushonesignal', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=pushOnesignal&act=man&p=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=pushOnesignal&act=man&p=" . $curPage, false);
        }
    }
}

/* Delete onesignal */
function deleteMan()
{
    global $d, $func, $curPage;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id, photo from #_pushonesignal where id = ? limit 0,1", array($id));

        if (!empty($row)) {
            $func->deleteFile(UPLOAD_SYNC . $row['photo']);
            $d->rawQuery("delete from #_pushonesignal where id = ?", array($id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=pushOnesignal&act=man&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=pushOnesignal&act=man&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id, photo from #_pushonesignal where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                $func->deleteFile(UPLOAD_SYNC . $row['photo']);
                $d->rawQuery("delete from #_pushonesignal where id = ?", array($id));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=pushOnesignal&act=man&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=pushOnesignal&act=man&p=" . $curPage, false);
    }
}

/* Send onesignal */
function sendMessageOnesignal($heading = '', $content = '', $url = 'https://www.google.com/', $photo = '')
{
    global $d, $configBase, $config;

    $contents = array(
        "en" => $content
    );
    $headings = array(
        "en" => $heading
    );
    $uphoto = (isset($photo) && $photo != '') ? $configBase . UPLOAD_SYNC_L . $photo : '';

    $fields = array(
        'app_id' => $config['oneSignal']['id'],
        'included_segments' => array('All'),
        'contents' => $contents,
        'headings' => $headings,
        'url' => $url,
        'chrome_web_image' => $uphoto
    );
    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . $config['oneSignal']['restId']
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

/* Sync onesignal */
function sendSync()
{
    global $d, $func, $curPage, $config;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id,photo,name,description,link from #_pushonesignal where id = ? limit 0,1", array($id));
        sendMessageOnesignal($row['name'], $row['description'], $row['link'], $row['photo']);
        $func->transfer("Gửi thông báo thành công", "index.php?com=pushOnesignal&act=man&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=pushOnesignal&act=man&p=" . $curPage, false);
    }
}
