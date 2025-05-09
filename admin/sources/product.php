<?php
if (!defined('SOURCES')) die("Error");
/* Kiểm tra active product */
if (isset($config['product'])) {
    $arrCheck = array();
    foreach ($config['product'] as $k => $v) $arrCheck[] = $k;
    if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
} else {
    $func->transfer("Trang không tồn tại", "index.php", false);
}
/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_list', 'id_cat', 'id_item', 'id_sub', 'id_brand');
if (isset($_POST['data'])) {
    $dataUrl = isset($_POST['data']) ? $_POST['data'] : null;
    if ($dataUrl) {
        foreach ($arrUrl as $k => $v) {
            if (isset($dataUrl[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($dataUrl[$arrUrl[$k]]);
        }
    }
} else {
    foreach ($arrUrl as $k => $v) {
        if (isset($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
    }
    if (!empty($_REQUEST['comment_status'])) $strUrl .= "&comment_status=" . htmlspecialchars($_REQUEST['comment_status']);
    if (isset($_REQUEST['keyword'])) $strUrl .= "&keyword=" . htmlspecialchars($_REQUEST['keyword']);
}
switch ($act) {
        /* Man */
    case "man":
        viewMans();
        $template = "product/man/mans";
        break;
    case "add":
        $template = "product/man/man_add";
        break;
    case "edit":
    case "copy":
        if ((!isset($config['product'][$type]['copy']) || $config['product'][$type]['copy'] == false) && $act == 'copy') {
            $template = "404";
            return false;
        }
        editMan();
        $template = "product/man/man_add";
        break;
    case "save":
    case "save_copy":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;
        /* Size */
    case "man_size":
        viewSizes();
        $template = "product/size/sizes";
        break;
    case "add_size":
        $template = "product/size/size_add";
        break;
    case "edit_size":
        editSize();
        $template = "product/size/size_add";
        break;
    case "save_size":
        saveSize();
        break;
    case "delete_size":
        deleteSize();
        break;
        /* Color */
    case "man_color":
        viewColors();
        $template = "product/color/colors";
        break;
    case "add_color":
        $template = "product/color/color_add";
        break;
    case "edit_color":
        editColor();
        $template = "product/color/color_add";
        break;
    case "save_color":
        saveColor();
        break;
    case "delete_color":
        deleteColor();
        break;
        /* Brand */
    case "man_brand":
        viewBrands();
        $template = "product/brand/brand";
        break;
    case "add_brand":
        $template = "product/brand/brand_add";
        break;
    case "edit_brand":
        editBrand();
        $template = "product/brand/brand_add";
        break;
    case "save_brand":
        saveBrand();
        break;
    case "delete_brand":
        deleteBrand();
        break;
        /* List */
    case "man_list":
        viewLists();
        $template = "product/list/lists";
        break;
    case "add_list":
        $template = "product/list/list_add";
        break;
    case "edit_list":
        editList();
        $template = "product/list/list_add";
        break;
    case "save_list":
        saveList();
        break;
    case "delete_list":
        deleteList();
        break;
        /* Cat */
    case "man_cat":
        viewCats();
        $template = "product/cat/cats";
        break;
    case "add_cat":
        $template = "product/cat/cat_add";
        break;
    case "edit_cat":
        editCat();
        $template = "product/cat/cat_add";
        break;
    case "save_cat":
        saveCat();
        break;
    case "delete_cat":
        deleteCat();
        break;
        /* Item */
    case "man_item":
        viewItems();
        $template = "product/item/items";
        break;
    case "add_item":
        $template = "product/item/item_add";
        break;
    case "edit_item":
        editItem();
        $template = "product/item/item_add";
        break;
    case "save_item":
        saveItem();
        break;
    case "delete_item":
        deleteItem();
        break;
        /* Sub */
    case "man_sub":
        viewSubs();
        $template = "product/sub/subs";
        break;
    case "add_sub":
        $template = "product/sub/sub_add";
        break;
    case "edit_sub":
        editSub();
        $template = "product/sub/sub_add";
        break;
    case "save_sub":
        saveSub();
        break;
    case "delete_sub":
        deleteSub();
        break;
        /* Gallery */
    case "man_photo":
    case "add_photo":
    case "edit_photo":
    case "save_photo":
    case "delete_photo":
        include "gallery.php";
        break;
    default:
        $template = "404";
}
/* View man */
function viewMans()
{
    global $d, $func, $comment, $strUrl, $curPage, $items, $paging, $type;
    $where = "";
    $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
    $iditem = (isset($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;
    $idsub = (isset($_REQUEST['id_sub'])) ? htmlspecialchars($_REQUEST['id_sub']) : 0;
    $idbrand = (isset($_REQUEST['id_brand'])) ? htmlspecialchars($_REQUEST['id_brand']) : 0;
    $comment_status = (!empty($_REQUEST['comment_status'])) ? htmlspecialchars($_REQUEST['comment_status']) : '';
    if ($idlist) $where .= " and id_list=$idlist";
    if ($idcat) $where .= " and id_cat=$idcat";
    if ($iditem) $where .= " and id_item=$iditem";
    if ($idsub) $where .= " and id_sub=$idsub";
    if ($idbrand) $where .= " and id_brand=$idbrand";
    if ($comment_status == 'new') {
        $comment = $d->rawQuery("select distinct id_variant from #_comment where type = ? and find_in_set('new-admin',status)", array($type));
        $idcomment = (!empty($comment)) ? $func->joinCols($comment, 'id_variant') : 0;
        $where .= " and id in ($idcomment)";
    }
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_product where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man" . $strUrl . "&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
    /* Comment */
    $comment = new Comments($d, $func);
}
/* Edit man */
function editMan()
{
    global $d, $func, $strUrl, $curPage, $item, $gallery, $type, $com, $act;
    if (!empty($_GET['id'])) $id = htmlspecialchars($_GET['id']);
    else if (!empty($_GET['id_copy'])) $id = htmlspecialchars($_GET['id_copy']);
    else $id = 0;
    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_product where id = ? and type = ? limit 0,1", array($id, $type));
        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
        } else {
            if ($act != 'copy') {
                /* Get gallery */
                $gallery = $d->rawQuery("select * from #_gallery where id_parent = ? and com = ? and type = ? and kind = ? and val = ? order by numb,id desc", array($id, $com, $type, 'man', $type));
            }
        }
    }
}
/* Save man */
function saveMan()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com, $act, $type, $configBase, $setting;
    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
    $id_opt = (isset($id)) ? htmlspecialchars($id) : 0;
    $row_opt = $d->rawQueryOne("select id, options from #_product where id = ? and type = ? limit 0,1",array($id_opt, $type));
    $option = json_decode($row_opt['options'],true);

    $row_opt2 = $d->rawQueryOne("select id, options2 from #_product where id = ? and type = ? limit 0,1",array($id_opt, $type));
    $option2 = json_decode($row_opt2['options2'],true);
    /* Post dữ liệu */
    $message = '';
    $response = array();
    $savehere = (isset($_POST['save-here'])) ? true : false;
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    $dataTags = (!empty($_POST['dataTags'])) ? $_POST['dataTags'] : null;
    $dataColor = (!empty($_POST['dataColor'])) ? $_POST['dataColor'] : null;
    $dataSize = (!empty($_POST['dataSize'])) ? $_POST['dataSize'] : null;
    $buildSchema = (!empty($_POST['build-schema'])) ? true : false;
    if ($data) {
        if($_POST['code']) {
            foreach ($_POST['code'] as $key => $value) {
                $dataVariants = array();
                $dataVariants['id_parent'] = (!empty($_POST['id_parent'.$value])) ? $_POST['id_parent'.$value] : 0;
                $dataVariants['color'] = ($_POST['color'.$value]) ? $_POST['color'.$value] : 0;
                $var_check = $d->rawQueryOne("select id,photo from table_variants_color where id_parent = ? and color = ? limit 0,1",array($_POST['id_parent'.$value], $_POST['color'.$value]));
                if($var_check) {
                    $file_name = $func->uploadName($_FILES["photo".$value]["name"]);
                    if($photo = $func->uploadImage("photo".$value, $config['product'][$type]['img_type'], UPLOAD_PRODUCT, $file_name))
                    {
                        if(!empty($var_check))
                        {
                            $func->deleteFile(UPLOAD_PRODUCT.$var_check['photo']);
                        }
                        $dataVariants['photo'] = $photo;
                    }
                }
                else {
                    $file_name = $func->uploadName($_FILES["photo".$value]["name"]);
                    if($photo = $func->uploadImage("photo".$value, $config['product'][$type]['img_type'], UPLOAD_PRODUCT, $file_name))
                    {
                        $dataVariants['photo'] = $photo;
                    }
                }
                if($var_check) {
                    $d->where('id', $var_check['id']);
                    $d->update('variants_color', $dataVariants);
                }
                else {
                    $d->insert('variants_color', $dataVariants);
                }
            }
        }

        if($_POST['code1']) {
            foreach ($_POST['code1'] as $key => $value1) {
                $dataVariants1 = array();
                $dataVariants1['id_parent'] = ($_POST['id_parent'.$value1]) ? $_POST['id_parent'.$value1] : 0;
                $dataVariants1['size'] = ($_POST['size'.$value1]) ? $_POST['size'.$value1] : 0;
                $var_check1 = $d->rawQueryOne("select id,price_new from table_variants_size where id_parent = ? and size = ? limit 0,1",array($_POST['id_parent'.$value1], $_POST['size'.$value1]));
                $dataVariants1['price_new'] = ($_POST['price_new'.$value1]) ? str_replace(',', '', $_POST['price_new'.$value1]) : 0;
                $dataVariants1['price_old'] = ($_POST['price_old'.$value1]) ? str_replace(',', '', $_POST['price_old'.$value1]) : 0;
                if($var_check1) {
                    $d->where('id', $var_check1['id']);
                    $d->update('variants_size', $dataVariants1);
                }
                else {
                    $d->insert('variants_size', $dataVariants1);
                }
            }
        }
       
        foreach ($data as $column => $value) { 
            if(is_array($value))
            {
                foreach($value as $k2 => $v2) $option[$k2] = $v2;
                $data[$column] = json_encode($option);

                foreach($value as $k2 => $v2) $option2[$k2] = $v2;
                $data[$column] = json_encode($option2);
            }
            else
            {
                if (strpos($column, 'content') !== false || strpos($column, 'desc') !== false) {
                    $data[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
                } else {
                    $data[$column] = htmlspecialchars($func->sanitize($value));
                }
            }
        }
        if (!empty($config['product'][$type]['slug'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }
        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }
        $data['regular_price'] = (isset($data['regular_price']) && $data['regular_price'] != '') ? str_replace(",", "", $data['regular_price']) : 0;
        $data['sale_price'] = (isset($data['sale_price']) && $data['sale_price'] != '') ? str_replace(",", "", $data['sale_price']) : 0;
        $data['discount'] = (isset($data['discount']) && $data['discount'] != '') ? $data['discount'] : 0;
        $data['type'] = $type;
        $data['color'] = ($_POST['dataColor']!='') ? implode(',', $_POST['dataColor']) : '';
        $data['size'] = ($_POST['dataSize']!='') ? implode(',', $_POST['dataSize']) : '';
    }
    /* Post seo */
    if (isset($config['product'][$type]['seo']) && $config['product'][$type]['seo'] == true) {
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
    if (!empty($config['product'][$type]['slug'])) {
        foreach ($config['website']['slug'] as $k => $v) {
            $dataSlug = array();
            $dataSlug['slug'] = $data['slug' . $k];
            $dataSlug['id'] = $id;
            $dataSlug['copy'] = ($act == 'save_copy') ? true : false;
            $checkSlug = $func->checkSlug($dataSlug);
            if ($checkSlug == 'exist') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') đã tồn tại';
            } else if ($checkSlug == 'empty') {
                $response['messages'][] = 'Đường dẫn (' . $v . ') không được trống';
            }
        }
    }
    if (!empty($data['regular_price']) && !$func->isNumber($data['regular_price'])) {
        $response['messages'][] = 'Giá bán không hợp lệ';
    }
    if (!empty($data['sale_price']) && !$func->isNumber($data['sale_price'])) {
        $response['messages'][] = 'Giá mới không hợp lệ';
    }
    if (!empty($data['discount']) && !$func->isNumber($data['discount'])) {
        $response['messages'][] = 'Chiết khấu không hợp lệ';
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
        if ($id || $act == 'save_copy') {
            if ($act == 'save_copy') {
                $func->redirect("index.php?com=product&act=copy&type=" . $type . "&p=" . $curPage . $strUrl . "&id_copy=" . $id);
            } else {
                $func->redirect("index.php?com=product&act=edit&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
            }
        } else {
            $func->redirect("index.php?com=product&act=add&type=" . $type . "&p=" . $curPage . $strUrl);
        }
    }
    /* Save data */
    if ($id && $act != 'save_copy') {
        $data['date_updated'] = time();
        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('product', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product where id = ? and type = ? limit 0,1", array($id, $type));
                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2 */
                if($func->hasFile("file2"))
                {
                    $photoUpdate2 = array();
                    $file_name2 = $func->uploadName($_FILES["file2"]["name"]);
                    
                    if($photo2 = $func->uploadImage("file2", $config['product'][$type]['img_type'], UPLOAD_PRODUCT, $file_name2))
                    {
                        $row = $d->rawQueryOne("select id, photo2 from #_product where id = ? and type = ? limit 0,1",array($id,$type));

                        if(!empty($row))
                        {
                            $func->deleteFile(UPLOAD_PRODUCT.$row['photo2']);
                        }

                        $photoUpdate2['photo2'] = $photo2;
                        $d->where('id', $id);
                        $d->update('product', $photoUpdate2);
                        unset($photoUpdate2);
                    }
                }

            /* SEO */
            if (isset($config['product'][$type]['seo']) && $config['product'][$type]['seo'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man', $type));
                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            /* Schema */
            if (isset($config['product'][$type]['schema']) && $config['product'][$type]['schema'] == true) {
                if ($buildSchema) {
                    foreach ($config['website']['seo'] as $k => $v) {
                        $proList = $d->rawQueryOne("select id,name$k from #_product_list where id = ? and type = ? limit 0,1", array($data['id_list'], $type));
                        $nameProList = (!empty($proList['name' . $k])) ? $proList['name' . $k] : '';
                        if ($k == 'vi' || $k == 'en') {
                            $url_pro = $configBase . $data['slug' . $k];
                        } else {
                            $url_pro = $configBase . $data['slugvi'];
                        }
                        if (!empty($data['photo'])) {
                            $url_img_pro = $configBase . UPLOAD_PRODUCT_L . $data['photo'];
                        } else {
                            $img_pro = $d->rawQueryOne("select id, photo from #_product where id = ? and type = ? limit 0,1", array($id, $type));
                            $url_img_pro = $configBase . UPLOAD_PRODUCT_L . $img_pro['photo'];
                        }
                        $data['code'] = (!empty($data['code'])) ? $data['code'] : '0';
                        $dataSchema['schema' . $k] = $func->buildSchemaProduct($id, $data['name' . $k], $url_img_pro, $dataSeo['description' . $k], $data['code'], $nameProList, $setting['name' . $k], $url_pro, $data['regular_price']);
                    }
                } else {
                    $dataSchema = (isset($_POST['dataSchema'])) ? $_POST['dataSchema'] : null;
                    if ($dataSchema) {
                        foreach ($dataSchema as $column => $value) {
                            $dataSchema[$column] = htmlspecialchars($value);
                        }
                    }
                }
                $d->where('id_parent', $id);
                $d->where('com', $com);
                $d->where('act', 'man');
                $d->where('type', $type);
                $d->update('seo', $dataSchema);
            }
            /* Tags */
            if (isset($config['product'][$type]['tags']) && $config['product'][$type]['tags'] == true) {
                if ($dataTags) {
                    $d->rawQuery("delete from #_product_tags where id_parent = ?", array($id));
                    foreach ($dataTags as $v) {
                        $dataTag = array();
                        $dataTag['id_parent'] = $id;
                        $dataTag['id_tags'] = $v;
                        $d->insert('product_tags', $dataTag);
                    }
                } else {
                    $d->rawQuery("delete from #_product_tags where id_parent = ?", array($id));
                }
            }

        if(CARTSITEADVANCE==true){
           
            /* Size - Color Giỏ Hàng Nâng Cao */
            /* Color */
            
            if(!empty($config['product'][$type]['color']))
            {
                if(!empty($dataColor))
                {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_color';
                    $dataSale1['data'] = $dataColor;
                }

                if(!empty($dataSale1['data']))
                {
                    $d->rawQuery("delete from #_product_sale_color where id_parent = ?",array($id));

                    foreach($dataSale1['data'] as $v_sale1)
                    {
                        $dataSale = array();
                        $dataSale['id_parent'] = $id;
                        $dataSale[$dataSale1['id']] = $v_sale1;
                        $d->insert('product_sale_color',$dataSale);
                    }
                }
                else
                {
                    $d->rawQuery("delete from #_product_sale_color where id_parent = ?",array($id));
                }
            }
            /* Size */
            if(!empty($config['product'][$type]['size']))
            {
                if(!empty($dataSize))
                {
                    $dataSale2 = array();
                    $dataSale2['id'] = 'id_size';
                    $dataSale2['data'] = $dataSize;
                }

                
                if(!empty($dataSale2['data']))
                {
                    $d->rawQuery("delete from #_product_sale_size where id_parent = ?",array($id));

                    foreach($dataSale2['data'] as $v_sale1)
                    {
                        $dataSale = array();
                        $dataSale['id_parent'] = $id;
                        $dataSale[$dataSale2['id']] = $v_sale1;
                        $d->insert('product_sale_size',$dataSale);
                    }
                }
                else
                {
                    $d->rawQuery("delete from #_product_sale where id_parent = ?",array($id));
                }
            }
        
        }else{ // giỏ hàng size màu cơ bản

            /* Sale */ 
            /* Nếu không dùng giỏ hàng nâng cao thì mở phần này đóng phần Size - Color Giỏ Hàng Nâng Cao*/
            if (!empty($config['product'][$type]['color']) || !empty($config['product'][$type]['size'])) {
                if (!empty($dataColor) && !empty($dataSize)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_color';
                    $dataSale1['data'] = $dataColor;
                    $dataSale2 = array();
                    $dataSale2['id'] = 'id_size';
                    $dataSale2['data'] = $dataSize;
                } else if (!empty($dataColor)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_color';
                    $dataSale1['data'] = $dataColor;
                } else if (!empty($dataSize)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_size';
                    $dataSale1['data'] = $dataSize;
                }
                if (!empty($dataSale1['data']) || !empty($dataSale2['data'])) {
                    $d->rawQuery("delete from #_product_sale where id_parent = ?", array($id));
                    foreach ($dataSale1['data'] as $v_sale1) {
                        $dataSale = array();
                        $dataSale['id_parent'] = $id;
                        $dataSale[$dataSale1['id']] = $v_sale1;
                        if (!empty($dataSale2['data'])) {
                            foreach ($dataSale2['data'] as $v_sale2) {
                                $dataSale[$dataSale2['id']] = $v_sale2;
                                $d->insert('product_sale', $dataSale);
                            }
                        } else {
                            $d->insert('product_sale', $dataSale);
                        }
                    }
                } else {
                    $d->rawQuery("delete from #_product_sale where id_parent = ?", array($id));
                }
            } 
            
           } // giỏ hàng cơ bản
        
            if ($savehere || $buildSchema) {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=edit&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
            } else {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
            }
        } else {
            if ($savehere) {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=edit&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
            }
        }
    } else {
        $data['date_created'] = time();
        /*lay stt*/
        /*$sott = $d->rawQuery("select numb from #_product where type = ? order by numb desc ",array($type));
        $sottmoi = $sott[0]['numb']+1;*/
        if ($d->insert('product', $data)) {
            $id_insert = $d->getLastInsertId();
            /*update stt*/
            //$d->rawQuery("update #_product set numb = ? where id = ".$id_insert,array($sottmoi));
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            /* Photo */
                if($func->hasFile("file2"))
                {
                    $photoUpdate2 = array();
                    $file_name2 = $func->uploadName($_FILES['file2']["name"]);

                    if($photo2 = $func->uploadImage("file2", $config['product'][$type]['img_type'], UPLOAD_PRODUCT, $file_name2))
                    {
                        $photoUpdate2['photo2'] = $photo2;
                        $d->where('id', $id_insert);
                        $d->update('product', $photoUpdate2);
                        unset($photoUpdate2);
                    }
                }
            /* SEO */
            if (isset($config['product'][$type]['seo']) && $config['product'][$type]['seo'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            /* Schema */
            if (isset($config['product'][$type]['schema']) && $config['product'][$type]['schema'] == true) {
                if ($buildSchema) {
                    foreach ($config['website']['seo'] as $k => $v) {
                        $pro_list = $d->rawQueryOne("select id,name$k from #_product_list where id = ? and type = ? limit 0,1", array($data['id_list'], $type));
                        if ($k == 'vi' || $k == 'en') {
                            $url_pro = $configBase . $data['slug' . $k];
                        } else {
                            $url_pro = $configBase . $data['slugvi'];
                        }
                        if (!empty($photo)) {
                            $url_img_pro = $configBase . UPLOAD_PRODUCT_L . $photo;
                        } else {
                            $img_pro = $d->rawQueryOne("select id, photo from #_product where id = ? and type = ? limit 0,1", array($id, $type));
                            $url_img_pro = $configBase . UPLOAD_PRODUCT_L . $img_pro['photo'];
                        }
                        $data['code'] = (!empty($data['code'])) ? $data['code'] : '0';
                        $dataSchema['schema' . $k] = $func->buildSchemaProduct($id, $data['name' . $k], $url_img_pro, $dataSeo['description' . $k], $data['code'], $pro_list['name' . $k], $setting['name' . $k], $url_pro, $data['regular_price']);
                    }
                } else {
                    $dataSchema = (!empty($_POST['dataSchema'])) ? $_POST['dataSchema'] : null;
                    if ($dataSchema) {
                        foreach ($dataSchema as $column => $value) {
                            $dataSchema[$column] = htmlspecialchars($value);
                        }
                    }
                }
                $d->where('id_parent', $id_insert);
                $d->where('com', $com);
                $d->where('act', 'man');
                $d->where('type', $type);
                $d->update('seo', $dataSchema);
            }
            /* Tags */
            if (isset($config['product'][$type]['tags']) && $config['product'][$type]['tags'] == true) {
                if ($dataTags) {
                    foreach ($dataTags as $v) {
                        $dataTag = array();
                        $dataTag['id_parent'] = $id_insert;
                        $dataTag['id_tags'] = $v;
                        $d->insert('product_tags', $dataTag);
                    }
                }
            }

        if(CARTSITEADVANCE==true){
            /* Size - Color Giỏ Hàng Nâng Cao */
            /* Color */
            if(!empty($config['product'][$type]['color']))
            {
                if(!empty($dataColor))
                {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_color';
                    $dataSale1['data'] = $dataColor;
                }

                if(!empty($dataSale1['data']))
                {
                    foreach($dataSale1['data'] as $v_sale1)
                    {
                        $dataSale = array();
                        $dataSale['id_parent'] = $id_insert;
                        $dataSale[$dataSale1['id']] = $v_sale1;
                        $d->insert('product_sale_color',$dataSale);
                    }
                }
            }
             /* Size */
            if(!empty($config['product'][$type]['size']))
            {
                if(!empty($dataSize))
                {
                    $dataSale2 = array();
                    $dataSale2['id'] = 'id_size';
                    $dataSale2['data'] = $dataSize;
                }

                if(!empty($dataSale2['data']))
                {
                    foreach($dataSale2['data'] as $v_sale1)
                    {
                        $dataSale = array();
                        $dataSale['id_parent'] = $id_insert;
                        $dataSale[$dataSale2['id']] = $v_sale1;
                        $d->insert('product_sale_size',$dataSale);
                    }
                }
            }
            
        }else{ // giỏ hang cơ bản
            /* Sale Size - Color*/
            /* Nếu không dùng giỏ hàng nâng cao thì mở phần này đóng phần Size - Color Giỏ Hàng Nâng Cao*/
            if (!empty($config['product'][$type]['color']) || !empty($config['product'][$type]['size'])) {
                if (!empty($dataColor) && !empty($dataSize)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_color';
                    $dataSale1['data'] = $dataColor;
                    $dataSale2 = array();
                    $dataSale2['id'] = 'id_size';
                    $dataSale2['data'] = $dataSize;
                } else if (!empty($dataColor)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_color';
                    $dataSale1['data'] = $dataColor;
                } else if (!empty($dataSize)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_size';
                    $dataSale1['data'] = $dataSize;
                }
                if (!empty($dataSale1['data']) || !empty($dataSale2['data'])) {
                    foreach ($dataSale1['data'] as $v_sale1) {
                        $dataSale = array();
                        $dataSale['id_parent'] = $id_insert;
                        $dataSale[$dataSale1['id']] = $v_sale1;
                        if (!empty($dataSale2['data'])) {
                            foreach ($dataSale2['data'] as $v_sale2) {
                                $dataSale[$dataSale2['id']] = $v_sale2;
                                $d->insert('product_sale', $dataSale);
                            }
                        } else {
                            $d->insert('product_sale', $dataSale);
                        }
                    }
                }
            }
            
           } // end gio hang co ban

            /* Cập nhật hash khi upload multi */
            $hash = (isset($_POST['hash']) && $_POST['hash'] != '') ? addslashes($_POST['hash']) : null;
            if ($hash) {
                $d->rawQuery("update #_gallery set hash = ?, id_parent = ? where hash = ?", array('', $id_insert, $hash));
            }
            if ($act == 'save_copy' || $buildSchema) {
                if ($savehere) {
                    $func->transfer("Sao chép dữ liệu thành công", "index.php?com=product&act=edit&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id_insert);
                } else {
                    $func->transfer("Sao chép dữ liệu thành công", "index.php?com=product&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
                }
            } else {
                if ($savehere || $buildSchema) {
                    $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=edit&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id_insert);
                } else {
                    $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
                }
            }
        } else {
            if ($act == 'save_copy') {
                $func->transfer("Sao chép dữ liệu bị lỗi", "index.php?com=product&act=copy&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=copy&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id, false);
            }
        }
    }
}
/* Delete man */
function deleteMan()
{
    global $d, $strUrl, $func, $curPage, $com, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_product where id = ? and type = ? limit 0,1", array($id, $type));
        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
            $d->rawQuery("delete from #_product where id = ?", array($id));
            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man', $type));
            /* Xóa Tags */
            $d->rawQuery("delete from #_product_tags where id_parent = ?", array($id));
            /* Xóa Sale */
            $d->rawQuery("delete from #_product_sale where id_parent = ?", array($id));
            /* Xóa gallery */
            $rowGallery = $d->rawQuery("select id, photo, file_attach from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man', $com));
            if (count($rowGallery)) {
                foreach ($rowGallery as $v) {
                    $func->deleteFile(UPLOAD_PRODUCT . $v['photo']);
                    $func->deleteFile(UPLOAD_FILE . $v['file_attach']);
                }
                $d->rawQuery("delete from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man', $com));
            }
            /* Xóa comment */
            $rowComment = $d->rawQuery("select id, id_parent from #_comment where id_variant = ? and type = ?", array($id, $type));
            if (!empty($rowComment)) {
                foreach ($rowComment as $v) {
                    if ($v['id_parent'] == 0) {
                        /* Xóa comment photo */
                        $rowCommentPhoto = $d->rawQuery("select photo from #_comment_photo where id_parent = ?", array($v['id']));
                        if (!empty($rowCommentPhoto)) {
                            /* Xóa image */
                            foreach ($rowCommentPhoto as $v_photo) {
                                $func->deleteFile(UPLOAD_PHOTO . $v_photo['photo']);
                            }
                            /* Xóa photo */
                            $d->rawQuery("delete from #_comment_photo where id_parent = ?", array($v['id']));
                        }
                        /* Xóa comment video */
                        $rowCommentVideo = $d->rawQueryOne("select photo, video from #_comment_video where id_parent = ? limit 0,1", array($v['id']));
                        if (!empty($rowCommentVideo)) {
                            $func->deleteFile(UPLOAD_PHOTO . $rowCommentVideo['photo']);
                            $func->deleteFile(UPLOAD_VIDEO . $rowCommentVideo['video']);
                            $d->rawQuery("delete from #_comment_video where id_parent = ?", array($v['id']));
                        }
                        /* Xóa child */
                        $d->rawQuery("delete from #_comment where id_parent = ? and type = ?", array($v['id'], $type));
                    }
                    /* Xóa comment main */
                    $d->rawQuery("delete from #_comment where id = ? and type = ?", array($v['id'], $type));
                }
            }
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_product where id = ? and type = ? limit 0,1", array($id, $type));
            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                $d->rawQuery("delete from #_product where id = ?", array($id));
                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man', $type));
                /* Xóa Tags */
                $d->rawQuery("delete from #_product_tags where id_parent = ?", array($id));
                /* Xóa Sale */
                $d->rawQuery("delete from #_product_sale where id_parent = ?", array($id));
                /* Xóa gallery */
                $rowGallery = $d->rawQuery("select id, photo, file_attach from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man', $com));
                if (count($rowGallery)) {
                    foreach ($rowGallery as $v) {
                        $func->deleteFile(UPLOAD_PRODUCT . $v['photo']);
                        $func->deleteFile(UPLOAD_FILE . $v['file_attach']);
                    }
                    $d->rawQuery("delete from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man', $com));
                }
                /* Xóa comment */
                $rowComment = $d->rawQuery("select id, id_parent from #_comment where id_variant = ? and type = ?", array($id, $type));
                if (!empty($rowComment)) {
                    foreach ($rowComment as $v) {
                        if ($v['id_parent'] == 0) {
                            /* Xóa comment photo */
                            $rowCommentPhoto = $d->rawQuery("select photo from #_comment_photo where id_parent = ?", array($v['id']));
                            if (!empty($rowCommentPhoto)) {
                                /* Xóa image */
                                foreach ($rowCommentPhoto as $v_photo) {
                                    $func->deleteFile(UPLOAD_PHOTO . $v_photo['photo']);
                                }
                                /* Xóa photo */
                                $d->rawQuery("delete from #_comment_photo where id_parent = ?", array($v['id']));
                            }
                            /* Xóa comment video */
                            $rowCommentVideo = $d->rawQueryOne("select photo, video from #_comment_video where id_parent = ? limit 0,1", array($v['id']));
                            if (!empty($rowCommentVideo)) {
                                $func->deleteFile(UPLOAD_PHOTO . $rowCommentVideo['photo']);
                                $func->deleteFile(UPLOAD_VIDEO . $rowCommentVideo['video']);
                                $d->rawQuery("delete from #_comment_video where id_parent = ?", array($v['id']));
                            }
                            /* Xóa child */
                            $d->rawQuery("delete from #_comment where id_parent = ? and type = ?", array($v['id'], $type));
                        }
                        /* Xóa comment main */
                        $d->rawQuery("delete from #_comment where id = ? and type = ?", array($v['id'], $type));
                    }
                }
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
}
/* View size */
function viewSizes()
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
    $sql = "select * from #_size where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_size where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_size&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit size */
function editSize()
{
    global $d, $func, $curPage, $item, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_size&type=" . $type . "&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from #_size where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_size&type=" . $type . "&p=" . $curPage, false);
        }
    }
}
/* Save size */
function saveSize()
{
    global $d, $func, $flash, $curPage, $config, $type;
    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_size&type=" . $type . "&p=" . $curPage, false);
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
        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }
        $data['type'] = $type;
    }
    /* Valid data */
    $checkTitle = $func->checkTitle($data);
    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
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
            $func->redirect("index.php?com=product&act=edit_size&type=" . $type . "&p=" . $curPage . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add_size&type=" . $type . "&p=" . $curPage);
        }
    }
    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('size', $data)) {
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_size&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_size&type=" . $type . "&p=" . $curPage, false);
        }
    } else {
        $data['date_created'] = time();
        if ($d->insert('size', $data)) {
            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_size&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_size&type=" . $type . "&p=" . $curPage, false);
        }
    }
}
/* Delete size */
function deleteSize()
{
    global $d, $func, $curPage, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if ($id) {
        $row = $d->rawQueryOne("select id from #_size where id = ? and type = ? limit 0,1", array($id, $type));
        if (!empty($row)) {
            $d->rawQuery("delete from #_size where id = ? and type = ?", array($id, $type));
            /* Xóa size in Sale */
            $d->rawQuery("delete from #_product_sale where id_size = ?", array($id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_size&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_size&type=" . $type . "&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id from #_size where id = ? and type = ? limit 0,1", array($id, $type));
            if (!empty($row)) {
                $d->rawQuery("delete from #_size where id = ? and type = ?", array($id, $type));
                /* Xóa size in Sale */
                $d->rawQuery("delete from #_product_sale where id_size = ?", array($id));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_size&type=" . $type . "&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_size&type=" . $type . "&p=" . $curPage, false);
    }
}
/* View color */
function viewColors()
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
    $sql = "select * from #_color where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_color where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_color&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit color */
function editColor()
{
    global $d, $func, $curPage, $item, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_color&type=" . $type . "&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from #_color where id = ? limit 0,1", array($id));
        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_color&type=" . $type . "&p=" . $curPage, false);
        }
    }
}
/* Save color */
function saveColor()
{
    global $d, $func, $flash, $curPage, $config, $type;
    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_color&type=" . $type . "&p=" . $curPage, false);
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
        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }
        $data['type'] = $type;
    }
    /* Valid data */
    $checkTitle = $func->checkTitle($data);
    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
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
            $func->redirect("index.php?com=product&act=edit_color&type=" . $type . "&p=" . $curPage . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add_color&type=" . $type . "&p=" . $curPage);
        }
    }
    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('color', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_color'], UPLOAD_COLOR, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_color where id = ? and type = ? limit 0,1", array($id, $type));
                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_COLOR . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('color', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_color&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_color&type=" . $type . "&p=" . $curPage, false);
        }
    } else {
        $data['date_created'] = time();
        if ($d->insert('color', $data)) {
            $id_insert = $d->getLastInsertId();
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_color'], UPLOAD_COLOR, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('color', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_color&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_color&type=" . $type . "&p=" . $curPage, false);
        }
    }
}
/* Delete color */
function deleteColor()
{
    global $d, $curPage, $func, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if ($id) {
        $row = $d->rawQueryOne("select * from #_color where id = ? and type = ? limit 0,1", array($id, $type));
        if (!empty($row)) {
            $func->deleteFile(UPLOAD_COLOR . $row['photo']);
            $d->rawQuery("delete from #_color where id = ?", array($id));
            /* Xóa color in Sale */
            $d->rawQuery("delete from #_product_sale where id_color = ?", array($id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_color&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_color&type=" . $type . "&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select * from #_color where id = ? and type = ? limit 0,1", array($id, $type));
            if (!empty($row)) {
                $func->deleteFile(UPLOAD_COLOR . $row['photo']);
                $d->rawQuery("delete from #_color where id = ?", array($id));
                /* Xóa color in Sale */
                $d->rawQuery("delete from #_product_sale where id_color = ?", array($id));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_color&type=" . $type . "&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_color&type=" . $type . "&p=" . $curPage, false);
    }
}
/* View list */
function viewLists()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $type;
    $where = "";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_list where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_product_list where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_list&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit list */
function editList()
{
    global $d, $func, $strUrl, $curPage, $item, $gallery, $type, $com;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_product_list where id = ? and type = ? limit 0,1", array($id, $type));
        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
        } else {
            /* Get gallery */
            $gallery = $d->rawQuery("select * from #_gallery where id_parent = ? and com = ? and type = ? and kind = ? and val = ? order by numb,id desc", array($id, $com, $type, 'man_list', $type));
        }
    }
}
/* Save list */
function saveList()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com, $type;
    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
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
        if (!empty($config['product'][$type]['slug_list'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }
        $data['type'] = $type;
    }
    /* Post seo */
    if (isset($config['product'][$type]['seo_list']) && $config['product'][$type]['seo_list'] == true) {
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
    if (!empty($config['product'][$type]['slug_list'])) {
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
            $func->redirect("index.php?com=product&act=edit_list&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add_list&type=" . $type . "&p=" . $curPage . $strUrl);
        }
    }
    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('product_list', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_list'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product_list where id = ? and type = ? limit 0,1", array($id, $type));
                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            /* SEO */
            if (isset($config['product'][$type]['seo_list']) && $config['product'][$type]['seo_list'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_list', $type));
                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_list';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();
        if ($d->insert('product_list', $data)) {
            $id_insert = $d->getLastInsertId();
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_list'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            /* SEO */
            if (isset($config['product'][$type]['seo_list']) && $config['product'][$type]['seo_list'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_list';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            /* Cập nhật hash khi upload multi */
            $hash = (isset($_POST['hash']) && $_POST['hash'] != '') ? addslashes($_POST['hash']) : null;
            if ($hash) {
                $d->rawQuery("update #_gallery set hash = ?, id_parent = ? where hash = ?", array('', $id_insert, $hash));
            }
            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}
/* Delete list */
function deleteList()
{
    global $d, $strUrl, $func, $curPage, $com, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_product_list where id = ? and type = ? limit 0,1", array($id, $type));
        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
            $d->rawQuery("delete from #_product_list where id = ?", array($id));
            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_list', $type));
            /* Xóa gallery */
            $row = $d->rawQuery("select id, photo, file_attach from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man_list', $com));
            if (count($row)) {
                foreach ($row as $v) {
                    $func->deleteFile(UPLOAD_PRODUCT . $v['photo']);
                    $func->deleteFile(UPLOAD_FILE . $v['file_attach']);
                }
                $d->rawQuery("delete from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man_list', $com));
            }
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_product_list where id = ? and type = ? limit 0,1", array($id, $type));
            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                $d->rawQuery("delete from #_product_list where id = ?", array($id));
                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_list', $type));
                /* Xóa gallery */
                $row = $d->rawQuery("select id, photo, file_attach from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man_list', $com));
                if (count($row)) {
                    foreach ($row as $v) {
                        $func->deleteFile(UPLOAD_PRODUCT . $v['photo']);
                        $func->deleteFile(UPLOAD_FILE . $v['file_attach']);
                    }
                    $d->rawQuery("delete from #_gallery where id_parent = ? and kind = ? and com = ?", array($id, 'man_list', $com));
                }
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
}
/* Get cat */
function viewCats()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $type;
    $where = "";
    $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    if ($idlist) $where .= " and id_list=$idlist";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_cat where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_product_cat where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_cat" . $strUrl . "&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit cat */
function editCat()
{
    global $d, $func, $strUrl, $curPage, $item, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_product_cat where id = ? and type = ? limit 0,1", array($id, $type));
        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}
/* Save cat */
function saveCat()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com, $type;
    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
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
        if (!empty($config['product'][$type]['slug_cat'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }
        $data['type'] = $type;
    }
    /* Post seo */
    if (isset($config['product'][$type]['seo_cat']) && $config['product'][$type]['seo_cat'] == true) {
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
    if (!empty($config['product'][$type]['slug_cat'])) {
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
            $func->redirect("index.php?com=product&act=edit_cat&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add_cat&type=" . $type . "&p=" . $curPage . $strUrl);
        }
    }
    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('product_cat', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_cat'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product_cat where id = ? and type = ? limit 0,1", array($id, $type));
                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product_cat', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            /* SEO */
            if (isset($config['product'][$type]['seo_cat']) && $config['product'][$type]['seo_cat'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_cat', $type));
                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_cat';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();
        if ($d->insert('product_cat', $data)) {
            $id_insert = $d->getLastInsertId();
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_cat'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product_cat', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            /* SEO */
            if (isset($config['product'][$type]['seo_cat']) && $config['product'][$type]['seo_cat'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_cat';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}
/* Delete cat */
function deleteCat()
{
    global $d, $strUrl, $func, $curPage, $com, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_product_cat where id = ? and type = ? limit 0,1", array($id, $type));
        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
            $d->rawQuery("delete from #_product_cat where id = ?", array($id));
            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_cat', $type));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_product_cat where id = ? and type = ? limit 0,1", array($id, $type));
            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                $d->rawQuery("delete from #_product_cat where id = ?", array($id));
                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_cat', $type));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_cat&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
}
/* View item */
function viewItems()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $type;
    $where = "";
    $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
    if ($idlist) $where .= " and id_list=$idlist";
    if ($idcat) $where .= " and id_cat=$idcat";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_item where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_product_item where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_item" . $strUrl . "&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit item */
function editItem()
{
    global $d, $func, $strUrl, $curPage, $item, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_product_item where id = ? and type = ? limit 0,1", array($id, $type));
        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}
/* Save item */
function saveItem()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com, $type;
    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
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
        if (!empty($config['product'][$type]['slug_item'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }
        $data['type'] = $type;
    }
    /* Post seo */
    if (isset($config['product'][$type]['seo_item']) && $config['product'][$type]['seo_item'] == true) {
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
    if (!empty($config['product'][$type]['slug_item'])) {
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
            $func->redirect("index.php?com=product&act=edit_item&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add_item&type=" . $type . "&p=" . $curPage . $strUrl);
        }
    }
    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('product_item', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_item'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product_item where id = ? and type = ? limit 0,1", array($id, $type));
                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product_item', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            /* SEO */
            if (isset($config['product'][$type]['seo_item']) && $config['product'][$type]['seo_item'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_item', $type));
                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_item';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();
        if ($d->insert('product_item', $data)) {
            $id_insert = $d->getLastInsertId();
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_item'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product_item', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            /* SEO */
            if (isset($config['product'][$type]['seo_item']) && $config['product'][$type]['seo_item'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_item';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}
/* Delete item */
function deleteItem()
{
    global $d, $strUrl, $func, $curPage, $com, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_product_item where id = ? and type = ? limit 0,1", array($id, $type));
        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
            $d->rawQuery("delete from #_product_item where id = ?", array($id));
            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_item', $type));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_product_item where id = ? and type = ? limit 0,1", array($id, $type));
            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                $d->rawQuery("delete from #_product_item where id = ?", array($id));
                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_item', $type));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
}
/* View sub */
function viewSubs()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $type;
    $where = "";
    $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
    $iditem = (isset($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;
    if ($idlist) $where .= " and id_list=$idlist";
    if ($idcat) $where .= " and id_cat=$idcat";
    if ($iditem) $where .= " and id_item=$iditem";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_sub where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_product_sub where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_sub" . $strUrl . "&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit sub */
function editSub()
{
    global $d, $func, $strUrl, $curPage, $item, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_product_sub where id = ? and type = ? limit 0,1", array($id, $type));
        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}
/* Save sub */
function saveSub()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com, $type;
    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
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
        if (!empty($config['product'][$type]['slug_sub'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }
        $data['type'] = $type;
    }
    /* Post seo */
    if (isset($config['product'][$type]['seo_sub']) && $config['product'][$type]['seo_sub'] == true) {
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
    if (!empty($config['product'][$type]['slug_sub'])) {
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
            $func->redirect("index.php?com=product&act=edit_sub&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add_sub&type=" . $type . "&p=" . $curPage . $strUrl);
        }
    }
    /* save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('product_sub', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_sub'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product_sub where id = ? and type = ? limit 0,1", array($id, $type));
                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product_sub', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            /* SEO */
            if (isset($config['product'][$type]['seo_sub']) && $config['product'][$type]['seo_sub'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_sub', $type));
                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_sub';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();
        if ($d->insert('product_sub', $data)) {
            $id_insert = $d->getLastInsertId();
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_sub'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product_sub', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            /* SEO */
            if (isset($config['product'][$type]['seo_sub']) && $config['product'][$type]['seo_sub'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_sub';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}
/* Delete sub */
function deleteSub()
{
    global $d, $strUrl, $func, $curPage, $com, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_product_sub where id = ? and type = ? limit 0,1", array($id, $type));
        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
            $d->rawQuery("delete from #_product_sub where id = ?", array($id));
            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_sub', $type));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_product_sub where id = ? and type = ? limit 0,1", array($id, $type));
            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                $d->rawQuery("delete from #_product_sub where id = ?", array($id));
                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_sub', $type));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_sub&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
}
/* View brand */
function viewBrands()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $type;
    $where = "";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_brand where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_product_brand where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_brand&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
/* Edit brand */
function editBrand()
{
    global $d, $func, $strUrl, $curPage, $item, $gallery, $type, $com;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_brand&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_product_brand where id = ? and type = ? limit 0,1", array($id, $type));
        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_brand&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}
/* Save brand */
function saveBrand()
{
    global $d, $curPage, $func, $flash, $config, $com, $type, $strUrl;
    /* Check post*/
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_brand&type=" . $type . "&p=" . $curPage, false);
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
        if (!empty($config['product'][$type]['slug_brand'])) {
            if (!empty($_POST['slugvi'])) $data['slugvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
            else $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            if (!empty($_POST['slugen'])) $data['slugen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
            else $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        }
        $data['type'] = $type;
    }
    /* Post seo */
    if (isset($config['product'][$type]['seo_brand']) && $config['product'][$type]['seo_brand'] == true) {
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
    if (!empty($config['product'][$type]['slug_brand'])) {
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
            $func->redirect("index.php?com=product&act=edit_brand&type=" . $type . "&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add_brand&type=" . $type . "&p=" . $curPage . $strUrl);
        }
    }
    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('product_brand', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_brand'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product_brand where id = ? and type = ? limit 0,1", array($id, $type));
                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product_brand', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            /* SEO */
            if (isset($config['product'][$type]['seo_brand']) && $config['product'][$type]['seo_brand'] == true) {
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_brand', $type));
                $dataSeo['id_parent'] = $id;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_brand';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_brand&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_brand&type=" . $type . "&p=" . $curPage, false);
        }
    } else {
        $data['date_created'] = time();
        if ($d->insert('product_brand', $data)) {
            $id_insert = $d->getLastInsertId();
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);
                if ($photo = $func->uploadImage("file", $config['product'][$type]['img_type_brand'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product_brand', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            /* SEO */
            if (isset($config['product'][$type]['seo_brand']) && $config['product'][$type]['seo_brand'] == true) {
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['com'] = $com;
                $dataSeo['act'] = 'man_brand';
                $dataSeo['type'] = $type;
                $d->insert('seo', $dataSeo);
            }
            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_brand&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_brand&type=" . $type . "&p=" . $curPage, false);
        }
    }
}
/* Delete brand */
function deleteBrand()
{
    global $d, $strUrl, $func, $curPage, $com, $type;
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_product_brand where id = ? and type = ? limit 0,1", array($id, $type));
        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
            $d->rawQuery("delete from #_product_brand where id = ?", array($id));
            /* Xóa SEO */
            $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_brand', $type));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_brand&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_brand&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);
        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_product_brand where id = ? and type = ? limit 0,1", array($id, $type));
            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                $d->rawQuery("delete from #_product_brand where id = ?", array($id));
                /* Xóa SEO */
                $d->rawQuery("delete from #_seo where id_parent = ? and com = ? and act = ? and type = ?", array($id, $com, 'man_brand', $type));
            }
        }
        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_brand&type=" . $type . "&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_brand&type=" . $type . "&p=" . $curPage . $strUrl, false);
    }
}