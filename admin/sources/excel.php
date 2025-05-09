<?php
/* Kiểm tra có đăng nhập chưa */
if ($func->checkLoginAdmin() == false && $act != "login") {
    $func->redirect("index.php?com=user&act=login");
}

/* Kiểm tra active export excel */
if (!isset($config['order']['excel']) || $config['order']['excel'] == false) $func->transfer("Trang không tồn tại", "index.php", false);

/* Setting */
$setting = $d->rawQueryOne("select * from #_setting limit 0,1");
$optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'], true) : null;

/* Thông tin đơn hàng */
$id_order = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
if (empty($id_order)) $func->transfer("Dữ liệu không có thực", "index.php?com=order&act=man", false);
$order_detail = $d->rawQueryOne("select * from #_order where id = ? limit 0,1", array($id_order));

/* Gán giá trị đơn hàng */
$code = @$order_detail['code'];
$order_status = @$order_detail['order_status'];
$temp_price = $func->formatMoney(@$order_detail['temp_price']);
$total_price = $func->formatMoney(@$order_detail['total_price']);
$ship_price = @$order_detail['ship_price'];
if ($ship_price) $ship_price = $func->formatMoney($ship_price);
else $ship_price = "Không";

/* Trang thái */
$order_status_info = $d->rawQueryOne("select namevi from #_order_status where id = ? limit 0,1", array($order_status));

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
$PHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

/* Merge cells */
$PHPExcel->setActiveSheetIndex(0);
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A7:C7');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A8:C8');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('D6:F6');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('D7:F7');
$PHPExcel->setActiveSheetIndex(0)->mergeCells('D8:F8');

/* set Cell Value */
$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $setting['namevi']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Hotline: ' . $optsetting['hotline']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Email: ' . $optsetting['email']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Địa chỉ: ' . $optsetting['address']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A6', 'Họ tên: ' . @$order_detail['fullname']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A7', 'Điện thoại: ' . @$order_detail['phone']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A8', 'Địa chỉ: ' . @$order_detail['address']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('D6', 'Mã đơn hàng: ' . $code);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('D7', 'Ngày đặt: ' . date('H:i A d-m-Y', @$order_detail['date_created']));
$PHPExcel->setActiveSheetIndex(0)->setCellValue('D8', 'Tình trạng: ' . $order_status_info['namevi']);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A10', 'STT');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('B10', 'Sản phẩm');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('C10', 'Số lượng');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('D10', 'Giá');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('E10', 'Giá mới');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('F10', 'Tạm tính');

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
$PHPExcel->getActiveSheet()->setSharedStyle($PHPExcelStyleTitle, 'A10:F10');

/* Lấy và Xuất dữ liệu */
$position = 11;
$items = $d->rawQuery("select * from #_order_detail where id_order = ?", array($id_order));

for ($i = 0; $i < count($items); $i++) {
    $regular_price = $func->formatMoney(@$items[$i]['regular_price']);
    $sale_price = $func->formatMoney(@$items[$i]['sale_price']);
    $sum_price = 0;
    if (isset($items[$i]['sale_price']) && $items[$i]['sale_price'] > 0) $sum_price = $func->formatMoney(@$items[$i]['sale_price'] * @$items[$i]['quantity']);
    else $sum_price = $func->formatMoney(@$items[$i]['regular_price'] * @$items[$i]['quantity']);

    $PHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $position, $i + 1)
        ->setCellValue('B' . $position, @$items[$i]['name'])
        ->setCellValue('C' . $position, @$items[$i]['quantity'])
        ->setCellValue('D' . $position, @$regular_price)
        ->setCellValue('E' . $position, @$sale_price)
        ->setCellValue('F' . $position, @$sum_price);

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
    $PHPExcel->getActiveSheet()->setSharedStyle($PHPExcelStyleContent, 'A' . $position . ':F' . $position);
    $position++;
}

/* Tính thành tiền */
$position++;
if ($config['order']['ship']) {
    /* Tạm tính */
    $PHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $position . ':E' . $position);
    $PHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $position, 'Tạm tính');
    $PHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $position, @$temp_price);
    $PHPExcel->getActiveSheet()->getStyle('A' . $position . ':F' . $position)->applyFromArray(
        array(
            'font' => array(
                'color' => array('rgb' => '000000'),
                'name' => 'Calibri',
                'bold' => true,
                'italic' => false,
                'size' => 10
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap' => true
            )
        )
    );
    $position++;
}

/* Phí vận chuyển */
if ($config['order']['ship']) {
    $PHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $position . ':E' . $position);
    $PHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $position, 'Phí vận chuyển');
    $PHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $position, @$ship_price);
    $PHPExcel->getActiveSheet()->getStyle('A' . $position . ':F' . $position)->applyFromArray(
        array(
            'font' => array(
                'color' => array('rgb' => '000000'),
                'name' => 'Calibri',
                'bold' => true,
                'italic' => false,
                'size' => 10
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap' => true
            )
        )
    );
    $position++;
}

/* Tổng tiền */
$PHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $position . ':E' . $position);
$PHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $position, 'Tổng giá trị đơn hàng');
$PHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $position, @$total_price);
$PHPExcel->getActiveSheet()->getStyle('A' . $position . ':F' . $position)->applyFromArray(
    array(
        'font' => array(
            'color' => array('rgb' => '000000'),
            'name' => 'Calibri',
            'bold' => true,
            'italic' => false,
            'size' => 10
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true
        )
    )
);
$position++;

/* Rename title */
$PHPExcel->getActiveSheet()->setTitle('Order');

/* Khởi tạo chỉ mục ở đầu sheet */
$PHPExcel->setActiveSheetIndex(0);

/* Xuất file */
$time = time();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="order_' . $code . '_' . $time . '_' . date('d_m_Y') . '.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit();
