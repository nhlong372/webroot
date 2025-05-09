<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active export */
if (isset($config['product'])) {
    $arrCheck = array();
    foreach ($config['product'] as $k => $v) if (isset($v['export']) && $v['export'] == true) $arrCheck[] = $k;
    if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
} else {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

switch ($act) {
    case "man":
        $template = "export/man/mans";
        break;

    case "exportExcel":
        exportExcel();
        break;

    default:
        $template = "404";
}

function exportExcel()
{
    global $d, $func, $type;

    /* Setting */
    $setting = $d->rawQueryOne("select * from #_setting limit 0,1");
    $optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'], true) : null;

    if (isset($_POST['exportExcel'])) {
        /* PHPExcel */
        require_once LIBRARIES . 'PHPExcel.php';

        /* Khởi tọa đối tượng */
        $PHPExcel = new PHPExcel();

        /* Khởi tạo thông tin người tạo */
        $PHPExcel->getProperties()->setCreator($setting['namevi']);
        $PHPExcel->getProperties()->setLastModifiedBy($setting['namevi']);
        $PHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $PHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $PHPExcel->getProperties()->setDescription("Document for Office 2007 XLSX, generated using PHP classes.");

        /* Khởi tạo mảng column */
        $alphas = range('A', 'Z');
        $array_columns = array(
            'numb' => 'STT',
            'id_list' => 'Danh Mục Cấp 1',
            'id_cat' => 'Danh mục 2',
            'code' => 'Mã sản phẩm',
            'namevi' => 'Tên Sản phẩm',
            'regular_price' => 'Giá bán',
            'sale_price' => 'Giá mới',
            'discount' => 'Chiết khấu',
            'descvi' => 'Mô tả',
            'contentvi' => 'Nội dung',
            'photo' => 'Hình đại diện'
        );

        /* Khởi tạo và style cho row đầu tiên */
        $i = 0;
        foreach ($array_columns as $k => $v) {
            if ($k == 'numb') {
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(5);
            } else if ($k == 'id_list' || $k == 'id_cat') {
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(20);
            } else if ($k == 'code') {
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(15);
            } else if ($k == 'namevi') {
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(40);
            } else if ($k == 'regular_price' || $k == 'sale_price' || $k == 'discount') {
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(10);
            } else if ($k == 'descvi' || $k == 'contentvi' || $k == 'photo') {
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(35);
            }

            $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$i] . '1', $v);
            $PHPExcel->getActiveSheet()->getStyle($alphas[$i] . '1')->applyFromArray(array('font' => array('color' => array('rgb' => 'ffffff'), 'name' => 'Calibri', 'bold' => true, 'italic' => false, 'size' => 10), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '007BFF'))));
            $i++;
        }

        /* Lấy và Xuất dữ liệu */
        $whereCategory = "";
        $data = (isset($_POST['data'])) ? $_POST['data'] : null;
        if ($data) {
            foreach ($data as $column => $value) {
                if ($value > 0) {
                    $whereCategory .= " and " . $column . " = " . $value;
                }
            }
        }

        $product = $d->rawQuery("select * from #_product where type = ? $whereCategory order by numb,id desc", array($type));

        $position = 2;
        for ($i = 0; $i < count($product); $i++) {
            $j = 0;
            foreach ($array_columns as $k => $v) {
                if ($k == 'id_list') {
                    $namelist = $d->rawQueryOne("select namevi from #_product_list where id = ? limit 0,1", array($product[$i][$k]));
                    $datacell = (!empty($namelist['namevi'])) ? $namelist['namevi'] : '';
                } else if ($k == 'id_cat') {
                    $namecat = $d->rawQueryOne("select namevi from #_product_cat where id = ? limit 0,1", array($product[$i][$k]));
                    $datacell = (!empty($namecat['namevi'])) ? $namecat['namevi'] : '';
                } else {
                    $datacell = $product[$i][$k];
                }

                if ($k == 'code') {
                    $PHPExcel->getActiveSheet()->setCellValueExplicit($alphas[$j] . $position, $func->decodeHtmlChars($datacell),  PHPExcel_Cell_DataType::TYPE_STRING);
                } else {
                    $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$j] . $position, $func->decodeHtmlChars($datacell));
                }
                $j++;
            }
            $position++;
        }

        /* Style cho các row dữ liệu */
        $position = 2;
        for ($i = 0; $i < count($product); $i++) {
            $j = 0;
            foreach ($array_columns as $k => $v) {
                $PHPExcel->getActiveSheet()->getStyle($alphas[$j] . $position)->applyFromArray(
                    array(
                        'font' => array(
                            'color' => array('rgb' => '000000'),
                            'name' => 'Calibri',
                            'bold' => false,
                            'italic' => false,
                            'size' => 10
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'wrap' => true
                        )
                    )
                );
                $j++;
            }
            $position++;
        }

        /* Rename title */
        $PHPExcel->getActiveSheet()->setTitle('Products List');

        /* Khởi tạo chỉ mục ở đầu sheet */
        $PHPExcel->setActiveSheetIndex(0);

        /* Xuất file */
        $time = time();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="products_' . $time . '_' . date('d_m_Y') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit();
    } else {
        $func->transfer("Dữ liệu rỗng", "index.php?com=export&act=man&type=" . $type, false);
    }
}
