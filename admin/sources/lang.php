<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active lang */
if (!isset($config['website']['debug-developer']) || $config['website']['debug-developer'] == false) $func->transfer("Trang không tồn tại", "index.php", false);

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$strUrl = (isset($_REQUEST['keyword'])) ? "&keyword=" . htmlspecialchars($_REQUEST['keyword']) : "";

switch ($act) {
    case "create":
        createMan();
        break;
    case "man":
        viewMans();
        $template = "lang/man/mans";
        break;
    case "add":
        $template = "lang/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "lang/man/man_add";
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

/* Create lang */
function createMan()
{
    global $d, $config, $func, $curPage;

    $flag = 0;
    foreach ($config['website']['lang'] as $k => $v) {
        $lang = $d->rawQuery("select lang_define, lang$k from #_lang");

        if (file_exists(LIBRARIES . "lang/" . $k . ".php")) {
            $langfile = fopen(LIBRARIES . "lang/" . $k . ".php", "w") or $func->transfer("Không thể tạo tập tin.", "index.php?com=lang&act=man&p=" . $curPage, false);

            $flag++;
            $str = '<?php';
            for ($i = 0; $i < count($lang); $i++) $str .= PHP_EOL . 'define("' . $lang[$i]['lang_define'] . '", "' . $lang[$i]['lang' . $k] . '");';
            $str .= PHP_EOL;

            fwrite($langfile, $str);
            fclose($langfile);
        }
    }

    if (!$flag) {
        $func->transfer("Tạo tập tin ngôn ngữ thất bại", "index.php?com=lang&act=man&p=" . $curPage, false);
    } else {
        $func->transfer("Tạo tập tin ngôn ngữ thành công", "index.php?com=lang&act=man&p=" . $curPage);
    }
}

/* View lang */
function viewMans()
{
    global $d, $func, $curPage, $items, $paging, $strUrl;

    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " where lang_define LIKE '%$keyword%'";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_lang $where order by id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_lang $where order by id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=lang&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit lang */
function editMan()
{
    global $d, $curPage, $func, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=lang&act=man&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from #_lang where id = ? limit 0,1", array($id));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=lang&act=man&p=" . $curPage, false);
        }
    }
}

/* Save lang */
function saveMan()
{
    global $d, $curPage, $func, $flash, $config;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=lang&act=man&p=" . $curPage, false);
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
    }

    /* Valid data */
    if (empty($data['lang_define'])) {
        $response['messages'][] = 'Tên biến không được trống';
    }

    foreach ($config['website']['lang'] as $k => $v) {
        if (isset($data['lang' . $k])) {
            $lang = trim($data['lang' . $k]);

            if (empty($lang)) {
                $response['messages'][] = 'Phần dịch nghĩa (' . $v . ') không được trống';
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

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if ($id) {
            $func->redirect("index.php?com=lang&act=edit&p=" . $curPage . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=lang&act=add&p=" . $curPage);
        }
    }

    /* Save data */
    if ($id) {
        $d->where('id', $id);
        if ($d->update('lang', $data)) $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=lang&act=man&p=" . $curPage);
        else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=lang&act=man&p=" . $curPage, false);
    } else {
        if ($d->insert('lang', $data)) $func->transfer("Lưu dữ liệu thành công", "index.php?com=lang&act=man&p=" . $curPage);
        else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=lang&act=man&p=" . $curPage, false);
    }
}

/* Delete lang */
function deleteMan()
{
    global $d, $func, $curPage;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id from #_lang where id = ? limit 0,1", array($id));

        if (!empty($row)) {
            $d->rawQuery("delete from #_lang where id = ?", array($id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=lang&act=man&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=lang&act=man&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id from #_lang where id = ? limit 0,1", array($id));

            if (!empty($row)) $d->rawQuery("delete from #_lang where id = ?", array($id));
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=lang&act=man&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=lang&act=man&p=" . $curPage, false);
    }
}
