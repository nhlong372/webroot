<?php
if (!defined('SOURCES')) die("Error");

/* Lấy tất cả video */
$where = "";
$where = "type = ? and act <> ? and find_in_set('hienthi',status)";
$params = array($type, 'photo_static');

$curPage = $getPage;
$perPage = 10;
$startpoint = ($curPage * $perPage) - $perPage;
$limit = " limit " . $startpoint . "," . $perPage;
$sql = "select photo, link_video, namevi from #_photo where $where order by numb,id desc $limit";
$video = $d->rawQuery($sql, $params);
$sqlNum = "select count(*) as 'num' from #_photo where $where order by numb,id desc";
$count = $d->rawQueryOne($sqlNum, $params);
$total = (!empty($count)) ? $count['num'] : 0;
$url = $func->getCurrentPageURL();
$paging = $func->pagination($total, $perPage, $curPage, $url);

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

/* breadCrumbs */
if (!empty($titleMain)) $breadcr->set($com, $titleMain);
$breadcrumbs = $breadcr->get();
