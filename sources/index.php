<?php
if (!defined('SOURCES')) die("Error");

//$cap1 = $func->get_cap('noibat','san-pham','product_list',16); //danhmuc, list, cat, item ( product/news )
//$sanphambc = $func->get_product('banchay','san-pham',14);   
//$slogank = $d->rawQuery("select desc$lang from #_news where type = ? order by numb asc",array('slogan-bv'));
//$get_danhmuc = $func->get_cap('hienthi','san-pham','product_list',2); //danhmuc, list, cat, item ( product/news )
//$get_sanpham = $func->get_product('banchay','san-pham',14); 
//$get_baiviet = $d->rawQuery("select name$lang, slugvi, slugen, desc$lang, date_created, id, photo, options2 from #_news where type = ? and find_in_set('noibat',status) and find_in_set('hienthi',status) order by numb,id desc",array('tin-tuc'));
//$get_1bv = $d->rawQueryOne("select name$lang, desc$lang, photo from #_static where type = ? limit 0,1",array('gioi-thieu'));
//$get_1photo = $d->rawQueryOne("select id, photo, options from #_photo where type = ? and act = ? limit 0,1",array('logo','photo_static'));
//$sliderabout = $d->rawQuery("select photo from #_gallery where id_photo = ? and com='news' and type = ? and kind='man' and val = ? and find_in_set('hienthi',status) order by numb,id desc",array($about['id'],$about['type'],$about['type']));

//lay du lieu dang noi : htmlspecialchars_decode($static['noidung'.$lang])
//$optyahoo = (isset($yahoo[$i]['options2']) && $yahoo[$i]['options2'] != '') ? json_decode($yahoo[$i]['options2'],true) : null;
//$chuoi = explode(',', $v['status']);  if(in_array('noibat',$chuoi)) { show thong tin }

// $popup = $cache->get("select name$lang, photo, link from #_photo where type = ? and act = ? and find_in_set('hienthi',status) limit 0,1", array('popup', 'photo_static'), 'fetch', 7200);

$slider = $cache->get("select name$lang, photo, link from #_photo where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('slide'), 'result', 7200);
$splistmenu = $cache->get("select name$lang, slugvi, slugen, id, type from #_product_list where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('san-pham'), 'result', 7200);
$newsnb = $cache->get("select name$lang, slugvi, slugen, desc$lang, date_created, id, photo from #_news where type = ? and find_in_set('noibat',status) and find_in_set('hienthi',status) order by numb,id desc", array('tin-tuc'), 'result', 7200);
$videonb = $cache->get("select id from #_photo where type = ? and find_in_set('noibat',status) and find_in_set('hienthi',status)", array('video'), 'result', 7200);

if(SHOWBRAND == true){
$brand = $cache->get("select name$lang, slugvi, slugen, id, photo from #_product_brand where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('san-pham'), 'result', 7200);
}

// $pronb = $cache->get("select id from #_product where type = ? and find_in_set('noibat',status) and find_in_set('hienthi',status)", array('san-pham'), 'result', 7200);

// $splistnb = $cache->get("select name$lang, slugvi, slugen, id from #_product_list where type = ? and find_in_set('noibat',status) and find_in_set('hienthi',status) order by numb,id desc", array('san-pham'), 'result', 7200);

//$feedback = $cache->get("select name$lang, desc$lang, id, photo from #_news where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('y-kien'), 'result', 7200);

// $partner = $cache->get("select name$lang, link, photo from #_photo where type = ? and find_in_set('hienthi',status) order by numb, id desc", array('doitac'), 'result', 7200);

/* SEO */
$seoDB = $seo->getOnDB(0, 'setting', 'update', 'setting');
if (!empty($seoDB['title' . $seolang])) $seo->set('h1', $seoDB['title' . $seolang]);
if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
$seo->set('url', $func->getPageURL());
$imgJson = (!empty($logo['options'])) ? json_decode($logo['options'], true) : null;
if (empty($imgJson) || ($imgJson['p'] != $logo['photo'])) {
    $imgJson = $func->getImgSize($logo['photo'], UPLOAD_PHOTO_L . $logo['photo']);
    $seo->updateSeoDB(json_encode($imgJson), 'photo', $logo['id']);
}
if (!empty($imgJson)) {
    $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_PHOTO_L . $logo['photo']);
    $seo->set('photo:width', $imgJson['w']);
    $seo->set('photo:height', $imgJson['h']);
    $seo->set('photo:type', $imgJson['m']);
}


/* source Thư báo giá vào newsletter */
/*if(!empty($_POST['submit-baogia']))
{
    $responseCaptcha = $_POST['recaptcha_response_baogia'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
    $dataBaogia = (!empty($_POST['dataBaogia'])) ? $_POST['dataBaogia'] : null;
   
    $error = $flash->get('error');

    if(!empty($error))
    {
        $func->transfer($error, $configBase, false);
    }
    
    if(($scoreCaptcha >= 0.5 && $actionCaptcha == 'Newsletter') || $testCaptcha == true)
    {
        $data = array();
        $data['email'] = htmlspecialchars($dataBaogia['email']);
        $data['fullname'] = htmlspecialchars($dataBaogia['fullname']);
        $data['phone'] = htmlspecialchars($dataBaogia['phone']);
        $data['address'] = htmlspecialchars($dataBaogia['address']);
        $data['content'] = htmlspecialchars($dataBaogia['content']);
        $data['date_created'] = time();
        $data['type'] = 'baogia';

        if($d->insert('newsletter',$data))
        {
            $func->transfer("Đăng ký báo giá thành công. Chúng tôi sẽ liên hệ với bạn sớm.", $configBase);
        }
        else
        {
            $func->transfer("Đăng ký báo giá thất bại. Vui lòng thử lại sau.", $configBase, false);
        }
    }
    else
    {
        $func->transfer("Đăng ký báo giá thất bại. Vui lòng thử lại sau.", $configBase, false);
    }
}*/