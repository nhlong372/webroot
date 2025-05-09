<?php
if (!defined('SOURCES')) die("Error");

@$id = htmlspecialchars($_GET['id']);
@$idl = htmlspecialchars($_GET['idl']);
@$idc = htmlspecialchars($_GET['idc']);
@$idi = htmlspecialchars($_GET['idi']);
@$ids = htmlspecialchars($_GET['ids']);

if ($id != '') {
    /* Lấy bài viết detail */
    $rowDetail = $d->rawQueryOne("select id, view, date_created, id_list, id_cat, id_item, id_sub, type, name$lang, slugvi, slugen, desc$lang, content$lang, photo, options2, file_attach from #_news where id = ? and type = ? and find_in_set('hienthi',status) limit 0,1", array($id, $type));

    /* Lấy hình ảnh con */
    $rowDetailPhoto = $d->rawQuery("select photo from #_gallery where id_parent = ? and com='news' and type = ? and kind='man' and val = ? and find_in_set('hienthi',status) order by numb,id desc", array($rowDetail['id'], $type, $type));

    /* Cập nhật lượt xem */
    $views = array();
    $views['view'] = $rowDetail['view'] + 1;
    $d->where('id', $rowDetail['id']);
    $d->update('news', $views);

    /* Lấy cấp 1 */
    $newsList = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_news_list where id = ? and type = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_list'], $type));

    /* Lấy cấp 2 */
    $newsCat = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_news_cat where id = ? and type = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_cat'], $type));

    /* Lấy cấp 3 */
    $newsItem = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_news_item where id = ? and type = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_item'], $type));

    /* Lấy cấp 4 */
    $newsSub = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_news_sub where id = ? and type = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_sub'], $type));

    /* Lấy bài viết cùng loại */
    $where = "";
    $where = "id <> ? and id_list = ? and type = ? and find_in_set('hienthi',status)";
    $params = array($id, $rowDetail['id_list'], $type);

    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select id, name$lang, slugvi, slugen, photo, date_created, desc$lang from #_news where $where order by numb,id desc $limit";
    $news_same = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_news where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);


    /* Lấy bài viết khác */
    $where = "";
    $where = "id <> ? and type = ? and find_in_set('hienthi',status)";
    $params = array($id, $type);

    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select id, name$lang, slugvi, slugen, photo, date_created, desc$lang from #_news where $where order by numb,id desc $limit";
    $news_other = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_news where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* SEO */
    $seoDB = $seo->getOnDB($rowDetail['id'], 'news', 'man', $rowDetail['type']);
    $seo->set('h1', $rowDetail['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $rowDetail['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($rowDetail['options'])) ? json_decode($rowDetail['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $rowDetail['photo'])) {
        $imgJson = $func->getImgSize($rowDetail['photo'], UPLOAD_NEWS_L . $rowDetail['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'news', $rowDetail['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_NEWS_L . $rowDetail['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($newsList)) $breadcr->set($newsList[$sluglang], $newsList['name' . $lang]);
    if (!empty($newsCat)) $breadcr->set($newsCat[$sluglang], $newsCat['name' . $lang]);
    if (!empty($newsItem)) $breadcr->set($newsItem[$sluglang], $newsItem['name' . $lang]);
    if (!empty($newsSub)) $breadcr->set($newsSub[$sluglang], $newsSub['name' . $lang]);
    $breadcr->set($rowDetail[$sluglang], $rowDetail['name' . $lang]);
    $breadcrumbs = $breadcr->get();
} else if ($idl != '') {
    /* Lấy cấp 1 detail */
    $newsList = $d->rawQueryOne("select id, name$lang, slugvi, slugen, type, photo, options from #_news_list where id = ? and type = ? limit 0,1", array($idl, $type));

    /* SEO */
    $titleCate = $newsList['name' . $lang];
    $seoDB = $seo->getOnDB($newsList['id'], 'news', 'man_list', $newsList['type']);
    $seo->set('h1', $newsList['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $newsList['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($newsList['options'])) ? json_decode($newsList['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $newsList['photo'])) {
        $imgJson = $func->getImgSize($newsList['photo'], UPLOAD_NEWS_L . $newsList['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'news_list', $newsList['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_NEWS_L . $newsList['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }

    /* Lấy bài viết */
    $where = "";
    $where = "id_list = ? and type = ? and find_in_set('hienthi',status)";
    $params = array($idl, $type);

    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select id, name$lang, slugvi, slugen, photo, date_created, desc$lang from #_news where $where order by numb,id desc $limit";
    $news = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_news where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($newsList)) $breadcr->set($newsList[$sluglang], $newsList['name' . $lang]);
    $breadcrumbs = $breadcr->get();
} else if ($idc != '') {
    /* Lấy cấp 2 detail */
    $newsCat = $d->rawQueryOne("select id, id_list, name$lang, slugvi, slugen, type, photo, options from #_news_cat where id = ? and type = ? limit 0,1", array($idc, $type));

    /* Lấy cấp 1 */
    $newsList = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_news_list where id = ? and type = ? limit 0,1", array($newsCat['id_list'], $type));

    /* Lấy bài viết */
    $where = "";
    $where = "id_cat = ? and type = ? and find_in_set('hienthi',status)";
    $params = array($idc, $type);

    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select id, name$lang, slugvi, slugen, photo, date_created, desc$lang from #_news where $where order by numb,id desc $limit";
    $news = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_news where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* SEO */
    $titleCate = $newsCat['name' . $lang];
    $seoDB = $seo->getOnDB($newsCat['id'], 'news', 'man_cat', $newsCat['type']);
    $seo->set('h1', $newsCat['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $newsCat['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($newsCat['options'])) ? json_decode($newsCat['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $newsCat['photo'])) {
        $imgJson = $func->getImgSize($newsCat['photo'], UPLOAD_NEWS_L . $newsCat['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'news_cat', $newsCat['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_NEWS_L . $newsCat['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($newsList)) $breadcr->set($newsList[$sluglang], $newsList['name' . $lang]);
    if (!empty($newsCat)) $breadcr->set($newsCat[$sluglang], $newsCat['name' . $lang]);
    $breadcrumbs = $breadcr->get();
} else if ($idi != '') {
    /* Lấy cấp 3 detail */
    $newsItem = $d->rawQueryOne("select id, id_list, id_cat, name$lang, slugvi, slugen, type, photo, options from #_news_item where id = ? and type = ? limit 0,1", array($idi, $type));

    /* Lấy cấp 1 */
    $newsList = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_news_list where id = ? and type = ? limit 0,1", array($newsItem['id_list'], $type));

    /* Lấy cấp 2 */
    $newsCat = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_news_cat where id_list = ? and id = ? and type = ? limit 0,1", array($newsItem['id_list'], $newsItem['id_cat'], $type));

    /* Lấy bài viết */
    $where = "";
    $where = "id_item = ? and type = ? and find_in_set('hienthi',status)";
    $params = array($idi, $type);

    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select id, name$lang, slugvi, slugen, photo, date_created, desc$lang from #_news where $where order by numb,id desc $limit";
    $news = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_news where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* SEO */
    $titleCate = $newsItem['name' . $lang];
    $seoDB = $seo->getOnDB($newsItem['id'], 'news', 'man_item', $newsItem['type']);
    $seo->set('h1', $newsItem['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $newsItem['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($newsItem['options'])) ? json_decode($newsItem['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $newsItem['photo'])) {
        $imgJson = $func->getImgSize($newsItem['photo'], UPLOAD_NEWS_L . $newsItem['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'news_item', $newsItem['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_NEWS_L . $newsItem['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($newsList)) $breadcr->set($newsList[$sluglang], $newsList['name' . $lang]);
    if (!empty($newsCat)) $breadcr->set($newsCat[$sluglang], $newsCat['name' . $lang]);
    if (!empty($newsItem)) $breadcr->set($newsItem[$sluglang], $newsItem['name' . $lang]);
    $breadcrumbs = $breadcr->get();
} else if ($ids != '') {
    /* Lấy cấp 4 */
    $newsSub = $d->rawQueryOne("select id, id_list, id_cat, id_item, name$lang, slugvi, slugen, type, photo, options from #_news_sub where id = ? and type = ? limit 0,1", array($ids, $type));

    /* Lấy cấp 1 */
    $newsList = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_news_list where id = ? and type = ? limit 0,1", array($newsSub['id_list'], $type));

    /* Lấy cấp 2 */
    $newsCat = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_news_cat where id_list = ? and id = ? and type = ? limit 0,1", array($newsSub['id_list'], $newsSub['id_cat'], $type));

    /* Lấy cấp 3 */
    $newsItem = $d->rawQueryOne("select id, name$lang, slugvi, slugen from #_news_item where id_list = ? and id_cat = ? and id = ? and type = ? limit 0,1", array($newsSub['id_list'], $newsSub['id_cat'], $newsSub['id_item'], $type));

    /* Lấy bài viết */
    $where = "";
    $where = "id_sub = ? and type = ? and find_in_set('hienthi',status)";
    $params = array($ids, $type);

    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select id, name$lang, slugvi, slugen, photo, date_created, desc$lang from #_news where $where order by numb,id desc $limit";
    $news = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_news where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* SEO */
    $titleCate = $newsSub['name' . $lang];
    $seoDB = $seo->getOnDB($newsSub['id'], 'news', 'man_sub', $newsSub['type']);
    $seo->set('h1', $newsSub['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $newsSub['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $imgJson = (!empty($newsSub['options'])) ? json_decode($newsSub['options'], true) : null;
    if (empty($imgJson) || ($imgJson['p'] != $newsSub['photo'])) {
        $imgJson = $func->getImgSize($newsSub['photo'], UPLOAD_NEWS_L . $newsSub['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'news_sub', $newsSub['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_NEWS_L . $newsSub['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    if (!empty($newsList)) $breadcr->set($newsList[$sluglang], $newsList['name' . $lang]);
    if (!empty($newsCat)) $breadcr->set($newsCat[$sluglang], $newsCat['name' . $lang]);
    if (!empty($newsItem)) $breadcr->set($newsItem[$sluglang], $newsItem['name' . $lang]);
    if (!empty($newsSub)) $breadcr->set($newsSub[$sluglang], $newsSub['name' . $lang]);
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

    /* Lấy tất cả bài viết */
    $where = "";
    $where = "type = ? and find_in_set('hienthi',status)";
    $params = array($type);

    $curPage = $getPage;
    $perPage = 12;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select id, name$lang, slugvi, slugen, photo, date_created, desc$lang, view from #_news where $where order by numb,id desc $limit";
    $news = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_news where $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* breadCrumbs */
    if (!empty($titleMain)) $breadcr->set($com, $titleMain);
    $breadcrumbs = $breadcr->get();
}
