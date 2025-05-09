<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active import */
if (isset($config['product'])) {
    $arrCheck = array();
    foreach ($config['product'] as $k => $v) if (isset($v['import']) && $v['import'] == true) $arrCheck[] = $k;
    if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
} else {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

switch ($act) {
    case "man":
        getImages();
        $template = "import/man/mans";
        break;
    case "uploadImages":
        uploadImages();
        break;
    case "editImages":
        editImages();
        $template = "import/man/man_edit";
        break;
    case "saveImages":
        saveImages();
        break;
    case "deleteImages":
        deleteImages();
        break;
    case "uploadExcel":
        uploadExcel();
        break;
    default:
        $template = "404";
}

/* Get image */
function getImages()
{
    global $d, $func, $type, $curPage, $items, $paging;

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_excel where type = ? order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_excel where type = ? order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=import&act=man&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit image */
function editImages()
{
    global $d, $func, $item, $type, $curPage;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=import&act=man&type=" . $type . "&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from #_excel where id = ? and type = ? limit 0,1", array($id, $type));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=import&act=man&type=" . $type . "&p=" . $curPage, false);
        }
    }
}

/* Save image */
function saveImages()
{
    global $d, $item, $func, $type, $curPage, $config;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=import&act=man&type=" . $type . "&p=" . $curPage, false);
    }

    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

    if ($id) {
        if ($func->hasFile("file")) {
            $file_name = $func->uploadName($_FILES['file']["name"]);
            if ($photo = $func->uploadImage("file", $config['import']['img_type'], UPLOAD_EXCEL, $file_name)) {
                $data['photo'] = $photo;
                $row = $d->rawQueryOne("select id, photo from #_excel where id = ? and type = ? limit 0,1", array($id, $type));
                if (!empty($row)) $func->deleteFile(UPLOAD_EXCEL . $row['photo']);

                $d->where('id', $id);
                $d->where('type', $type);
                if ($d->update('excel', $data)) {
                    $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=import&act=man&type=" . $type . "&p=" . $curPage);
                } else {
                    $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=import&act=man&type=" . $type . "&p=" . $curPage, false);
                }
            } else {
                $func->transfer("Không nhận được hình ảnh mới", "index.php?com=import&act=editImages&id=" . $id . "&type=" . $type . "&p=" . $curPage, false);
            }
        } else {
            $func->transfer("Không nhận được hình ảnh mới", "index.php?com=import&act=editImages&id=" . $id . "&type=" . $type . "&p=" . $curPage, false);
        }
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=import&act=man&type=" . $type . "&p=" . $curPage, false);
    }
}

/* Upload image */
function uploadImages()
{
    global $d, $type, $func, $config;

    if (isset($_POST['uploadImg']) && isset($_FILES['files'])) {
        $str_remove = '';
        $arr_file_delete = array();

        if (isset($_POST['jfiler-items-exclude-files-0'])) {
            $str_remove = str_replace('"', '', $_POST['jfiler-items-exclude-files-0']);
            $str_remove = str_replace('[', '', $str_remove);
            $str_remove = str_replace(']', '', $str_remove);
            $str_remove = str_replace('\\', '', $str_remove);
            $str_remove = str_replace('0://', '', $str_remove);
            $arr_file_delete = explode(',', $str_remove);
        }

        $flagCount = 0;
        $myFile = $_FILES['files'];
        $fileCount = count($myFile["name"]);

        for ($i = 0; $i < $fileCount; $i++) {
            if (!in_array($myFile["name"][$i], $arr_file_delete, true)) {
                $data = array();
                $data['numb'] = (isset($_POST['numb-filer'][$flagCount]) && $_POST['numb-filer'][$flagCount] > 0) ? (int)$_POST['numb-filer'][$flagCount] : 0;
                $data['type'] = $type;

                if ($d->insert('excel', $data)) {
                    $id_insert = $d->getLastInsertId();

                    $_FILES['file'] = array('name' => $myFile['name'][$i], 'type' => $myFile['type'][$i], 'tmp_name' => $myFile['tmp_name'][$i], 'error' => $myFile['error'][$i], 'size' => $myFile['size'][$i]);

                    if ($func->hasFile("file")) {
                        $photoUpdate = array();
                        $file_name = $func->uploadName($myFile["name"][$i]);

                        if ($photo = $func->uploadImage("file", $config['import']['img_type'], UPLOAD_EXCEL, $file_name)) {
                            $photoUpdate['photo'] = $photo;
                            $d->where('id', $id_insert);
                            $d->update('excel', $photoUpdate);
                            unset($photoUpdate);
                        }
                    }
                } else {
                    $func->transfer("Lưu hình ảnh bị lỗi", "index.php?com=import&act=man&type=" . $type, false);
                }

                $flagCount++;
            }
        }

        $func->transfer("Lưu hình ảnh thành công", "index.php?com=import&act=man&type=" . $type);
    } else {
        $func->transfer("Dữ liệu rỗng", "index.php?com=import&act=man&type=" . $type, false);
    }
}

