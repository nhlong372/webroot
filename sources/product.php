<?php
if (!defined('SOURCES')) die("Error");
@$id = htmlspecialchars($_GET['id']);
@$idl = htmlspecialchars($_GET['idl']);
@$idc = htmlspecialchars($_GET['idc']);
@$idi = htmlspecialchars($_GET['idi']);
@$ids = htmlspecialchars($_GET['ids']);
@$idb = htmlspecialchars($_GET['idb']);
if($_REQUEST['sort']!='') {
    switch ($_REQUEST['sort']) {
        case 'ngaytao_desc':
            $order_by = "date_created desc";
            break;
        case 'price_asc':
            $order_by = "(case when sale_price < regular_price and sale_price !=0 then sale_price else regular_price end) asc";
            break;
        case 'price_desc':
            $order_by = "(case when sale_price < regular_price and sale_price !=0 then sale_price else regular_price end) desc";
            break;
        default:
            $order_by = 'numb,id desc';
            break;
    }
}
else {
    $order_by = 'numb,id desc';
}
if(isset($_REQUEST['filter_active']) and $_REQUEST['filter_active']==1) {
    if($_REQUEST['brand']!='') {
        $where_add .= " and CONCAT(',',id_brand, ',') REGEXP ',(".str_replace(',', '|', $_REQUEST['brand'])."),' ";
    }
    if($_REQUEST['size']!='') {
        $where_add .= " and CONCAT(',',size, ',') REGEXP ',(".str_replace(',', '|', $_REQUEST['size'])."),' ";
    }
    if($_REQUEST['color']!='') {
        $where_add .= " and CONCAT(',',color, ',') REGEXP ',(".str_replace(',', '|', $_REQUEST['color'])."),' ";
    }
}
if ($id != '') {
    /* Lấy sản phẩm detail */
    $rowDetail = $d->rawQueryOne("select type, id, name$lang, slugvi, slugen, desc$lang, content$lang, code, view, id_brand, id_list, id_cat, id_item, id_sub, photo, options, discount, sale_price, regular_price, options2 from #_product where id = ? and type = ? and find_in_set('hienthi',status) limit 0,1", array($id, $type));

    $active_lv1 = $rowDetail['id_list'];

    /* Sản phẩm đã xem */
    // if($rowDetail and $rowDetail['type'] == 'san-pham') {
    //     if(!isset($_COOKIE['recently_viewed'])) {
    //         $arr = array();
    //         array_push($arr, $rowDetail['id']);
    //         setcookie("recently_viewed", json_encode($arr), time() + (86400 * 30), "/");
    //     }
    //     else {
    //         $arr = json_decode($_COOKIE['recently_viewed'], true);
    //         if(!in_array($rowDetail['id'], $arr)) {
    //             array_push($arr, $rowDetail['id']);
    //             setcookie("recently_viewed", json_encode($arr), time() + (86400 * 30), "/");
    //         }
    //     }
    //     if(isset($_COOKIE['recently_viewed'])) {
    //         $sql = "select photo, name$lang, slugvi, slugen, sale_price, regular_price, discount, id from #_product where CONCAT(',',id, ',') REGEXP ',(".str_replace(',', '|', implode(',', json_decode($_COOKIE['recently_viewed'], true)) )."),' and find_in_set('hienthi',status) order by numb, id desc";
    //         $recently_viewed = $d->rawQuery($sql);
    //     }
    // }
    /* Cập nhật lượt xem */
    $views = array();
    $views['view'] = $rowDetail['view'] + 1;
    $d->where('id', $rowDetail['id']);
    $d->update('product', $views);
    /* Lấy tags */
    /*$productTags = $d->rawQuery("select id_tags from #_product_tags where id_parent = ?", array($rowDetail['id']));
    $productTags = (!empty($productTags)) ? $func->joinCols($productTags, 'id_tags') : array();
    if (!empty($productTags)) {
        $rowTags = $d->rawQuery("select id, name$lang, slugvi, slugen from #_tags where type='" . $type . "' and id in ($productTags) and find_in_set('hienthi',status) order by numb,id desc");
    }*/
if(CARTSITEADVANCE==true){ // giỏ hàng nâng cao
    /* Lấy màu */
    $productColor = $d->rawQuery("select id_color from #_product_sale_color where id_parent = ?", array($rowDetail['id']));
    $productColor = (!empty($productColor)) ? $func->joinCols($productColor, 'id_color') : array();
    if (!empty($productColor)) {
        $rowColor = $d->rawQuery("select type_show, photo, color, id, name$lang from #_color where type='" . $type . "' and id in ($productColor) and find_in_set('hienthi',status) order by numb,id desc");
    }
    /* Lấy size */
    $productSize = $d->rawQuery("select id_size from #_product_sale_size where id_parent = ?", array($rowDetail['id']));
    $productSize = (!empty($productSize)) ? $func->joinCols($productSize, 'id_size') : array();
    if (!empty($productSize)) {
        $rowSize = $d->rawQuery("select id, name$lang from #_size where type='" . $type . "' and id in ($productSize) and find_in_set('hienthi',status) order by numb,id desc");
    }

}else{ // gio hang co ban

    /* Lấy màu */
    $productColor = $d->rawQuery("select id_color from #_product_sale where id_parent = ?", array($rowDetail['id']));
    $productColor = (!empty($productColor)) ? $func->joinCols($productColor, 'id_color') : array();
    if (!empty($productColor)) {
        $rowColor = $d->rawQuery("select type_show, photo, color, id, name$lang from #_color where type='" . $type . "' and id in ($productColor) and find_in_set('hienthi',status) order by numb,id desc");
    }
    /* Lấy size */
    $productSize = $d->rawQuery("select id_size from #_product_sale where id_parent = ?", array($rowDetail['id']));
    $productSize = (!empty($productSize)) ? $func->joinCols($productSize, 'id_size') : array();
    if (!empty($productSize)) {
        $rowSize = $d->rawQuery("select id, name$lang from #_size where type='" . $type . "' and id in ($productSize) and find_in_set('hienthi',status) order by numb,id desc");
    }

}
    /* Lấy cấp 1 */
    $productList = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_product_list where id = ? and type = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_list'], $type));
    /* Lấy cấp 2 */
    $productCat = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_product_cat where id = ? and type = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_cat'], $type));
    /* Lấy cấp 3 */
    $productItem = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_product_item where id = ? and type = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_item'], $type));
    /* Lấy cấp 4 */
    $productSub = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_product_sub where id = ? and type = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_sub'], $type));
    /* Lấy thương hiệu */
    //$productBrand = $d->rawQueryOne("select name$lang, slugvi, slugen, id from #_product_brand where id = ? and type = ? and find_in_set('hienthi',status)", array($rowDetail['id_brand'], $type));
    /* Lấy hình ảnh con */
    $rowDetailPhoto = $d->rawQuery("select photo from #_gallery where id_parent = ? and com='product' and type = ? and kind='man' and val = ? and find_in_set('hienthi',status) order by numb,id desc", array($rowDetail['id'], $type, $type));
    /* Lấy sản phẩm cùng loại */
    $where = "";
    $where = "id <> ? and id_list = ? and type = ? and find_in_set('hienthi',status)";
    $params = array($id, $rowDetail['id_list'], $type);
    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select photo, name$lang, slugvi, slugen, sale_price, regular_price, discount, id from #_product where $where $where_add order by $order_by $limit";
    $product = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_product where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
    /* Comment */
    $comment = new Comments($d, $func, $rowDetail['id'], $rowDetail['type']);
    /* SEO */
    $seoDB = $seo->getOnDB($rowDetail['id'], 'product', 'man', $rowDetail['type']);
    $seo->set('h1', $rowDetail['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $rowDetail['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($rowDetail['options'])) ? json_decode($rowDetail['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $rowDetail['photo'])) {
        $imgJson = $func->getImgSize($rowDetail['photo'], UPLOAD_PRODUCT_L . $rowDetail['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'product', $rowDetail['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_PRODUCT_L . $rowDetail['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }
    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($productList)) $breadcr->set($productList[$sluglang], $productList['name' . $lang]);
    if (!empty($productCat)) $breadcr->set($productCat[$sluglang], $productCat['name' . $lang]);
    if (!empty($productItem)) $breadcr->set($productItem[$sluglang], $productItem['name' . $lang]);
    if (!empty($productSub)) $breadcr->set($productSub[$sluglang], $productSub['name' . $lang]);
    $breadcr->set($rowDetail[$sluglang], $rowDetail['name' . $lang]);
    $breadcrumbs = $breadcr->get();
} else if ($idl != '') {
    /* Lấy cấp 1 detail */
    $productList = $d->rawQueryOne("select id, name$lang, slugvi, slugen, type, photo, options from #_product_list where id = ? and type = ? limit 0,1", array($idl, $type));
    $active_lv1 = $productList['id'];
    /* SEO */
    $titleCate = $productList['name' . $lang];
    $seoDB = $seo->getOnDB($productList['id'], 'product', 'man_list', $productList['type']);
    $seo->set('h1', $productList['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $productList['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($productList['options'])) ? json_decode($productList['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $productList['photo'])) {
        $imgJson = $func->getImgSize($productList['photo'], UPLOAD_PRODUCT_L . $productList['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'product_list', $productList['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_PRODUCT_L . $productList['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }
    /* Lấy sản phẩm */
    $where = "";
    $where = "id_list = ? and type = ? and find_in_set('hienthi',status)";
    $params = array($idl, $type);
    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select photo, name$lang, slugvi, slugen, sale_price, regular_price, discount, id from #_product where $where $where_add order by $order_by $limit";
    $product = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_product where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($productList)) $breadcr->set($productList[$sluglang], $productList['name' . $lang]);
    $breadcrumbs = $breadcr->get();
} else if ($idc != '') {
    /* Lấy cấp 2 detail */
    $productCat = $d->rawQueryOne("select id, id_list, name$lang, slugvi, slugen, type, photo, options from #_product_cat where id = ? and type = ? limit 0,1", array($idc, $type));
    $active_lv1 = $productCat['id_list'];
    /* Lấy cấp 1 */
    $productList = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_product_list where id = ? and type = ? limit 0,1", array($productCat['id_list'], $type));
    /* Lấy sản phẩm */
    $where = "";
    $where = "id_cat = ? and type = ? and find_in_set('hienthi',status)";
    $params = array($idc, $type);
    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select photo, name$lang, slugvi, slugen, sale_price, regular_price, discount, id from #_product where $where $where_add order by $order_by $limit";
    $product = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_product where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
    /* SEO */
    $titleCate = $productCat['name' . $lang];
    $seoDB = $seo->getOnDB($productCat['id'], 'product', 'man_cat', $productCat['type']);
    $seo->set('h1', $productCat['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $productCat['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($productCat['options'])) ? json_decode($productCat['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $productCat['photo'])) {
        $imgJson = $func->getImgSize($productCat['photo'], UPLOAD_PRODUCT_L . $productCat['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'product_cat', $productCat['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_PRODUCT_L . $productCat['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }
    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($productList)) $breadcr->set($productList[$sluglang], $productList['name' . $lang]);
    if (!empty($productCat)) $breadcr->set($productCat[$sluglang], $productCat['name' . $lang]);
    $breadcrumbs = $breadcr->get();
} else if ($idi != '') {
    /* Lấy cấp 3 detail */
    $productItem = $d->rawQueryOne("select id, id_list, id_cat, name$lang, slugvi, slugen, type, photo, options from #_product_item where id = ? and type = ? limit 0,1", array($idi, $type));
    $active_lv1 = $productItem['id_list'];
    /* Lấy cấp 1 */
    $productList = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_product_list where id = ? and type = ? limit 0,1", array($productItem['id_list'], $type));
    /* Lấy cấp 2 */
    $productCat = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_product_cat where id_list = ? and id = ? and type = ? limit 0,1", array($productItem['id_list'], $productItem['id_cat'], $type));
    /* Lấy sản phẩm */
    $where = "";
    $where = "id_item = ? and type = ? and find_in_set('hienthi',status)";
    $params = array($idi, $type);
    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select photo, name$lang, slugvi, slugen, sale_price, regular_price, discount, id from #_product where $where $where_add order by $order_by $limit";
    $product = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_product where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
    /* SEO */
    $titleCate = $productItem['name' . $lang];
    $seoDB = $seo->getOnDB($productItem['id'], 'product', 'man_item', $productItem['type']);
    $seo->set('h1', $productItem['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $productItem['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($productItem['options'])) ? json_decode($productItem['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $productItem['photo'])) {
        $imgJson = $func->getImgSize($productItem['photo'], UPLOAD_PRODUCT_L . $productItem['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'product_item', $productItem['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_PRODUCT_L . $productItem['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }
    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($productList)) $breadcr->set($productList[$sluglang], $productList['name' . $lang]);
    if (!empty($productCat)) $breadcr->set($productCat[$sluglang], $productCat['name' . $lang]);
    if (!empty($productItem)) $breadcr->set($productItem[$sluglang], $productItem['name' . $lang]);
    $breadcrumbs = $breadcr->get();
} else if ($ids != '') {
    /* Lấy cấp 4 */
    $productSub = $d->rawQueryOne("select id, id_list, id_cat, id_item, name$lang, slugvi, slugen, type, photo, options from #_product_sub where id = ? and type = ? limit 0,1", array($ids, $type));
    $active_lv1 = $productSub['id_list'];
    /* Lấy cấp 1 */
    $productList = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_product_list where id = ? and type = ? limit 0,1", array($productSub['id_list'], $type));
    /* Lấy cấp 2 */
    $productCat = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_product_cat where id_list = ? and id = ? and type = ? limit 0,1", array($productSub['id_list'], $productSub['id_cat'], $type));
    /* Lấy cấp 3 */
    $productItem = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_product_item where id_list = ? and id_cat = ? and id = ? and type = ? limit 0,1", array($productSub['id_list'], $productSub['id_cat'], $productSub['id_item'], $type));
    /* Lấy sản phẩm */
    $where = "";
    $where = "id_sub = ? and type = ? and find_in_set('hienthi',status)";
    $params = array($ids, $type);
    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select photo, name$lang, slugvi, slugen, sale_price, regular_price, discount, id from #_product where $where $where_add order by $order_by $limit";
    $product = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_product where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
    /* SEO */
    $titleCate = $productSub['name' . $lang];
    $seoDB = $seo->getOnDB($productSub['id'], 'product', 'man_sub', $productSub['type']);
    $seo->set('h1', $productSub['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $productSub['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($productSub['options'])) ? json_decode($productSub['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $productSub['photo'])) {
        $imgJson = $func->getImgSize($productSub['photo'], UPLOAD_PRODUCT_L . $productSub['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'product_sub', $productSub['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_PRODUCT_L . $productSub['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }
    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($productList)) $breadcr->set($productList[$sluglang], $productList['name' . $lang]);
    if (!empty($productCat)) $breadcr->set($productCat[$sluglang], $productCat['name' . $lang]);
    if (!empty($productItem)) $breadcr->set($productItem[$sluglang], $productItem['name' . $lang]);
    if (!empty($productSub)) $breadcr->set($productSub[$sluglang], $productSub['name' . $lang]);
    $breadcrumbs = $breadcr->get();
} else if ($idb != '') {
    /* Lấy brand detail */
    $productBrand = $d->rawQueryOne("select name$lang, slugvi, slugen, id, type, photo, options from #_product_brand where id = ? and type = ? limit 0,1", array($idb, $type));
    /* SEO */
    $titleCate = $productBrand['name' . $lang];
    $seoDB = $seo->getOnDB($productBrand['id'], 'product', 'man_brand', $productBrand['type']);
    $seo->set('h1', $productBrand['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $productBrand['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($productBrand['options'])) ? json_decode($productBrand['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $productBrand['photo'])) {
        $imgJson = $func->getImgSize($productBrand['photo'], UPLOAD_PRODUCT_L . $productBrand['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'product_brand', $productBrand['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_PRODUCT_L . $productBrand['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }
    /* Lấy sản phẩm */
    $where = "";
    $where = "id_brand = ? and type = ? and find_in_set('hienthi',status)";
    $params = array($productBrand['id'], $type);
    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select photo, name$lang, slugvi, slugen, sale_price, regular_price, discount, id from #_product where $where $where_add order by $order_by $limit";
    $product = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_product where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
    /* breadCrumbs */
    $breadcr->set($productBrand[$sluglang], $titleCate);
    $breadcrumbs = $breadcr->get();
} else {
    /* SEO */
    $seopage = $d->rawQueryOne("select * from #_seopage where type = ? limit 0,1", array($type));
    $seo->set('h1', $titleMain);
    if (!empty($seopage['title' . $seolang])) $seo->set('title', $seopage['title' . $seolang]);
    else $seo->set('title', $titleMain);
    if (!empty($seopage['keywords' . $seolang])) $seo->set('keywords', $seopage['keywords' . $seolang]);
    if (!empty($seopage['description' . $seolang])) $seo->set('description', $seopage['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($seopage['options'])) ? json_decode($seopage['options'], true) : null;
    if (!empty($seopage['photo'])) {
        if (empty($imgJson) || ($imgJson['p'] != $seopage['photo'])) {
            $imgJson = $func->getImgSize($seopage['photo'], UPLOAD_SEOPAGE_L . $seopage['photo']);
            $seo->updateSeoDB(json_encode($imgJson), 'seopage', $seopage['id']);
        }
        if (!empty($imgJson)) {
            $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_SEOPAGE_L . $seopage['photo']);
            $seo->set('photo:width', $imgJson['w']);
            $seo->set('photo:height', $imgJson['h']);
            $seo->set('photo:type', $imgJson['m']);
        }
    }
    /* Lấy tất cả sản phẩm */
    $where = "";
    if($com == 'noi-bat'){
        $where = "type = ? and find_in_set('noibat',status)";
    }
    elseif($com == 'yeu-thich' and $_SESSION['list_saved']!='') {
        /* Sản phẩm yêu thích */
        $arr_like = json_decode($_SESSION['list_saved'], true);
        $arr_like = array_column($arr_like, 'id');
        $arr_like = implode('|', $arr_like);
        $where_add .= " and CONCAT(',',id, ',') REGEXP ',(".$arr_like."),'";
        //$type = 'san-pham';
    }
    else{
        $where = "type = ? and find_in_set('hienthi',status)";
    }
    $params = array($type);
    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select photo, name$lang, slugvi, slugen, sale_price, regular_price, discount, id, type from #_product where $where $where_add order by $order_by $limit";
    $product = $d->rawQuery($sql, $params);
    // var_dump($product);
    $sqlNum = "select count(*) as 'num' from #_product where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    $breadcrumbs = $breadcr->get();
}