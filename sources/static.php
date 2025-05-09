<?php
if (!defined('SOURCES')) die("Error");

/* Lấy bài viết tĩnh */
$static = $d->rawQueryOne("select id, type, name$lang, content$lang, photo, date_created, date_updated, options from #_static where type = ? limit 0,1", array($type));

/* SEO */
if (!empty($static)) {
    $seoDB = $seo->getOnDB(0, 'static', 'update', $static['type']);
    $seo->set('h1', $static['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $static['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($static['options'])) ? json_decode($static['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $static['photo'])) {
        $imgJson = $func->getImgSize($static['photo'], UPLOAD_NEWS_L . $static['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'static', $static['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_NEWS_L . $static['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }
}

/* breadCrumbs */
if (!empty($titleMain)) $breadcr->set($com, $titleMain);
$breadcrumbs = $breadcr->get();
