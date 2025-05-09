<?php /*
// Sản phẩm nổi bật phân trang
// Sản phẩm nổi bật phân trang theo danh mục cấp 1
// Sản phẩm nổi bật phân trang theo tab danh mục cấp 1
// Sản phẩm nổi bật phân trang theo tab cố định
// Sản phẩm nổi bật phân trang theo for cấp 1 tab cấp 2
// Sản phẩm nổi bật có nút xem thêm
// Sản phẩm nổi bật có nút xem thêm for danh mục cấp 1
// Sản phẩm nổi bật có nút xem thêm tab danh mục cấp 1
// Sản phẩm nổi bật có nút xem thêm tab cố định
// Chạy slick theo tab loại cố định
// Chạy slick theo tab cấp 1
// Chạy slick theo for cấp 1 tab cấp 2
*/ ?>
<!-- Sản phẩm nổi bật -->
<div class="wrap-product wrap-content">
    <div class="title-main"><span>Sản phẩm nổi bật</span></div>
    <div class="page_noibat"></div>
</div>
<!-- Sản phẩm theo danh mục -->
<?php foreach ($splistmenu as $k => $v) { ?>
<div class="wrap-product wrap-content">
    <div class="title-main"><span><?=$v['name'.$lang]?></span></div>
    <div class="page_danhmuc page_danhmuc<?=$v['id']?>"></div>
</div>
<?php } ?>
<!-- Sản phẩm theo tab danh mục -->
<div class="wrap-product wrap-content">
    <div class="list_monnb list_sanpham mb-3 text-center text-2xl">
        <a class="font-weight-bold " role="button" data-id="0">Tất cả</a>
        <?php foreach ($splistmenu as $k => $v) { ?>
        <a class="font-weight-bold " role="button" data-id="<?=$v['id']?>"><?=$v['name'.$lang]?></a>
        <?php } ?>
    </div>
    <div class="page_sanpham"></div>
</div>
<!-- Sản phẩm theo tab cố định -->
<div class="wrap-product wrap-content">
    <div class="list_monnb list_tab mb-3 text-center text-2xl">
        <a class="font-weight-bold " data-id="find_in_set('noibat',status)">Nổi bật</a>
        <a class="font-weight-bold " data-id="find_in_set('moi',status)">Mới</a>
        <a class="font-weight-bold " data-id="find_in_set('banchay',status)">Bán chạy</a>
    </div>
    <div class="page_tabloai"></div>
</div>

