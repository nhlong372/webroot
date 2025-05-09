<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active newsletter */
$arrCheck = array();
foreach ($config['newsletter'] as $k => $v) $arrCheck[] = $k;
if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);

/* Send email */
if (!empty($_POST["listemail"]) && !empty($_POST['subject']) && !empty($_POST['content'])) {
    /* Defaults attributes email */
    $emailDefaultAttrs = $emailer->defaultAttrs();

    /* Variables email */
    $emailVars = array(
        '{emailSubjectSender}',
        '{emailContentSender}'
    );
    $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

    /* Values email */
    $emailVals = array(
        htmlspecialchars($_POST['subject']),
        $func->decodeHtmlChars($_POST['content'])
    );
    $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

    /* Send email */
    $arrayEmail = array();
    $listemail = explode(",", $_POST['listemail']);
    for ($i = 0; $i < count($listemail); $i++) {
        $id = htmlspecialchars($listemail[$i]);
        $row = $d->rawQueryOne("select id, email, fullname from #_newsletter where id = ? and type = ? limit 0,1", array($id, $type));

        if (!empty($row)) {
            $data = array();
            $data['name'] = $row['fullname'];
            $data['email'] = $row['email'];
            $arrayEmail["dataEmail" . $i] = $data;
        }
    }
    $subject = "Thư phản hồi từ " . $setting['namevi'];
    $message = str_replace($emailVars, $emailVals, $emailer->markdown('newsletter/customer'));
    $file = 'file';

    if ($emailer->send("customer", $arrayEmail, $subject, $message, $file)) {
        $func->transfer("Email đã được gửi thành công.", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage);
    } else {
        $func->transfer("Email gửi bị lỗi. Vui lòng thử lại sau", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage, false);
    }
}

switch ($act) {
    case "man":
        viewMans();
        $template = "newsletter/man/mans";
        break;
    case "add":
        $template = "newsletter/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "newsletter/man/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;
    default:
        $template = "404";
}

/* View newsletter */
function viewMans()
{
    global $d, $func, $curPage, $items, $paging, $type;

    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (fullname LIKE '%$keyword%' or email LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_newsletter where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_newsletter where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=newsletter&act=man&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit newsletter */
function editMan()
{
    global $d, $func, $curPage, $item, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from #_newsletter where id = ? and type = ? limit 0,1", array($id, $type));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage, false);
        }
    }
}

/* Save newsletter */
function saveMan()
{
    global $d, $func, $flash, $curPage, $config, $type;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        $data['status'] = (!empty($data['confirm_status'])) ? 'hienthi' : '';
        $data['type'] = $type;
    }

    /* Valid data */
    if (!empty($config['newsletter'][$type]['fullname'])) {
        if (empty($data['fullname'])) {
            $response['messages'][] = 'Họ tên không được trống';
        }
    }

    if (!empty($config['newsletter'][$type]['phone'])) {
        if (empty($data['phone'])) {
            $response['messages'][] = 'Số điện thoại không được trống';
        }

        if (!empty($data['phone']) && !$func->isPhone($data['phone'])) {
            $response['messages'][] = 'Số điện thoại không hợp lệ';
        }
    }

    if (!empty($config['newsletter'][$type]['email'])) {
        if (empty($data['email'])) {
            $response['messages'][] = 'Email không được trống';
        }

        if (!empty($data['email']) && !$func->isEmail($data['email'])) {
            $response['messages'][] = 'Email không hợp lệ';
        }
    }

    if (!empty($config['newsletter'][$type]['address'])) {
        if (empty($data['address'])) {
            $response['messages'][] = 'Địa chỉ không được trống';
        }
    }

    if (!empty($config['newsletter'][$type]['subject'])) {
        if (empty($data['subject'])) {
            $response['messages'][] = 'Chủ đề không được trống';
        }
    }

    if (!empty($config['newsletter'][$type]['content'])) {
        if (empty($data['content'])) {
            $response['messages'][] = 'Nội dung không được trống';
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

        if (empty($id)) {
            $func->redirect("index.php?com=newsletter&act=add&type=" . $type);
        } else {
            $func->redirect("index.php?com=newsletter&act=edit&id=" . $id . "&type=" . $type);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('newsletter', $data)) {
            /* File attach */
            if ($func->hasFile("file_attach")) {
                $fileUpdate = array();
                $file_name = $func->uploadName($_FILES["file_attach"]["name"]);

                if ($file_attach = $func->uploadImage("file_attach", $config['newsletter'][$type]['file_type'], UPLOAD_FILE, $file_name)) {
                    $row = $d->rawQueryOne("select id, file_attach from #_newsletter where id = ? and type = ? limit 0,1", array($id, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
                    }

                    $fileUpdate['file_attach'] = $file_attach;
                    $d->where('id', $id);
                    $d->update('newsletter', $fileUpdate);
                    unset($fileUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('newsletter', $data)) {
            $id_insert = $d->getLastInsertId();

            /* File attach */
            if ($func->hasFile("file_attach")) {
                $fileUpdate = array();
                $file_name = $func->uploadName($_FILES['file_attach']["name"]);

                if ($file_attach = $func->uploadImage("file_attach", $config['newsletter'][$type]['file_type'], UPLOAD_FILE, $file_name)) {
                    $fileUpdate['file_attach'] = $file_attach;
                    $d->where('id', $id_insert);
                    $d->update('newsletter', $fileUpdate);
                    unset($fileUpdate);
                }
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage, false);
        }
    }
}

/* Delete newsletter */
function deleteMan()
{
    global $d, $func, $curPage, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id, file_attach from #_newsletter where id = ? and type = ? limit 0,1", array($id, $type));

        if (!empty($row)) {
            $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
            $d->rawQuery("delete from #_newsletter where id = ? and type = ?", array($id, $type));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id, file_attach from #_newsletter where id = ? and type = ? limit 0,1", array($id, $type));

            if (!empty($row)) {
                $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
                $d->rawQuery("delete from #_newsletter where id = ? and type = ?", array($id, $type));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=newsletter&act=man&type=" . $type . "&p=" . $curPage, false);
    }
}
