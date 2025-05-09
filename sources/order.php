<?php
if (!defined('SOURCES')) die("Error");

/* SEO */
$seo->set('title', $titleMain);

/* breadCrumbs */
if (!empty($titleMain)) $breadcr->set($com, $titleMain);
$breadcrumbs = $breadcr->get();

/* Tỉnh thành */
$city = $d->rawQuery("select name, id from #_city order by id asc");

/* Hình thức thanh toán */
$payments_info = $d->rawQuery("select name$lang, desc$lang, id from #_news where type = ? order by numb,id desc", array('hinh-thuc-thanh-toan'));

if (!empty($_POST['thanhtoan'])) {
    /* Check order */
    if (empty($_SESSION['cart'])) {
        $func->transfer("Đơn hàng không hợp lệ. Vui lòng thử lại sau.", $configBase, false);
    }

    /* Data */
    $dataOrder = (!empty($_POST['dataOrder'])) ? $_POST['dataOrder'] : null;

    /* Check data */
    if (!empty($dataOrder)) {
        /* Info */
        $code = strtoupper($func->stringRandom(6));
        $order_date = time();
        $fullname = (!empty($dataOrder['fullname'])) ? htmlspecialchars($dataOrder['fullname']) : '';
        $email = (!empty($dataOrder['email'])) ? htmlspecialchars($dataOrder['email']) : '';
        $phone = (!empty($dataOrder['phone'])) ? htmlspecialchars($dataOrder['phone']) : '';
        $requirements = (!empty($dataOrder['requirements'])) ? htmlspecialchars($dataOrder['requirements']) : '';

        /* Place */
        $city = (!empty($dataOrder['city'])) ? htmlspecialchars($dataOrder['city']) : 0;
        $district = (!empty($dataOrder['district'])) ? htmlspecialchars($dataOrder['district']) : 0;
        $ward = (!empty($dataOrder['ward'])) ? htmlspecialchars($dataOrder['ward']) : 0;
        $city_text = $func->getInfoDetail('name', "city", $city);
        $district_text = $func->getInfoDetail('name', "district", $district);
        $ward_text = $func->getInfoDetail('name', "ward", $ward);
        $address = htmlspecialchars($dataOrder['address']) . ', ' . $ward_text['name'] . ', ' . $district_text['name'] . ', ' . $city_text['name'];

        /* Payment */
        $order_payment = (!empty($dataOrder['payments'])) ? htmlspecialchars($dataOrder['payments']) : 0;
        $order_payment_data = $func->getInfoDetail('namevi', 'news', $order_payment);
        $order_payment_text = $order_payment_data['namevi'];

        /* Ship */
        if (!empty($config['order']['ship'])) {
            $ship_data = (!empty($dataOrder['ward'])) ? $func->getInfoDetail('ship_price', "ward", $dataOrder['ward']) : array();
            $ship_price = (!empty($ship_data['ship_price'])) ? $ship_data['ship_price'] : 0;
        } else {
            $ship_price = 0;
        }

        /* Price */
        $endow = (!empty($dataOrder['price-endow'])) ? htmlspecialchars($dataOrder['price-endow']) : 0;
        $endowID = (!empty($dataOrder['price-endowID'])) ? htmlspecialchars($dataOrder['price-endowID']) : 0;
        $endowType = (!empty($dataOrder['price-endowType'])) ? htmlspecialchars($dataOrder['price-endowType']) : 0;

        $temp_price = $cart->getOrderTotal();
        if(!empty($ship_price)) {
            $total_price = (!empty($ship_price)) ? $cart->getOrderTotal() + $ship_price : $cart->getOrderTotal();
        } else {
            if($endowType==1){

                $tiengiam = (($temp_price * $endow) / 100);

                $total_price = (!empty($ship_price)) ? $cart->getOrderTotal($type) + $ship_price - $tiengiam : $cart->getOrderTotal($type) - $tiengiam;
            }else{
                $total_price = (!empty($ship_price)) ? $cart->getOrderTotal($type) + $ship_price - $endow : $cart->getOrderTotal($type) - $endow;
            }
        }



        // /* Price */
        // $temp_price = $cart->getOrderTotal();
        // $total_price = (!empty($ship_price)) ? $cart->getOrderTotal() + $ship_price : $cart->getOrderTotal();

        /* Cart */
        $order_detail = '';
        $max = (!empty($_SESSION['cart'])) ? count($_SESSION['cart']) : 0;
    }

    /* Valid data */
    if (empty($dataOrder['payments'])) {
        $response['messages'][] = 'Chưa chọn hình thức thanh toán';
    }

    if (empty($dataOrder['fullname'])) {
        $response['messages'][] = 'Họ tên không được trống';
    }

    if (empty($dataOrder['phone'])) {
        $response['messages'][] = 'Số điện thoại không được trống';
    }

    if (!empty($dataOrder['phone']) && !$func->isPhone($dataOrder['phone'])) {
        $response['messages'][] = 'Số điện thoại không hợp lệ';
    }

    if (empty($dataOrder['city'])) {
        $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
    }

    if (empty($dataOrder['district'])) {
        $response['messages'][] = 'Chưa chọn quận/huyện';
    }

    if (empty($dataOrder['ward'])) {
        $response['messages'][] = 'Chưa chọn phường/xã';
    }


    if (empty($dataOrder['address'])) {
        $response['messages'][] = 'Địa chỉ không được trống';
    }

    if (empty($dataOrder['email'])) {
        $response['messages'][] = 'Email không được trống';
    }

    if (!empty($dataOrder['email']) && !$func->isEmail($dataOrder['email'])) {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($dataOrder)) {
            foreach ($dataOrder as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set("message", $message);
        $func->redirect("gio-hang");
    }

    /* Details order */
    for ($i = 0; $i < $max; $i++) {
        $pid = $_SESSION['cart'][$i]['productid'];
        $q = $_SESSION['cart'][$i]['qty'];
        $color = $_SESSION['cart'][$i]['color'];
        $size = $_SESSION['cart'][$i]['size'];
        $gia = ($_SESSION['cart'][$i]['gia'])?$_SESSION['cart'][$i]['gia']:0;
        $photo = ($_SESSION['cart'][$i]['photo'])?$_SESSION['cart'][$i]['photo']:0;
        $code_order = $_SESSION['cart'][$i]['code'];
        $proinfo = $cart->getProductInfo($pid);
        if($photo>0) {
            $proinfo['photo'] = $photo;
        }
        if($gia>0) {
            $proinfo['regular_price'] = $gia;
            $proinfo['sale_price'] = $gia;
        }
        $text_color = $cart->getProductColor($color);
        $text_size = $cart->getProductSize($size);
        $text_attr = '';
        if ($text_color != '' && $text_size != '') $text_attr = $text_color . " - " . $text_size;
        else if ($text_color != '') $text_attr = $text_color;
        else if ($text_size != '') $text_attr = $text_size;

        if ($q == 0) continue;

        /* Variables detail order */
        $orderDetailVars = array(
            '{productName}',
            '{productAttr}',
            '{productSalePrice}',
            '{productRegularPrice}',
            '{productQuantity}',
            '{productSaleTotalPrice}',
            '{productRegularTotalPrice}'
        );

        /* Values detail order */
        $orderDetailVals = array(
            $proinfo['name' . $lang],
            $text_attr,
            $func->formatMoney($proinfo['sale_price']),
            $func->formatMoney($proinfo['regular_price']),
            $q,
            $func->formatMoney($proinfo['sale_price'] * $q),
            $func->formatMoney($proinfo['regular_price'] * $q)
        );

        /* Get order details */
        $order_detail .= str_replace($orderDetailVars, $orderDetailVals, $emailer->markdown('order/details', ['productAttr' => $text_attr, 'salePrice' => $proinfo['sale_price']]));
    }

    /* Total order */
    /* Variables total order */
    $orderTotalVars = array(
        '{orderTempPrice}',
        '{orderShipPrice}',
        '{orderTotalPrice}'
    );

    /* Values total order */
    $orderTotalVals = array(
        $func->formatMoney($temp_price),
        $func->formatMoney($ship_price),
        $func->formatMoney($total_price)
    );

    /* Get total order */
    $order_detail .= str_replace($orderTotalVars, $orderTotalVals, $emailer->markdown('order/total', ['shipPrice' => $ship_price]));

    /* lưu đơn hàng */
    $data_donhang = array();
    $data_donhang['id_user'] = (!empty($_SESSION[$loginMember]['id'])) ? $_SESSION[$loginMember]['id'] : 0;
    $data_donhang['code'] = $code;
    $data_donhang['fullname'] = $fullname;
    $data_donhang['phone'] = $phone;
    $data_donhang['address'] = $address;
    $data_donhang['email'] = $email;
    $data_donhang['order_payment'] = $order_payment;
    $data_donhang['ship_price'] = $ship_price;
    $data_donhang['temp_price'] = $temp_price;
    $data_donhang['total_price'] = $total_price;
    $data_donhang['requirements'] = $requirements;
    $data_donhang['date_created'] = $order_date;
    $data_donhang['order_status'] = 1;
    $data_donhang['city'] = $city;
    $data_donhang['district'] = $district;
    $data_donhang['ward'] = $ward;
    $data_donhang['numb'] = 1;
    $id_insert = $d->insert('order', $data_donhang);

    /* lưu đơn hàng chi tiết */
    if ($id_insert) {
        for ($i = 0; $i < $max; $i++) {
            $pid = $_SESSION['cart'][$i]['productid'];
            $q = $_SESSION['cart'][$i]['qty'];
            $gia = ($_SESSION['cart'][$i]['gia'])?$_SESSION['cart'][$i]['gia']:0;
            $photo = ($_SESSION['cart'][$i]['photo'])?$_SESSION['cart'][$i]['photo']:0;
            $proinfo = $cart->getProductInfo($pid);
            if($photo>0) {
                $proinfo['photo'] = $photo;
            }
            if($gia>0) {
                $proinfo['regular_price'] = $gia;
                $proinfo['sale_price'] = $gia;
            }
            $regular_price = $proinfo['regular_price'];
            $sale_price = $proinfo['sale_price'];
            $color = $cart->getProductColor($_SESSION['cart'][$i]['color']);
            $size = $cart->getProductSize($_SESSION['cart'][$i]['size']);
            $code_order = $_SESSION['cart'][$i]['code'];

            if ($q == 0) continue;

            $data_donhangchitiet = array();
            $data_donhangchitiet['id_product'] = $pid;
            $data_donhangchitiet['id_order'] = $id_insert;
            $data_donhangchitiet['photo'] = $proinfo['photo'];
            $data_donhangchitiet['name'] = $proinfo['name' . $lang];
            $data_donhangchitiet['code'] = $code;
            $data_donhangchitiet['color'] = $color;
            $data_donhangchitiet['size'] = $size;
            $data_donhangchitiet['regular_price'] = $regular_price;
            $data_donhangchitiet['sale_price'] = $sale_price;
            $data_donhangchitiet['quantity'] = $q;
            $d->insert('order_detail', $data_donhangchitiet);
        }
    }

    /* Defaults attributes email */
    $emailDefaultAttrs = $emailer->defaultAttrs();

    /* Variables email */
    $emailVars = array(
        '{emailOrderCode}',
        '{emailOrderInfoFullname}',
        '{emailOrderInfoEmail}',
        '{emailOrderInfoPhone}',
        '{emailOrderInfoAddress}',
        '{emailOrderPayment}',
        '{emailOrderShipPrice}',
        '{emailOrderInfoRequirements}',
        '{emailOrderDetails}'
    );
    $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

    /* Values email */
    $emailVals = array(
        $code,
        $fullname,
        $email,
        $phone,
        $address,
        $order_payment_text,
        $ship_price,
        $requirements,
        $order_detail
    );
    $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

    /* Send email admin */
    $arrayEmail = null;
    $subject = "Thông tin đơn hàng từ " . $setting['name' . $lang];
    $message = str_replace($emailVars, $emailVals, $emailer->markdown('order/admin', ['shipPrice' => $ship_price]));
    $file = '';
    $emailer->send("admin", $arrayEmail, $subject, $message, $file);

    /* Send email customer */
    $arrayEmail = array(
        "dataEmail" => array(
            "name" => $fullname,
            "email" => $email
        )
    );
    $subject = "Thông tin đơn hàng từ " . $setting['name' . $lang];
    $message = str_replace($emailVars, $emailVals, $emailer->markdown('order/customer', ['shipPrice' => $ship_price]));
    $file = '';
    $emailer->send("customer", $arrayEmail, $subject, $message, $file);

    /* Xóa giỏ hàng */
    unset($_SESSION['cart']);
    $func->transfer("Thông tin đơn hàng đã được gửi thành công.", $configBase);
}
