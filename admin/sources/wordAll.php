<?php
/* Kiểm tra có đăng nhập chưa */
if ($func->checkLoginAdmin() == false && $act != "login") {
    $func->redirect("index.php?com=user&act=login");
}

/* Kiểm tra active export word */
if (!isset($config['order']['wordall']) || $config['order']['wordall'] == false) $func->transfer("Trang không tồn tại", "index.php", false);

/* Setting */
$setting = $d->rawQueryOne("select * from #_setting limit 0,1");
$optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'], true) : null;

/* Thông tin đơn hàng */
$time = time();
$sql = "select * from #_order where id<>0";

$listid = (isset($_REQUEST['listid'])) ? htmlspecialchars($_REQUEST['listid']) : '';
$order_status = (isset($_REQUEST['order_status'])) ? htmlspecialchars($_REQUEST['order_status']) : 0;
$order_payment = (isset($_REQUEST['order_payment'])) ? htmlspecialchars($_REQUEST['order_payment']) : 0;
$order_date = (isset($_REQUEST['order_date'])) ? htmlspecialchars($_REQUEST['order_date']) : '';
$range_price = (isset($_REQUEST['range_price'])) ? htmlspecialchars($_REQUEST['range_price']) : '';
$city = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
$district = (isset($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;
$ward = (isset($_REQUEST['id_ward'])) ? htmlspecialchars($_REQUEST['id_ward']) : 0;

if ($listid) $sql .= " and id IN ($listid)";
if ($order_status) $sql .= " and order_status=$order_status";
if ($order_payment) $sql .= " and order_payment=$order_payment";
if ($order_date) {
    $order_date = explode("-", $order_date);
    $ngaytu = trim($order_date[0]);
    $ngayden = trim($order_date[1]);
    $ngaytu = strtotime(str_replace("/", "-", $ngaytu));
    $ngayden = strtotime(str_replace("/", "-", $ngayden));
    $sql .= " and date_created<=$ngayden and date_created>=$ngaytu";
}
if ($range_price) {
    $range_price = explode(";", $range_price);
    $price_from = trim($range_price[0]);
    $price_to = trim($range_price[1]);
    $sql .= " and total_price<=$price_to and total_price>=$price_from";
}
if ($city) $sql .= " and city=$city";
if ($district) $sql .= " and district=$district";
if ($ward) $sql .= " and ward=$ward";
if (isset($_REQUEST['keyword'])) {
    $keyword = htmlspecialchars($_REQUEST['keyword']);
    $sql .= " and (fullname LIKE '%$keyword%' or email LIKE '%$keyword%' or phone LIKE '%$keyword%' or code LIKE '%$keyword%')";
}

$sql .= " order by date_created desc";
$orders = $d->rawQuery($sql);

/* PHPWord */
require_once LIBRARIES . 'PHPWord.php';

/* Khởi tạo PHPWord */
$PHPWord = new PHPWord();

/* file sample */
$file_sample = LIBRARIES . 'sample/orderlist.docx';

/* Load file Word mẫu */
$document = $PHPWord->loadTemplate($file_sample);

/* Thông tin công ty */
$document->setValue('{name_company}', $setting["namevi"]);
$document->setValue('{hotline_company}', $optsetting["hotline"]);
$document->setValue('{email_company}', $optsetting["email"]);
$document->setValue('{address_company}', $optsetting["address"]);

/* Tạo danh sách đơn hàng */
$data = array();
for ($i = 0; $i < count($orders); $i++) {
    /* Phí ship */
    if (isset($orders[$i]['ship_price']) && $orders[$i]['ship_price'] > 0) $ship_price = $func->formatMoney(@$orders[$i]['ship_price']);
    else $ship_price = "Không";

    /* Trang thái */
    $order_status_info = $d->rawQueryOne("select namevi from #_order_status where id = ? limit 0,1", array($orders[$i]['order_status']));

    /* STT */
    $data["numb"][$i] = $i + 1;

    /* Thông tin đơn hàng */
    $data["code"][$i] = @$orders[$i]['code'];
    $data["order_date"][$i] = date('H:i A d-m-Y', @$orders[$i]['date_created']);
    $data["order_status"][$i] = $order_status_info['namevi'];
    $order_payment = $func->getInfoDetail('namevi', 'news', @$orders[$i]['order_payment']);
    $data["order_payment"][$i] = $order_payment['namevi'];

    /* Thông tin khách hàng */
    $data["fullname_customer"][$i] = @$orders[$i]['fullname'];
    $data["phone_customer"][$i] = @$orders[$i]['phone'];
    $data["email_customer"][$i] = @$orders[$i]['email'];
    $data["address_customer"][$i] = @$orders[$i]['address'];

    /* Tính thành tiền */
    $data["temp_price"][$i] = $func->formatMoney(@$orders[$i]['temp_price']);
    $data["ship_price"][$i] = $ship_price;
    $data["total_price"][$i] = $func->formatMoney(@$orders[$i]['total_price']);
}

/* Thiết lập đối tượng dữ liệu từng dòng */
$document->cloneRow('TB', $data);

/* Xuất file */
$filename = "orders_list" . $time . "_" . date('d_m_Y') . ".docx";
$document->save($filename);
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($filename));
flush();
readfile($filename);
unlink($filename);
