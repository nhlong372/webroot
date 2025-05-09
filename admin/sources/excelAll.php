<?php
/* Kiểm tra có đăng nhập chưa */
if ($func->checkLoginAdmin() == false && $act != "login") {
    $func->redirect("index.php?com=user&act=login");
}

/* Kiểm tra active export excel */
if (!isset($config['order']['excelall']) || $config['order']['excelall'] == false) $func->transfer("Trang không tồn tại", "index.php", false);

/* Setting */
$setting = $d->rawQueryOne("select * from #_setting limit 0,1");
$optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'], true) : null;

/* Thông tin đơn hàng */
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
    $date_from = trim($order_date[0] . ' 12:00:00 AM');
    $date_to = trim($order_date[1] . ' 11:59:59 PM');
    $date_from = strtotime(str_replace("/", "-", $date_from));
    $date_to = strtotime(str_replace("/", "-", $date_to));
    $sql .= " and date_created<=$date_to and date_created>=$date_from";
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

/* PHPExcel */
require_once LIBRARIES . 'PHPExcel.php';

/* Khởi tọa đối tượng */
$PHPExcel = new PHPExcel();
$PHPExcelStyleTitle = new PHPExcel_Style();
$PHPExcelStyleContent = new PHPExcel_Style();

/* Khởi tạo thông tin người tạo */
$PHPExcel->getProperties()->setCreator($setting['namevi']);
$PHPExcel->getProperties()->setLastModifiedBy($setting['namevi']);
$PHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$PHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$PHPExcel->getProperties()->setDescription("Document for Office 2007 XLSX, generated using PHP classes.");

/* Merge cells */
$PHPExcel->setActiveSheetIndex(0);
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L1');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A2:L2');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A3:L3');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A4:L4');

/* set Cell Value */
$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $setting['namevi']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Hotline: ' . $optsetting['hotline']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Email: ' . $optsetting['email']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Địa chỉ: ' . $optsetting['address']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A6', 'STT');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('B6', 'Mã đơn hàng');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('C6', 'Ngày đặt');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('D6', 'Tình trạng');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('E6', 'Hình thức thanh toán');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('F6', 'Họ tên');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('G6', 'Điện thoại');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('H6', 'Email');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('I6', 'Địa chỉ');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('J6', 'Tạm tính');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('K6', 'Phí vận chuyển');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('L6', 'Tổng giá trị đơn hàng');

/* Style */
$PHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
    array(
        'font' => array(
            'color' => array(
                'rgb' => '000000'
            ),
            'name' => 'Arial',
            'bold' => true,
            'italic' => false,
            'size' => 14
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        )
    )
);
$PHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray(
    array(
        'font' => array(
            'size' => 11
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        )
    )
);
$PHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray(
    array(
        'font' => array(
            'size' => 11
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        )
    )
);
$PHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray(
    array(
        'font' => array(
            'size' => 11
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        )
    )
);
$PHPExcelStyleTitle->applyFromArray(
    array(
        'font' => array(
            'color' => array('rgb' => '000000'),
            'name' => 'Calibri',
            'bold' => true,
            'italic' => false,
            'size' => 10
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        ),
        'borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        )
    )
);
$PHPExcel->getActiveSheet()->setSharedStyle($PHPExcelStyleTitle, 'A6:L6');

/* Lấy và Xuất dữ liệu */
$position = 7;
for ($i = 0; $i < count($orders); $i++) {
    /* Phí ship */
    if (isset($orders[$i]['ship_price']) && $orders[$i]['ship_price'] > 0) $ship_price = $func->formatMoney(@$orders[$i]['ship_price']);
    else $ship_price = "Không";

    /* Trang thái */
    $order_status_info = $d->rawQueryOne("select namevi from #_order_status where id = ? limit 0,1", array($orders[$i]['order_status']));

    /* Lấy hình thức thanh toán */
    $order_payment = $func->getInfoDetail('namevi', 'news', @$orders[$i]['order_payment']);

    /* Gán giá trị */
    $PHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $position, $i + 1)
        ->setCellValue('B' . $position, $func->decodeHtmlChars($orders[$i]['code']))
        ->setCellValue('C' . $position, date('H:i A d-m-Y', $orders[$i]['date_created']))
        ->setCellValue('D' . $position, $func->decodeHtmlChars($order_status_info['namevi']))
        ->setCellValue('E' . $position, $func->decodeHtmlChars($order_payment['namevi']))
        ->setCellValue('F' . $position, $func->decodeHtmlChars($orders[$i]['fullname']))
        ->setCellValue('G' . $position, $func->decodeHtmlChars($orders[$i]['phone']))
        ->setCellValue('H' . $position, $func->decodeHtmlChars($orders[$i]['email']))
        ->setCellValue('I' . $position, $func->decodeHtmlChars($orders[$i]['address']))
        ->setCellValue('J' . $position, $func->formatMoney($orders[$i]['temp_price']))
        ->setCellValue('K' . $position, $func->decodeHtmlChars($ship_price))
        ->setCellValue('L' . $position, $func->formatMoney($orders[$i]['total_price']));

    $PHPExcelStyleContent->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap' => true
            ),
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            )
        )
    );
    $PHPExcel->getActiveSheet()->setSharedStyle($PHPExcelStyleContent, 'A' . $position . ':L' . $position);
    $position++;
}

/* Rename title */
$PHPExcel->getActiveSheet()->setTitle('Orders List');

/* Khởi tạo chỉ mục ở đầu sheet */
$PHPExcel->setActiveSheetIndex(0);

/* Xuất file */
$time = time();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="orders_list_' . $time . '_' . date('d_m_Y') . '.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit();
