<?php
if (!defined('SOURCES')) die("Error");

if (!empty($_POST['submit-contact'])) {
    $responseCaptcha = $_POST['recaptcha_response_contact'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
    $dataContact = (!empty($_POST['dataContact'])) ? $_POST['dataContact'] : null;

    /* Valid data */
    if (empty($dataContact['fullname'])) {
        $response['messages'][] = 'Họ tên không được trống';
    }

    if (empty($dataContact['phone'])) {
        $response['messages'][] = 'Số điện thoại không được trống';
    }

    if (!empty($dataContact['phone']) && !$func->isPhone($dataContact['phone'])) {
        $response['messages'][] = 'Số điện thoại không hợp lệ';
    }

    if (empty($dataContact['address'])) {
        $response['messages'][] = 'Địa chỉ không được trống';
    }

    if (empty($dataContact['email'])) {
        $response['messages'][] = 'Email không được trống';
    }

    if (!empty($dataContact['email']) && !$func->isEmail($dataContact['email'])) {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if (empty($dataContact['subject'])) {
        $response['messages'][] = 'Chủ đề không được trống';
    }

    if (empty($dataContact['content'])) {
        $response['messages'][] = 'Nội dung không được trống';
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($dataContact)) {
            foreach ($dataContact as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set("message", $message);
        $func->redirect("lien-he");
    }

    /* Save data */
    if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'contact') || $testCaptcha == true) {
        $data = array();
        $data['fullname'] = htmlspecialchars($dataContact['fullname']);
        $data['email'] = htmlspecialchars($dataContact['email']);
        $data['phone'] = htmlspecialchars($dataContact['phone']);
        $data['address'] = htmlspecialchars($dataContact['address']);
        $data['subject'] = htmlspecialchars($dataContact['subject']);
        $data['content'] = htmlspecialchars($dataContact['content']);
        $data['date_created'] = time();
        $data['numb'] = 1;

        if ($d->insert('contact', $data)) {
            $id_insert = $d->getLastInsertId();

            if ($func->hasFile("file_attach")) {
                $fileUpdate = array();
                $file_name = $func->uploadName($_FILES['file_attach']["name"]);

                if ($file_attach = $func->uploadImage("file_attach", '.doc|.docx|.pdf|.rar|.zip|.ppt|.pptx|.DOC|.DOCX|.PDF|.RAR|.ZIP|.PPT|.PPTX|.xls|.xlsx|.jpg|.png|.gif|.JPG|.PNG|.GIF', UPLOAD_FILE_L, $file_name)) {
                    $fileUpdate['file_attach'] = $file_attach;
                    $d->where('id', $id_insert);
                    $d->update('contact', $fileUpdate);
                    unset($fileUpdate);
                }
            }
        } else {
            $func->transfer("Gửi liên hệ thất bại. Vui lòng thử lại sau.", $configBase, false);
        }

        /* Gán giá trị gửi email */
        $strThongtin = '';
        $emailer->set('tennguoigui', $data['fullname']);
        $emailer->set('emailnguoigui', $data['email']);
        $emailer->set('dienthoainguoigui', $data['phone']);
        $emailer->set('diachinguoigui', $data['address']);
        $emailer->set('tieudelienhe', $data['subject']);
        $emailer->set('noidunglienhe', $data['content']);
        if ($emailer->get('tennguoigui')) {
            $strThongtin .= '<span style="text-transform:capitalize">' . $emailer->get('tennguoigui') . '</span><br>';
        }
        if ($emailer->get('emailnguoigui')) {
            $strThongtin .= '<a href="mailto:' . $emailer->get('emailnguoigui') . '" target="_blank">' . $emailer->get('emailnguoigui') . '</a><br>';
        }
        if ($emailer->get('diachinguoigui')) {
            $strThongtin .= '' . $emailer->get('diachinguoigui') . '<br>';
        }
        if ($emailer->get('dienthoainguoigui')) {
            $strThongtin .= 'Tel: ' . $emailer->get('dienthoainguoigui') . '';
        }
        $emailer->set('thongtin', $strThongtin);

        /* Defaults attributes email */
        $emailDefaultAttrs = $emailer->defaultAttrs();

        /* Variables email */
        $emailVars = array(
            '{emailTitleSender}',
            '{emailInfoSender}',
            '{emailSubjectSender}',
            '{emailContentSender}'
        );
        $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

        /* Values email */
        $emailVals = array(
            $emailer->get('tennguoigui'),
            $emailer->get('thongtin'),
            $emailer->get('tieudelienhe'),
            $emailer->get('noidunglienhe')
        );
        $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

        /* Send email admin */
        $arrayEmail = null;
        $subject = "Thư liên hệ từ " . $setting['name' . $lang];
        $message = str_replace($emailVars, $emailVals, $emailer->markdown('contact/admin'));
        $file = 'file_attach';

        if ($emailer->send("admin", $arrayEmail, $subject, $message, $file)) {
            /* Send email customer */
            $arrayEmail = array(
                "dataEmail" => array(
                    "name" => $emailer->get('tennguoigui'),
                    "email" => $emailer->get('emailnguoigui')
                )
            );
            $subject = "Thư liên hệ từ " . $setting['name' . $lang];
            $message = str_replace($emailVars, $emailVals, $emailer->markdown('contact/customer'));
            $file = 'file_attach';

            if ($emailer->send("customer", $arrayEmail, $subject, $message, $file)) $func->transfer("Gửi liên hệ thành công", $configBase);
        } else $func->transfer("Gửi liên hệ thất bại. Vui lòng thử lại sau", $configBase, false);
    } else {
        $func->transfer("Gửi liên hệ thất bại. Vui lòng thử lại sau", $configBase, false);
    }
}

/* SEO */
$seopage = $d->rawQueryOne("select * from #_seopage where type = ? limit 0,1", array('lien-he'));
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

$lienhe = $d->rawQueryOne("select content$lang from #_static where type = ? limit 0,1", array('lienhe'));

/* breadCrumbs */
if (!empty($titleMain)) $breadcr->set($com, $titleMain);
$breadcrumbs = $breadcr->get();