<!-- Sản phẩm theo danh mục cấp 1 & 2 -->
<?php /*foreach ($splistmenu as $key => $value) {
    $spcatmenu = $d->rawQuery("select name$lang, slugvi, id from #_product_cat where type = ? and find_in_set('hienthi',status) and id_list = ? order by numb,id desc",array('san-pham', $value['id']));
?>
<div class="wrap-product wrap-content">
    <div class="d-flex align-items-center mb-3">
        <div class="title-main m-0"><span><?=$value['name'.$lang]?></span></div>        
        <a class="text-dark ml-auto" href="<?=$value[$sluglang]?>">
            Xem tất cả 
            <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.19751 10.62L5.00084 6.81667C5.45001 6.3675 5.45001 5.6325 5.00084 5.18334L1.19751 1.38" stroke="#4A4A4A" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </div>
    <div class="list_monnb banchay_list list_<?=$value['id']?> ml-3">
        <a class="mr-2 font-weight-bold" data-id="0">Tất cả</a>
        <?php foreach ($spcatmenu as $key2 => $value2) { ?>
        <a class="mr-2 font-weight-bold" data-id="<?=$value2['id']?>"><?=$value2['name'.$lang]?></a>
        <?php } ?>
    </div>
    <div class="page_danhmuc page_danhmuc_list<?=$value['id']?>"></div>
    <div class="clear"></div>
</div>
<?php }*/ ?>
<?php /* ?>
<!-- Sản phẩm nổi bật xem thêm -->
<div class="wrap-product wrap-content">
    <div class="title-main"><span>Sản phẩm nổi bật xem thêm</span></div>
    <div class="page_noibat_more"></div>
</div>
<!-- Sản phẩm theo danh mục xem thêm -->
<?php foreach ($splistmenu as $k => $v) { ?>
<div class="wrap-product wrap-content">
    <div class="title-main"><span><?=$v['name'.$lang]?></span></div>
    <div class="page_danhmuc_more<?=$v['id']?>"></div>
</div>
<?php } ?>
<!-- Sản phẩm theo tab danh mục xem thêm -->
<div class="wrap-product wrap-content">
    <div class="list_monnb list_sanpham_more mb-3 text-center text-2xl">
        <a class="font-weight-bold " role="button" data-id="0">Tất cả</a>
        <?php foreach ($splistmenu as $k => $v) { ?>
        <a class="font-weight-bold " role="button" data-id="<?=$v['id']?>"><?=$v['name'.$lang]?></a>
        <?php } ?>
    </div>
    <div class="page_sanpham_more"></div>
</div>
<!-- Sản phẩm theo tab cố định xem thêm -->
<div class="wrap-product wrap-content">
    <div class="list_monnb list_tab_more mb-3 text-center text-2xl">
        <a class="font-weight-bold " data-id="find_in_set('noibat',status)">Nổi bật</a>
        <a class="font-weight-bold " data-id="find_in_set('moi',status)">Mới</a>
        <a class="font-weight-bold " data-id="find_in_set('banchay',status)">Bán chạy</a>
    </div>
    <div class="page_tabloai_more"></div>
</div>
<?php */ ?>

<?php /*
<?php if (count($splistnb)) {
    foreach ($splistnb as $vlist) { ?>
        <div class="wrap-product wrap-content">
            <div class="title-main"><span><?= $vlist['name' . $lang] ?></span></div>
            <div class="paging-product-category paging-product-category-<?= $vlist['id'] ?>" data-list="<?= $vlist['id'] ?>"></div>
        </div>
<?php }
} ?>
*/ ?>
<?php /* // Slick theo loai
<div class="box-sanpham-tc">
    <div class="wap_1200">
        <div class="list_monnb list_tab_slick">
            <a data-id="noibat">Sản phẩm nổi bật</a>
            <a data-id="banchay">Sản phẩm bán chạy</a>
        </div>
        <div class="page_tabloai_slick css_flex_ajax"></div>
    </div>
</div>
*/ ?>
<?php /* // Slick theo tab cap 1
<div class="box-sanpham-tc">
    <div class="wap_1200">
    <div class="title-main"><span>Chạy slick theo tab cấp 1</span></div>
    <div class="list_monnb list_slick">
        <a data-id="0" data-id_danhmuc="0">Tất cả</a>
        <?php foreach ($splistmenu as $k2 => $v2) { ?>
        <a data-id="<?=$v2['id']?>" data-id_danhmuc="<?=$v2['id']?>"><?=$v2['name'.$lang]?></a>
        <?php } ?>
    </div>
    <div class="page_slick css_flex_ajax"></div>
    </div>
</div>
*/ ?>

<?php /*foreach ($splistmenu as $k => $v1) {
    $product_id = $func->get_product_id('noibat','san-pham','id_list',$v1['id'],2); 
    if(count($product_id)>0){
        $sql_cap2 = ("select * from #_product_cat where type='".$v1['type']."' and find_in_set('hienthi',status) and id_list=".$v1['id']." order by numb,id desc");
        $arr_cap2=array();
        $dmc2 = $d->rawQuery($sql_cap2,$arr_cap2);
?>
<div class="box-sanpham-tc slick_theo_cap2">
    <div class="wap_1200">
    <div class="title-main"><span>Chạy slick cấp 2 <?=$v1['name'.$lang]?></span></div>
    <div class="list_monnb list_slick_cat<?=$v1['id']?>">
        <a data-id_danhmuc="<?=$v1['id']?>" data-id="0">Tất cả</a>
        <?php foreach ($dmc2 as $k2 => $v2) { ?>
        <a data-id_danhmuc="<?=$v1['id']?>" data-id="<?=$v2['id']?>"><?=$v2['name'.$lang]?></a>
        <?php } ?>
    </div>
    <div class="page_slick_cat<?=$v1['id']?> css_flex_ajax"></div>
    </div>
</div>
<?php } }*/ ?>

