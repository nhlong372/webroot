<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active đơn hàng */
if (!isset($config['order']['active']) || $config['order']['active'] == false) $func->transfer("Trang không tồn tại", "index.php", false);

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$strUrl .= (isset($_REQUEST['order_status'])) ? "&order_status=" . htmlspecialchars($_REQUEST['order_status']) : "";
$strUrl .= (isset($_REQUEST['order_payment'])) ? "&order_payment=" . htmlspecialchars($_REQUEST['order_payment']) : "";
$strUrl .= (isset($_REQUEST['order_date'])) ? "&order_date=" . htmlspecialchars($_REQUEST['order_date']) : "";
$strUrl .= (isset($_REQUEST['range_price'])) ? "&range_price=" . htmlspecialchars($_REQUEST['range_price']) : "";
$strUrl .= (isset($_REQUEST['city'])) ? "&city=" . htmlspecialchars($_REQUEST['city']) : "";
$strUrl .= (isset($_REQUEST['district'])) ? "&district=" . htmlspecialchars($_REQUEST['district']) : "";
$strUrl .= (isset($_REQUEST['ward'])) ? "&ward=" . htmlspecialchars($_REQUEST['ward']) : "";
$strUrl .= (isset($_REQUEST['keyword'])) ? "&keyword=" . htmlspecialchars($_REQUEST['keyword']) : "";

switch ($act) {
    case "man":
        viewMans();
        $template = "order/man/mans";
        break;
    case "edit":
        editMan();
        $template = "order/man/man_add";
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

/* View order */
function viewMans()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $minTotal, $maxTotal, $price_from, $price_to, $allNewOrder, $totalNewOrder, $allConfirmOrder, $totalConfirmOrder, $allDeliveriedOrder, $totalDeliveriedOrder, $allCanceledOrder, $totalCanceledOrder;

    $where = "";

    $order_status = (isset($_REQUEST['order_status'])) ? htmlspecialchars($_REQUEST['order_status']) : 0;
    $order_payment = (isset($_REQUEST['order_payment'])) ? htmlspecialchars($_REQUEST['order_payment']) : 0;
    $order_date = (isset($_REQUEST['order_date'])) ? htmlspecialchars($_REQUEST['order_date']) : 0;
    $range_price = (isset($_REQUEST['range_price'])) ? htmlspecialchars($_REQUEST['range_price']) : 0;
    $city = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
    $district = (isset($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;
    $ward = (isset($_REQUEST['id_ward'])) ? htmlspecialchars($_REQUEST['id_ward']) : 0;

    if ($order_status) $where .= " and order_status=$order_status";
    if ($order_payment) $where .= " and order_payment=$order_payment";
    if ($order_date) {
        $order_date = explode("-", $order_date);
        $date_from = trim($order_date[0] . ' 12:00:00 AM');
        $date_to = trim($order_date[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $where .= " and date_created<=$date_to and date_created>=$date_from";
    }
    if ($range_price) {
        $range_price = explode(";", $range_price);
        $price_from = trim($range_price[0]);
        $price_to = trim($range_price[1]);
        $where .= " and total_price<=$price_to and total_price>=$price_from";
    }
    if ($city) $where .= " and city=$city";
    if ($district) $where .= " and district=$district";
    if ($ward) $where .= " and ward=$ward";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (fullname LIKE '%$keyword%' or email LIKE '%$keyword%' or phone LIKE '%$keyword%' or code LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_order where id<>0 $where order by date_created desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_order where id<>0 $where order by date_created desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=order&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* Lấy tổng giá min */
    $minTotal = $d->rawQueryOne("select min(total_price) from #_order");
    if ($minTotal['min(total_price)']) $minTotal = $minTotal['min(total_price)'];
    else $minTotal = 0;

    /* Lấy tổng giá max */
    $maxTotal = $d->rawQueryOne("select max(total_price) from #_order");
    if ($maxTotal['max(total_price)']) $maxTotal = $maxTotal['max(total_price)'];
    else $maxTotal = 0;

    /* Lấy đơn hàng - mới đặt */
    $order_count = $d->rawQueryOne("select count(id), sum(total_price) from #_order where order_status = 1");
    $allNewOrder = $order_count['count(id)'];
    $totalNewOrder = $order_count['sum(total_price)'];

    /* Lấy đơn hàng - đã xác nhận */
    $order_count = $d->rawQueryOne("select count(id), sum(total_price) from #_order where order_status = 2");
    $allConfirmOrder = $order_count['count(id)'];
    $totalConfirmOrder = $order_count['sum(total_price)'];

    /* Lấy đơn hàng - đã giao */
    $order_count = $d->rawQueryOne("select count(id), sum(total_price) from #_order where order_status = 4");
    $allDeliveriedOrder = $order_count['count(id)'];
    $totalDeliveriedOrder = $order_count['sum(total_price)'];

    /* Lấy đơn hàng - đã hủy */
    $order_count = $d->rawQueryOne("select count(id), sum(total_price) from #_order where order_status = 5");
    $allCanceledOrder = $order_count['count(id)'];
    $totalCanceledOrder = $order_count['sum(total_price)'];
}

/* Edit order */
function editMan()
{
    global $d, $func, $curPage, $item, $order_detail;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=order&act=man&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from #_order where id = ? limit 0,1", array($id));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=order&act=man&p=" . $curPage, false);
        } else {
            /* Lấy chi tiết đơn hàng */
            $order_detail = $d->rawQuery("select * from #_order_detail where id_order = ? order by id desc", array($id));
        }
    }
}

/* Save order */
function saveMan()
{
    global $d, $func, $curPage;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=order&act=man&p=" . $curPage, false);
    }


    /* Post dữ liệu */
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Save data */
    if ($id) {
        $d->where('id', $id);
        if ($d->update('order', $data)) {
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=order&act=man&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=order&act=man&p=" . $curPage, false);
        }
    } else {
        $func->transfer("Dữ liệu rỗng", "index.php?com=order&act=man&p=" . $curPage, false);
    }
}

/* Delete order */
function deleteMan()
{
    global $d, $func, $curPage;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id from #_order where id = ? limit 0,1", array($id));

        if (!empty($row)) {
            $d->rawQuery("delete from #_order_detail where id_order = ?", array($id));
            $d->rawQuery("delete from #_order where id = ?", array($id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=order&act=man&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=order&act=man&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id from #_order where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                $d->rawQuery("delete from #_order_detail where id_order = ?", array($id));
                $d->rawQuery("delete from #_order where id = ?", array($id));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=order&act=man&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=order&act=man&p=" . $curPage, false);
    }
}
