<?php
if (!defined('SOURCES')) die("Error");

/* Query allpage */
//$cap_1_news = $func->get_cap('noibat','tin-tuc','news_list',100);
$favicon = $cache->get("select photo from #_photo where type = ? and act = ? and find_in_set('hienthi',status) limit 0,1", array('favicon', 'photo_static'), 'fetch', 7200);
$logo = $cache->get("select id, photo, options from #_photo where type = ? and act = ? limit 0,1", array('logo', 'photo_static'), 'fetch', 7200);
$banner = $cache->get("select photo from #_photo where type = ? and act = ? limit 0,1", array('banner', 'photo_static'), 'fetch', 7200);
$slogan = $cache->get("select name$lang from #_static where type = ? limit 0,1", array('slogan'), 'fetch', 7200);
$social = $cache->get("select name$lang, photo, link from #_photo where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('social'), 'result', 7200);
// $splist = $cache->get("select name$lang, slugvi, slugen, id from #_product_list where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('san-pham'), 'result', 7200);
// $ttlist = $cache->get("select name$lang, slugvi, slugen, id from #_news_list where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('tin-tuc'), 'result', 7200);
$footer = $cache->get("select name$lang, content$lang from #_static where type = ? limit 0,1", array('footer'), 'fetch', 7200);
// $tagsProduct = $cache->get("select name$lang, slugvi, slugen, id from #_tags where type = ? and find_in_set('noibat',status) and find_in_set('hienthi',status) order by numb,id desc", array('san-pham'), 'result', 7200);
// $tagsNews = $cache->get("select name$lang, slugvi, slugen, id from #_tags where type = ? and find_in_set('noibat',status) and find_in_set('hienthi',status) order by numb,id desc", array('tin-tuc'), 'result', 7200);
$policy = $cache->get("select name$lang, slugvi, slugen, id, photo from #_news where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('chinh-sach'), 'result', 7200);
//$chinhanh = $cache->get("select name$lang,id, options2 from #_news where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('chi-nhanh'), 'result', 7200);
/* Get statistic */
$counter = $statistic->getCounter();
$online = $statistic->getOnline();


/* Newsletter */
if (!empty($_POST['submit-newsletter'])) {
    $responseCaptcha = $_POST['recaptcha_response_newsletter'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
    $dataNewsletter = (!empty($_POST['dataNewsletter'])) ? $_POST['dataNewsletter'] : null;

    /* Valid data */

    if (empty($dataNewsletter['fullname'])) {
        $flash->set('error', 'Họ tên không được trống');
    }

    if (empty($dataNewsletter['phone'])) {
        $flash->set('error', 'Số điện thoại không được trống');
    }

    if (!empty($dataNewsletter['phone']) && !$func->isPhone($dataNewsletter['phone'])) {
        $flash->set('error', 'Số điện thoại không hợp lệ');
    }
    
    if (empty($dataNewsletter['email'])) {
       $flash->set('error', 'Email không được trống');
    }

    if (!empty($dataNewsletter['email']) && !$func->isEmail($dataNewsletter['email'])) {
        $flash->set('error', 'Email không hợp lệ');
    }

    $error = $flash->get('error');

    if (!empty($error)) {
        $func->transfer($error, $configBase, false);
    }

    /* Save data */
    if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Newsletter') || $testCaptcha == true) {
        $data = array();
        $data['fullname'] = htmlspecialchars($dataNewsletter['fullname']);
        $data['phone'] = htmlspecialchars($dataNewsletter['phone']);
        $data['email'] = htmlspecialchars($dataNewsletter['email']);
        /*$data['address'] = htmlspecialchars($dataNewsletter['address']);
        $data['content'] = htmlspecialchars($dataNewsletter['content']);*/
        $data['date_created'] = time();
        $data['numb'] = 1;
        $data['type'] = 'dangkynhantin';

        if ($d->insert('newsletter', $data)) {
            $func->transfer("Đăng ký nhận tin thành công. Chúng tôi sẽ liên hệ với bạn sớm.", $configBase);
        } else {
            $func->transfer("Đăng ký nhận tin thất bại. Vui lòng thử lại sau.", $configBase, false);
        }
    } else {
        $func->transfer("Đăng ký nhận tin thất bại. Vui lòng thử lại sau.", $configBase, false);
    }
}


/* Newsletter */
// if (!empty($_POST['submit-newsletter'])) {
//     $responseCaptcha = $_POST['recaptcha_response_newsletter'];
//     $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
//     $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
//     $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
//     $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
//     $dataNewsletter = (!empty($_POST['dataNewsletter'])) ? $_POST['dataNewsletter'] : null;

//     /* Valid data */

//     if (empty($dataNewsletter['fullname'])) {
//         $flash->set('error', 'Họ tên không được để trống');
//     }

//     if (empty($dataNewsletter['phone'])) {
//         $flash->set('error', 'Số điện thoại không được để trống');
//     }

//     if (!empty($dataNewsletter['phone']) && !$func->isPhone($dataNewsletter['phone'])) {
//         $flash->set('error', 'Số điện thoại không hợp lệ');
//     }

//     if (empty($dataNewsletter['email'])) {
//         $flash->set('error', 'Email không được trống');
//     }

//     if (!empty($dataNewsletter['email']) && !$func->isEmail($dataNewsletter['email'])) {
//         $flash->set('error', 'Email không hợp lệ');
//     }

//     //  if (empty($dataNewsletter['address'])) {
//     //     $flash->set('error', 'Địa chỉ không được để trống');
//     //  }

//     //  if (empty($dataNewsletter['content'])) {
//     //     $flash->set('error', 'Nội dung không được để trống');
//     //  }

//     $error = $flash->get('error');

//     if (!empty($error)) {
//         $func->transfer($error, $configBase, false);
//     }

//     /* Save data */
//     if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Newsletter') || $testCaptcha == true) {
//         $data = array();
//         $data['fullname'] = htmlspecialchars($dataNewsletter['fullname']);
//         $data['email'] = htmlspecialchars($dataNewsletter['email']);
//         $data['phone'] = htmlspecialchars($dataNewsletter['phone']);
//         //  $data['address'] = htmlspecialchars($dataNewsletter['address']);
//         $data['content'] = htmlspecialchars($dataNewsletter['content']);
//         $data['subject'] = 'Đăng ký báo giá';
//         $data['date_created'] = time();
//         $data['numb'] = 1;
//         $data['type'] = 'baogia';
//         $duplicate_email = $d->rawQueryOne("select id from #_newsletter where email = ? and type = ? limit 0,1", array($data['email'], 'baogia'));
//         if ($duplicate_email) {
//             $func->transfer("Email này đã đăng ký.", $configBase, false);
//         } else {
//             $d->insert('newsletter', $data);
//         }

//         /* Gán giá trị gửi email */
//         $strThongtin = '';
//         $emailer->set('tennguoigui', $data['fullname']);
//         $emailer->set('emailnguoigui', $data['email']);
//         $emailer->set('dienthoainguoigui', $data['phone']);
//         //  $emailer->set('diachinguoigui', $data['address']);
//         $emailer->set('tieudelienhe', $data['subject']);
//         $emailer->set('noidunglienhe', $data['content']);
//         if ($emailer->get('tennguoigui')) {
//             $strThongtin .= '<b>Tên người gửi: </b><span style="text-transform:capitalize">' . $emailer->get('tennguoigui') . '</span><br>';
//         }
//         if ($emailer->get('emailnguoigui')) {
//             $strThongtin .= '<b>Email người gửi: </b><a href="mailto:' . $emailer->get('emailnguoigui') . '" target="_blank">' . $emailer->get('emailnguoigui') . '</a><br>';
//         }
//         //  if ($emailer->get('diachinguoigui')) {
//         //      $strThongtin .= '<b>Địa chỉ người gửi: </b>' . $emailer->get('diachinguoigui') . '<br>';
//         //  }
//         if ($emailer->get('dienthoainguoigui')) {
//             $strThongtin .= '<b>Số điện thoại của người gửi: </b>' . $emailer->get('dienthoainguoigui') . '';
//         }
//         $emailer->set('thongtin', $strThongtin);

//         /* Defaults attributes email */
//         $emailDefaultAttrs = $emailer->defaultAttrs();

//         /* Variables email */
//         $emailVars = array(
//             '{emailTitleSender}',
//             '{emailInfoSender}',
//             '{emailSubjectSender}',
//             '{emailContentSender}'
//         );
//         $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

//         /* Values email */
//         $emailVals = array(
//             $emailer->get('tennguoigui'),
//             $emailer->get('thongtin'),
//             $emailer->get('tieudelienhe'),
//             $emailer->get('noidunglienhe')
//         );
//         $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

//         /* Send email admin */
//         $arrayEmail = null;
//         $subject = "Thư đăng ký báo giá từ " . $data['fullname'];
//         //$setting['name' . $lang]
//         $message = str_replace($emailVars, $emailVals, $emailer->markdown('newsletter/admin'));
//         $file = 'file_attach';

//         if ($emailer->send("admin", $arrayEmail, $subject, $message, $file)) {
//             echo $func->transfer("Gửi đăng ký báo giá thành công", $configBase);
//         } 
//         else { 
//             $func->transfer("Gửi đăng ký báo giá thất bại. Vui lòng thử lại sau", $configBase, false);
//         }
//     } else {
//         $func->transfer("Gửi đăng ký báo giá thất bại. Vui lòng thử lại sau", $configBase, false);
//     }
// }
