<?php
if (!defined('SOURCES')) die("Error");

$id = htmlspecialchars($_GET['id']);

if ($id) {
    /* Lấy tag detail */
    $tags_detail = $d->rawQueryOne("select id, name$lang, type, photo, slugvi, slugen, options from #_tags where id = ? and type = ? limit 0,1", array($id, $type));

    /* Lấy tags id in product/news */
    $idTags = $d->rawQuery("select id_parent from #_" . $table . "_tags where id_tags = ?", array($id));
    $idTags = (!empty($idTags)) ? $func->joinCols($idTags, 'id_parent') : '';

    /* Lấy mục */
    $where = "";
    $where = "type = ?";
    $where .= (!empty($idTags)) ? " and id in ($idTags)" : " and id = 0";
    $params = array($type);

    /* Column for sản phẩm */
    if ($table == 'product') $col = "photo, name$lang, slugvi, slugen, sale_price, regular_price, discount, id";

    /* Column for bài viết */
    if ($table == 'news') $col = "photo, name$lang, slugvi, slugen, desc$lang, content$lang, date_created, id";

    $curPage = $getPage;
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select $col from #_" . $table . " where $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_" . $table . " where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* Data for sản phẩm */
    if ($table == 'product') $product = $items;

    /* Data for bài viết */
    if ($table == 'news') $news = $items;

    /* SEO */
    $titleMain = $tags_detail['name' . $lang];
    $seoDB = $seo->getOnDB($tags_detail['id'], 'tags', 'man', $tags_detail['type']);
    $seo->set('h1', $tags_detail['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $tags_detail['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($tags_detail['options'])) ? json_decode($tags_detail['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $tags_detail['photo'])) {
        $imgJson = $func->getImgSize($tags_detail['photo'], UPLOAD_TAGS_L . $tags_detail['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'tags', $tags_detail['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_TAGS_L . $tags_detail['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($tags_detail[$sluglang], $titleMain);
    $breadcrumbs = $breadcr->get();
}
