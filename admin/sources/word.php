<?php
/* Kiểm tra có đăng nhập chưa */
if ($func->checkLoginAdmin() == false && $act != "login") {
    $func->redirect("index.php?com=user&act=login");
}

/* Kiểm tra active export word */
if (!isset($config['order']['word']) || $config['order']['word'] == false) $func->transfer("Trang không tồn tại", "index.php", false);

/* Setting */
$setting = $d->rawQueryOne("select * from #_setting limit 0,1");
$optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'], true) : null;

/* Thông tin đơn hàng */
$id_order = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
if (empty($id_order)) $func->transfer("Dữ liệu không có thực", "index.php?com=order&act=man", false);
$order_detail = $d->rawQueryOne("select * from #_order where id = ? limit 0,1", array($id_order));

/* Chi tiết đơn hàng */
$detail = $d->rawQuery("select * from #_order_detail where id_order = ?", array($id_order));

/* Gán giá trị đơn hàng */
$time = time();
$code = @$order_detail['code'];
$order_date = date('H:i A d-m-Y', @$order_detail['date_created']);
$order_status = @$order_detail['order_status'];
$fullname_customer = @$order_detail["fullname"];
$phone_customer = @$order_detail["phone"];
$email_customer = @$order_detail["email"];
$address_customer = @$order_detail["address"];
$requirements_customer = @$order_detail["requirements"];
$temp_price = $func->formatMoney(@$order_detail['temp_price']);
$total_price = $func->formatMoney(@$order_detail['total_price']);
$ship_price = @$order_detail['ship_price'];
if ($ship_price) $ship_price = $func->formatMoney($ship_price);
else $ship_price = "Không";

/* Trang thái */
$order_status_info = $d->rawQueryOne("select namevi from #_order_status where id = ? limit 0,1", array($order_status));

/* PHPWord */
require_once LIBRARIES . 'PHPWord.php';

/* Khởi tạo PHPWord */
$PHPWord = new PHPWord();

/* File sample */
$file_sample = LIBRARIES . 'sample/order.docx';

/* Load file Word mẫu */
$document = $PHPWord->loadTemplate($file_sample);

/* Thông tin công ty */
$document->setValue('{name_company}', $setting["namevi"]);
$document->setValue('{hotline_company}', $optsetting["hotline"]);
$document->setValue('{email_company}', $optsetting["email"]);
$document->setValue('{address_company}', $optsetting["address"]);

/* Thông tin đơn hàng */
$document->setValue('{code}', $code);
$document->setValue('{order_date}', $order_date);
$document->setValue('{order_status}', @$order_status_info['namevi']);

/* Thông tin khách hàng */
$document->setValue('{fullname_customer}', $fullname_customer);
$document->setValue('{phone_customer}', $phone_customer);
$document->setValue('{email_customer}', $email_customer);
$document->setValue('{address_customer}', $address_customer);
$document->setValue('{requirements_customer}', $requirements_customer);

/* Tạo chi tiết đơn hàng */
$data = array();
for ($i = 0; $i < count($detail); $i++) {
    $data["numb"][$i] = $i + 1;
    $data["name"][$i] = @$detail[$i]["name"];
    $data["color"][$i] = @$detail[$i]["color"];
    $data["size"][$i] = @$detail[$i]["size"];
    $data["regular_price"][$i] = $func->formatMoney(@$detail[$i]["regular_price"]);
    $data["sale_price"][$i] = $func->formatMoney(@$detail[$i]["sale_price"]);
    $data["quantity"][$i] = @$detail[$i]["quantity"];
    $data["sum_price"][$i] = 0;
    if (isset($detail[$i]["sale_price"]) && @$detail[$i]["sale_price"] > 0) $data["sum_price"][$i] = $func->formatMoney(@$detail[$i]["sale_price"] * $data["quantity"][$i]);
    else $data["sum_price"][$i] = $func->formatMoney(@$detail[$i]["regular_price"] * $data["quantity"][$i]);
}

/* Thiết lập đối tượng dữ liệu từng dòng */
$document->cloneRow('TB', $data);

/* Tính thành tiền */
$document->setValue('{temp_price}', $temp_price);
$document->setValue('{ship_price}', $ship_price);
$document->setValue('{total_price}', $total_price);

/* Xuất file */
$filename = "order_" . $code . "_" . $time . "_" . date('d_m_Y') . ".docx";
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