<?php if (count($newsnb) || count($videonb)) { ?>
    <div class="box-tintuc-video">
        <div class="wrap-content">
            <div class="wap-tin-video">
                <div class="left-intro">
                    <p class="title-intro"><span>Tin tức mới</span></p>
                    <div class="newshome-intro w-clear">
                        <a class="newshome-best text-decoration-none" href="<?= $newsnb[0][$sluglang] ?>" title="<?= $newsnb[0]['name' . $lang] ?>">
                            <?php /*<p class=" scale-img"><img onerror="this.src='<?=THUMBS?>/360x200x2/assets/images/noimage.png';" src="<?=THUMBS?>/360x200x1/<?=UPLOAD_NEWS_L.$newsnb[0]['photo']?>" alt="<?=$newsnb[0]['name'.$lang]?>" width="360" height="200"></p> */ ?>

                            <p class="pic-newshome-best scale-img"><?= $func->getImage(['class' => 'w-100', 'sizes' => '360x200x1', 'isWatermark' => WATERMARKPOST, 'prefix' => 'news', 'upload' => UPLOAD_NEWS_L, 'image' => $newsnb[0]['photo'], 'alt' => $newsnb[0]['name' . $lang]]) ?></p>
                            <h3 class="name-newshome text-split"><?= $newsnb[0]['name' . $lang] ?></h3>
                            <p class="time-newshome"><?= ngaydang ?>: <?= date("d/m/Y", $newsnb[0]['date_created']) ?></p>
                            <p class="desc-newshome text-split"><?= $newsnb[0]['desc' . $lang] ?></p>
                            <span class="view-newshome transition"><?= xemthem ?></span>
                            <?php //$optchinhanh = (isset($newsnb[0]['options']) && $newsnb[0]['options'] != '') ? json_decode($newsnb[0]['options'],true) : null;
                            //echo $optchinhanh["chucvu"]; 
                            ?>
                        </a>
                        <div class="newshome-scroll">
                            <div class="chay-tintuc-vertical">
                                <?php foreach ($newsnb as $v) { ?>
                                    <a class="newshome-normal text-decoration-none w-clear" href="<?= $v[$sluglang] ?>" title="<?= $v['name' . $lang] ?>">
                                        <p class="pic-newshome-normal scale-img"><?= $func->getImage(['class' => 'w-100', 'sizes' => '150x120x1', 'isWatermark' => WATERMARKPOST, 'prefix' => 'news', 'upload' => UPLOAD_NEWS_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?></p>
                                        <div class="info-newshome-normal">
                                            <h3 class="name-newshome text-split"><?= $v['name' . $lang] ?></h3>
                                            <p class="time-newshome"><?= ngaydang ?>: <?= date("d/m/Y", $v['date_created']) ?></p>
                                            <p class="desc-newshome text-split"><?= $v['desc' . $lang] ?></p>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-intro">
                    <p class="title-intro"><span>Video clip</span></p>
                    <div class="videohome-intro">
                        <?php echo $addons->set('video-fotorama', 'video-fotorama', 4); ?>
                        <?php /*echo $addons->set('video-slick', 'video-slick', 4);*/ ?>
                        <?php /*echo $addons->set('video-img-slick', 'video-img-slick', 4);*/ ?>
                        <?php /*echo $addons->set('video-select', 'video-select', 4);*/  ?>
                        <?php /*echo $addons->set('video-img-select', 'video-img-select', 4);*/ ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php /*
<div class="box-lienhe">
    <div class="wap_1200 css_lienhe">
        <div class="td-tc1">Đăng ký báo giá</div>
        <div class="td-tc2">Hãy điền đầy đủ thông tin vào form bên dưới.</div>
        <form class="baogia-form validation-contact col-lg-6" novalidate method="post" action="index.php" enctype="multipart/form-data">
            <div class="form-row">
                <div class="contact-input col-sm-6">
                    <input type="text" class="form-control text-sm" id="fullname-baogia" name="dataBaogia[fullname]" placeholder="<?=hoten?>" value="<?=$flash->get('fullname')?>" required />
                    <div class="invalid-feedback"><?=vuilongnhaphoten?></div>
                </div>
                <div class="contact-input col-sm-6">
                    <input type="number" class="form-control text-sm" id="phone-baogia" name="dataBaogia[phone]" placeholder="<?=sodienthoai?>" value="<?=$flash->get('phone')?>" required />
                    <div class="invalid-feedback"><?=vuilongnhapsodienthoai?></div>
                </div>         
            </div>
            <div class="form-row">
                <div class="contact-input col-sm-6">
                    <input type="email" class="form-control text-sm" id="email-baogia" name="dataBaogia[email]" placeholder="Email" value="<?=$flash->get('email')?>" required />
                    <div class="invalid-feedback"><?=vuilongnhapdiachiemail?></div>
                </div>
                <div class="contact-input col-sm-6">
                    <input type="text" class="form-control text-sm" id="address-baogia" name="dataBaogia[address]" placeholder="<?=diachi?>" value="<?=$flash->get('address')?>"  />
                    <div class="invalid-feedback"><?=vuilongnhapdiachi?></div>
                </div>
            </div>            
            <div class="contact-input">
                <textarea class="form-control text-sm" id="content-baogia" name="dataBaogia[content]" placeholder="Yêu cầu"  /><?=$flash->get('content')?></textarea>
                <div class="invalid-feedback"><?=vuilongnhapnoidung?></div>
            </div>           
            <input type="submit" class="btn btn-primary mr-2 guimail" name="submit-baogia" value="<?=dangky?>" disabled />
            <input type="hidden" name="recaptcha_response_baogia" id="recaptchaResponseContact">
        </form>
    </div>
</div>
*/ ?>

<?php /*
<?php if (count($partner)) { ?>
    <div class="wrap-partner">
        <div class="wrap-content">
            <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:2|margin:10,screen:425|items:3|margin:10,screen:575|items:4|margin:10,screen:767|items:4|margin:10,screen:991|items:5|margin:10,screen:1199|items:7|margin:10" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="300" data-autoplayspeed="500" data-autoplaytimeout="3500" data-dots="0" data-nav="1" data-navcontainer=".control-partner">
                <?php foreach ($partner as $v) { ?>
                    <div>
                        <a class="partner" href="<?= $v['link'] ?>" target="_blank" title="<?= $v['name' . $lang] ?>">
                            <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '150x120x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="control-partner control-owl transition"></div>
        </div>
    </div>
<?php } ?>
*/ ?>

<?php /*
<?php if (count($brand)) { ?>
    <div class="wrap-brand">
        <div class="wrap-content">
            <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:2|margin:10,screen:425|items:3|margin:10,screen:575|items:4|margin:10,screen:767|items:4|margin:10,screen:991|items:5|margin:10,screen:1199|items:7|margin:10" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="500" data-autoplayspeed="3500" data-dots="0" data-nav="1" data-navcontainer=".control-brand">
                <?php foreach ($brand as $v) { ?>
                    <div>
                        <a class="brand text-decoration-none" href="<?= $v[$sluglang] ?>" title="<?= $v['name' . $lang] ?>">
                            <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '150x150x2', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="control-brand control-owl transition"></div>
        </div>
    </div>
<?php } ?>
*/ ?>
<?php /*
.news-shadow{padding-bottom:30px}
.news-shadow .news-item{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;position: relative}
.news-shadow .news-shadow-time{font-size:13px;width:75px;margin-right:45px}
.news-shadow .news-shadow-time:after{content:"";position:absolute;width:20px;height:20px;top:calc(50% - 20px / 2);right:-26px;background-repeat:no-repeat;background-position:center;background-image:url(../images/pattern-news.png)}
.news-shadow .news-shadow-article{width:calc(100% - 120px);padding:14px 15px;border-radius:10px;background-color:#ffffff;border:1px solid #cecabb;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}
.news-shadow .news-shadow-article:before{content:"";position:absolute;top:calc(50% - 26px / 2);left:-13px;z-index:0;border-top:13px solid transparent;border-right:13px solid #cecabb;border-bottom:13px solid transparent}
.news-shadow .news-shadow-article:after{content:"";position:absolute;top:calc(50% - 24px / 2);left:-11px;z-index:1;border-top:12px solid transparent;border-right:11px solid #ffffff;border-bottom:12px solid transparent}
.news-shadow .news-shadow-article .news-shadow-image{margin-right:10px;width:90px}
.news-shadow .news-shadow-article .news-shadow-info{width:calc(100% - 100px)}
.news-shadow .news-shadow-article .news-shadow-info .news-shadow-name{height:36px;font-size:15px;font-weight:700}
.news-shadow .news-shadow-article .news-shadow-info .news-shadow-name a{color:#222222}
.news-shadow .news-shadow-article .news-shadow-info .news-shadow-name a:hover{color:#ec2d3f}
.news-shadow .news-shadow-article .news-shadow-info .news-shadow-name a .text-split{-webkit-line-clamp:2}
.news-shadow .news-shadow-article .news-shadow-info .news-shadow-desc{height:38px;font-size:13px}
.news-shadow .news-shadow-article .news-shadow-info .news-shadow-desc.text-split{-webkit-line-clamp:2}
<div class="box-tintuc-video">
    <div class="wrap-content py-5">
        <div class="title-main"><span>Video clip - tin tức</span></div>
        <div class="wap-tin-video">
            <div class="left-intro">
                <?php if (!empty($newsnb)) { ?>
                    <div class="news-intro position-relative">
                        <span class="news-control position-absolute transition" id="up"><i class="fas fa-chevron-up"></i></span>
                        <span class="news-control position-absolute transition" id="down"><i class="fas fa-chevron-down"></i></span>
                        <div class="news-scroll position-relative">
                            <div class="chay-tintuc-vertical">
                                <?php foreach ($newsnb as $v) { ?>  
                                        <div class="news-shadow">
                                            <div class="news-item">
                                                <div class="news-shadow-time position-relative text-capitalize text-center">
                                                    <span class="d-block"><?= $func->makeDate($v['date_created']) ?></span>
                                                    <span class="d-block"><?= date("d/m/Y", $v['date_created']) ?></span>
                                                </div>
                                                <div class="news-shadow-article position-relative">
                                                    <a class="news-shadow-image rounded-circle scale-img" href="<?= $v[$sluglang] ?>" title="<?= $v['name' . $lang] ?>">
                                                        <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '90x90x1', 'upload' => UPLOAD_NEWS_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?>
                                                    </a>
                                                    <div class="news-shadow-info">
                                                        <h3 class="news-shadow-name">
                                                            <a class="text-decoration-none transition text-split" href="<?= $v[$sluglang] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?></a>
                                                        </h3>
                                                        <div class="news-shadow-desc text-split"><?= $v['desc' . $lang] ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                   
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="right-intro">
                <div class="video-intro">
                    <?php // $addons->set('video-fotorama', 'video-fotorama', 4); ?>
                </div>
            </div>
        </div>
    </div>
</div>
*/ ?>