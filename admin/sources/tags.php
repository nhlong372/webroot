<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active tags */
if (isset($config['tags'])) {
    $arrCheck = array();
    foreach ($config['tags'] as $k => $v) $arrCheck[] = $k;
    if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
} else {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

switch ($act) {
    case "man":
        viewMans();
        $template = "tags/man/mans";
        break;
    case "add":
        $template = "tags/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "tags/man/man_add";
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

/* View tags */
function viewMans()
{
    global $d, $func, $curPage, $items, $paging, $type;

    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_tags where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_tags where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=tags&act=man&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit tags */
function editMan()
{
    global $d, $func, $curPage, $item, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=tags&act=man&type=" . $type . "&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from #_tags where id = ? and type = ? limit 0,1", array($id, $type));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=tags&act=man&type=" . $type . "&p=" . $curPage, false);
        }
    }
}

/* Save tags */
function saveMan()
{
    global $d, $curPage, $func, $flash, $config, $com, $type;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=tags&act=man&type=" . $type . "&p=" . $curPage, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            if (strpos($column, 'content') !== false || strpos($column, 'desc') !== false) {
                $data[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
            } else {
                $data[$column] = htmlspecialchars($func->sanitize($value));
            }
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        if (!empty($config['tags'][$type]['slug'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }

        $data['type'] = $type;
    }

    /* Post seo */
    if (isset($config['tags'][$type]['seo']) && $config['tags'][$type]['seo'] == true) {
        $dataSeo = (isset($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
        if ($dataSeo) {
            foreach ($dataSeo as $column => $value) {
                $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
            }
        }
    }

    /* Valid data */
    $checkTitle = $func->checkTitle($data);

    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
        }
    }

    if (!empty($config['tags'][$type]['slug'])) {
        foreach ($config['website']['slug'] as $k => $v) {
            $dataSlug = array();
            $dataSlug['slug'] = $data['slug' . $k];
            $dataSlug['id'] = $id;
            $dataSlug['copy'] = false;
            $checkSlug = $func->checkSlug($dataSlug);

            if ($checkSlug == 'exist') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') đã tồn tại';
            } else if ($checkSlug == 'empty') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') không được trống';
            }
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

        if (!empty($dataSeo)) {
            foreach ($dataSeo as $k => $v) {
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
            $func->redirect("index.php?com=tags&act=edit&type=" . $type . "&p=" . $curPage . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=tags&act=add&type=" . $type . "&p=" . $curPage);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('tags', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['tags'][$type]['img_type'], UPLOAD_TAGS, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_tags where id = ? and type = ? limit 0,1", array($id, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_TAGS . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('tags', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            if (isset($config['tags'][$type]['seo']) && $config['tags'][$type]['seo'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man', $type));

                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=tags&act=man&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=tags&act=man&type=" . $type . "&p=" . $curPage, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('tags', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['tags'][$type]['img_type'], UPLOAD_TAGS, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('tags', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            if (isset($config['tags'][$type]['seo']) && $config['tags'][$type]['seo'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=tags&act=man&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=tags&act=man&type=" . $type . "&p=" . $curPage, false);
        }
    }
}

/* Delete tags */
function deleteMan()
{
    global $d, $curPage, $func, $com, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_tags where id = ? and type = ? limit 0,1", array($id, $type));

        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_TAGS . $row['photo']);
            $d->rawQuery("delete from #_tags where id = ?", array($id));

            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man', $type));

            /* Xóa tags in Product tags */
            $d->rawQuery("delete from #_product_tags where id_tags = ?", array($id));

            /* Xóa tags in News tags */
            $d->rawQuery("delete from #_news_tags where id_tags = ?", array($id));

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=tags&act=man&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=tags&act=man&type=" . $type . "&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_tags where id = ? and type = ? limit 0,1", array($id, $type));

            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_TAGS . $row['photo']);
                $d->rawQuery("delete from #_tags where id = ?", array($id));

                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man', $type));

                /* Xóa tags in Product tags */
                $d->rawQuery("delete from #_product_tags where id_tags = ?", array($id));

                /* Xóa tags in News tags */
                $d->rawQuery("delete from #_news_tags where id_tags = ?", array($id));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=tags&act=man&type=" . $type . "&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=tags&act=man&type=" . $type . "&p=" . $curPage, false);
    }
}