/* Delete image */
function deleteImages()
{
    global $d, $type, $func, $curPage;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id, photo from #_excel where id = ? and type = ? limit 0,1", array($id, $type));

        if (!empty($row)) {
            $func->deleteFile(UPLOAD_EXCEL . $row['photo']);
            $d->rawQuery("delete from #_excel where id = ? and type = ?", array($id, $type));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=import&act=man&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=import&act=man&type=" . $type . "&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id, photo from #_excel where id = ? and type = ? limit 0,1", array($id, $type));

            if (!empty($row)) {
                $func->deleteFile(UPLOAD_EXCEL . $row['photo']);
                $d->rawQuery("delete from #_excel where id = ? and type = ?", array($id, $type));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=import&act=man&type=" . $type . "&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=import&act=man&type=" . $type . "&p=" . $curPage, false);
    }
}

/* Transfer image */
function transferPhoto($photo)
{
    global $d;

    $oldpath = UPLOAD_EXCEL . $photo;
    $newpath = UPLOAD_PRODUCT . $photo;

    if (file_exists($oldpath)) {
        if (rename($oldpath, $newpath)) {
            $d->rawQuery("delete from #_excel where photo = ?", array($photo));
        }
    }
}

/* Upload excel */
function uploadExcel()
{
    global $d, $type, $func, $config;

    if (isset($_POST['importExcel'])) {
        $file_type = $_FILES['file-excel']['type'];

        if ($file_type == "application/vnd.ms-excel" || $file_type == "application/x-ms-excel" || $file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $mess = '';
            $filename = $func->changeTitle($_FILES["file-excel"]["name"]);
            move_uploaded_file($_FILES["file-excel"]["tmp_name"], $filename);

            require LIBRARIES . 'PHPExcel.php';
            require_once LIBRARIES . 'PHPExcel/IOFactory.php';

            $objPHPExcel = PHPExcel_IOFactory::load($filename);

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();

                for ($row = 2; $row <= $highestRow; ++$row) {
                    $cell = $worksheet->getCellByColumnAndRow(3, $row);
                    $code = $cell->getValue();

                    if ($code != "") {
                        $cell = $worksheet->getCellByColumnAndRow(0, $row);
                        $numb = $cell->getValue();

                        $cell = $worksheet->getCellByColumnAndRow(1, $row);
                        $level1 = $cell->getValue();

                        $cell = $worksheet->getCellByColumnAndRow(2, $row);
                        $level2 = $cell->getValue();

                        $cell = $worksheet->getCellByColumnAndRow(3, $row);
                        $code = $cell->getValue();

                        $cell = $worksheet->getCellByColumnAndRow(4, $row);
                        $namevi = $cell->getValue();

                        $cell = $worksheet->getCellByColumnAndRow(5, $row);
                        $regular_price = $cell->getValue();

                        $cell = $worksheet->getCellByColumnAndRow(6, $row);
                        $sale_price = $cell->getValue();

                        $cell = $worksheet->getCellByColumnAndRow(7, $row);
                        $discount = $cell->getValue();

                        $cell = $worksheet->getCellByColumnAndRow(8, $row);
                        $descvi = $cell->getValue();

                        $cell = $worksheet->getCellByColumnAndRow(9, $row);
                        $contentvi = $cell->getValue();

                        $cell = $worksheet->getCellByColumnAndRow(10, $row);
                        $photo = $cell->getValue();

                        /* Lấy sản phẩm theo mã */
                        $productImport = $d->rawQueryOne("select id, photo from #_product where code = ? limit 0,1", array($code));

                        /* Lấy danh mục cấp 1 */
                        $slug_level1 = (!empty($level1)) ? $func->changeTitle($level1) : '';
                        $idlist = $d->rawQueryOne("select id from #_product_list where slugvi = ? limit 0,1", array($slug_level1));

                        /* Lấy danh mục cấp 2 */
                        $slug_level2 = (!empty($level2)) ? $func->changeTitle($level2) : '';
                        $idcat = $d->rawQueryOne("select id from #_product_cat where slugvi = ? limit 0,1", array($slug_level2));

                        /* Gán dữ liệu */
                        $data = array();
                        $data['numb'] = (int)$numb;
                        $data['id_list'] = (int)$idlist['id'];
                        $data['id_cat'] = (int)$idcat['id'];
                        $data['code'] = (!empty($code)) ? htmlspecialchars($code) : '';
                        $data['namevi'] = (!empty($namevi)) ? htmlspecialchars($namevi) : '';
                        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
                        $data['regular_price'] = $regular_price;
                        $data['sale_price'] = $sale_price;
                        $data['discount'] = $discount;
                        $data['descvi'] = (!empty($descvi)) ? htmlspecialchars($descvi) : '';
                        $data['contentvi'] = (!empty($contentvi)) ? htmlspecialchars($contentvi) : '';

                        if (isset($config['import']['images']) && $config['import']['images'] == true) {
                            if ($photo != "") {
                                if (filter_var($photo, FILTER_VALIDATE_URL)) {
                                    /* Get Images Online */
                                    $random = $func->digitalRandom(0, 9, 12);
                                    $ext = substr(basename($photo), strrpos(basename($photo), ".") + 1);
                                    $tmp = explode('?', $ext);
                                    $ext = $tmp[0];
                                    $name = $random . "_online_img." . $ext;
                                    $pathOnlineImg = $photo;
                                    $pathSaveImg = UPLOAD_EXCEL . $name;
                                    $ch = curl_init($pathOnlineImg);
                                    $fp = fopen($pathSaveImg, 'wb');
                                    curl_setopt($ch, CURLOPT_FILE, $fp);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_exec($ch);
                                    curl_close($ch);
                                    fclose($fp);

                                    $data['photo'] = $name;
                                    $photo = $name;
                                } else {
                                    /* Get Images Local */
                                    $data['photo'] = $photo;
                                }
                            } else $data['photo'] = '';
                        } else {
                            $data['photo'] = '';
                        }
                        $data['type'] = $type;
                        $data['status'] = 'hienthi';

                        if (isset($productImport['id']) && $productImport['id'] > 0) {
                            $d->where('type', $type);
                            $d->where('code', $code);
                            if ($d->update('product', $data)) {
                                if (isset($config['import']['images']) && $config['import']['images'] == true) {
                                    /* Cập nhật hình */
                                    /* Nếu tồn tại hình mới thì xóa hình cũ và cập nhật hình mới */
                                    $oldPhoto = $productImport['photo'];
                                    if (($photo != "") && ($photo != $oldPhoto)) {
                                        /* Xóa hình cũ */
                                        $oldpathphoto = UPLOAD_PRODUCT . $oldPhoto;
                                        if (file_exists($oldpathphoto)) unlink($oldpathphoto);

                                        /* Chuyển hình mới từ thư mục excel sang thư mục cần chuyển */
                                        transferPhoto($photo);
                                    }
                                }
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        } else {
                            if ($d->insert('product', $data)) {
                                if (isset($config['import']['images']) && $config['import']['images'] == true) {
                                    /* Chuyển hình trong thư mục excel sang thư mục cần chuyển */
                                    if ($photo != "") transferPhoto($photo);
                                }
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        }
                    }
                }
            }

            /* Xóa tập tin sau khi đã import xong */
            unlink($filename);

            /* Kiểm tra kết quả import */
            if ($mess == '') {
                $mess = "Import danh sách thành công";
                $func->transfer($mess, "index.php?com=import&act=man&type=" . $type);
            } else {
                $func->transfer($mess, "index.php?com=import&act=man&type=" . $type, false);
            }
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "index.php?com=import&act=man&type=" . $type, false);
        }
    } else {
        $func->transfer("Dữ liệu rỗng", "index.php?com=import&act=man&type=" . $type, false);
    }
}
