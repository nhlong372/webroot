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
// Vào layout/copde index.php để biết đầy đủ code
*/ ?>

<!-- Sản phẩm nổi bật -->
<div class="wrap-product wrap-content">
    <div class="title-main"><span>Sản phẩm nổi bật</span></div>
    <div class="page_noibat"></div>
</div>

<div class="wrap-product wrap-content">
    <div class="title-main"><span>Sản phẩm nổi bật xem thêm</span></div>
    <div class="page_noibat_more"></div>
</div>

<div class="box-sanpham-tc">
    <div class="wrap-content">
        <div class="title-main"><span>Sản phẩm theo tab loại slick</span></div>
        <div class="list_monnb list_tab_slick">
            <a data-id="noibat">Sản phẩm nổi bật</a>
            <a data-id="banchay">Sản phẩm bán chạy</a>
        </div>
        <div class="page_tabloai_slick css_flex_ajax"></div>
    </div>
</div>

<!-- Sản phẩm theo danh mục cấp 1-->
<?php /*foreach ($splistmenu as $k => $v) {
    $product_id = $func->get_product_id('noibat', 'san-pham', 'id_list', $v['id'], 2);
    if ($product_id) {
?>
        <div class="wrap-product wrap-content">
            <div class="title-main"><span><?= $v['name' . $lang] ?></span></div>
            <div class="page_danhmuc page_danhmuc<?= $v['id'] ?>"></div>
        </div>
<?php }
} */ ?>


<!-- Sản phẩm theo tab danh mục cấp 1-->
<?php /*<div class="wrap-product wrap-content">
    <div class="list_monnb list_sanpham mb-3 text-center text-2xl">
        <a class="font-weight-bold " role="button" data-id="0"><?=tatca?></a>
        <?php foreach ($splistmenu as $k => $v) { ?>
            <a class="font-weight-bold " role="button" data-id="<?= $v['id'] ?>"><?= $v['name' . $lang] ?></a>
        <?php } ?>
    </div>
    <div class="page_sanpham"></div>
</div>*/ ?>

<!-- Sản phẩm theo tab cố định -->
<?php /*<div class="wrap-product wrap-content">
    <div class="list_monnb list_tab mb-3 text-center text-2xl">
        <a class="font-weight-bold " data-id="find_in_set('noibat',status)">Nổi bật</a>
        <a class="font-weight-bold " data-id="find_in_set('moi',status)">Mới</a>
        <a class="font-weight-bold " data-id="find_in_set('banchay',status)">Bán chạy</a>
    </div>
    <div class="page_tabloai"></div>
</div>*/ ?>

<?php /* <div class="wrap-feedback">
    <div class="wrap-content">
        <div class="chay-cn">
            <?php foreach ($feedback as $key => $value) { ?>
                <a class="news text-decoration-none w-clear" title="<?= $value['name' . $lang] ?>">
                    <p class="pic-news scale-img">
                        <?= $func->getImage(['class' => 'w-100', 'sizes' => '131x165x1', 'upload' => UPLOAD_NEWS_L, 'image' => $value['photo'], 'alt' => $value['name' . $lang]]) ?>
                    </p>
                    <div class="info-news">
                        <h3 class="name-news"><?= $value['name' . $lang] ?></h3>
                        <div class="desc-news text-split"><?= $value['desc' . $lang] ?></div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</div> */ ?>


<?php /* <div class="wrap-tiktok">
    <div class="title-main"><span>Tiktok</span></div>
    <div class="layout-tiktok">
        <?= $addons->set('tiktok', 'tiktok', 2); ?>
    </div>
</div> */ ?>

<?php if (count($newsnb) || count($videonb)) { ?>
    <div class="wrap-news-video">
        <div class="wrap-content">
            <div class="layout-news-video">
                <div class="layout-news">
                    <div class="title-main"><span>Tin tức nổi bật</span></div>
                    <div class="chay-tintuc">
                        <?=$func->lay_tintuc($newsnb,'news','355x266x1')?>
                    </div>
                </div>
                <div class="layout-video">
                    <div class="title-main"><span>Video Nổi Bật</span></div>
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

<div class="wrap-sign">
    <div class="wrap-content">
        <div class="layout-sign">
            <div class="title-main"><span>Đăng ký nhận tin</span></div>
            <form class="validation-newsletter check-validate" novalidate method="post" id="form-newsletter" action="" enctype="multipart/form-data">
                <div class="newsletter-input">
                    <input type="text" class="form-control text-sm" id="fullname-newsletter" name="dataNewsletter[fullname]" placeholder="Họ và tên" required />
                    <div class="invalid-feedback"><?= vuilongnhaphoten ?></div>
                </div>

                <div class="newsletter-input">
                    <input type="number" class="form-control text-sm" id="phone-newsletter" name="dataNewsletter[phone]" placeholder="Số điện thoại" required />
                    <div class="invalid-feedback"><?= vuilongnhapsodienthoai ?></div>
                </div>

                <div class="newsletter-input">
                    <input type="email" class="form-control text-sm" id="email-newsletter" name="dataNewsletter[email]" placeholder="Email" required />
                    <div class="invalid-feedback"><?= vuilongnhapdiachiemail ?></div>
                </div>
                <div class="newsletter-button">
                    <input type="submit" class="btn btn-sm btn-danger w-100 btn-send" data-loai="newsletter" value="Gửi ngay" disabled>
                    <input type="hidden" name="submit-newsletter" value="1">
                    <input type="hidden" name="recaptcha_response_newsletter" id="recaptchaResponseNewsletter">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Sản phẩm theo danh mục cấp 1 & 2 -->
<?php /*foreach ($splistmenu as $key => $value) {
    $product_id = $func->get_product_id('noibat','san-pham','id_list',$v1['id'],2);
    if($product_id){
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
        <a class="mr-2 font-weight-bold" data-id="0"><?=tatca?></a>
        <?php foreach ($spcatmenu as $key2 => $value2) { ?>
        <a class="mr-2 font-weight-bold" data-id="<?=$value2['id']?>"><?=$value2['name'.$lang]?></a>
        <?php } ?>
    </div>
    <div class="page_danhmuc page_danhmuc_list<?=$value['id']?>"></div>
    <div class="clear"></div>
</div>
<?php } }*/ ?>
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
        <a class="font-weight-bold " role="button" data-id="0"><?=tatca?></a>
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
    <div class="wrap-content">
        <div class="list_monnb list_tab_slick">
            <a data-id="noibat">Sản phẩm nổi bật</a>
            <a data-id="banchay">Sản phẩm bán chạy</a>
        </div>
        <div class="page_tabloai_slick css_flex_ajax"></div>
    </div>
</div>
*/ ?>

<!-- Slick theo tab cấp 1 -->
<?php /* <div class="box-sanpham-tc">
    <div class="wrap-content">
    <div class="title-main"><span>Chạy slick theo tab cấp 1</span></div>
    <div class="list_monnb list_slick">
        <a data-id="0" data-id_danhmuc="0"><?=tatca?></a>
        <?php foreach ($splistmenu as $k2 => $v2) { ?>
        <a data-id="<?=$v2['id']?>" data-id_danhmuc="<?=$v2['id']?>"><?=$v2['name'.$lang]?></a>
        <?php } ?>
    </div>
    <div class="page_slick css_flex_ajax"></div>
    </div>
</div> */ ?>
<?php /*foreach ($splistmenu as $k => $v1) {
    $product_id = $func->get_product_id('noibat','san-pham','id_list',$v1['id'],2); 
    if(count($product_id)>0){
        $sql_cap2 = ("select * from #_product_cat where type='".$v1['type']."' and find_in_set('hienthi',status) and id_list=".$v1['id']." order by numb,id desc");
        $arr_cap2=array();
        $dmc2 = $d->rawQuery($sql_cap2,$arr_cap2);
?>
<div class="box-sanpham-tc slick_theo_cap2">
    <div class="wrap-content">
    <div class="title-main"><span>Chạy slick cấp 2 <?=$v1['name'.$lang]?></span></div>
    <div class="list_monnb list_slick_cat<?=$v1['id']?>">
        <a data-id_danhmuc="<?=$v1['id']?>" data-id="0"><?=tatca?></a>
        <?php foreach ($dmc2 as $k2 => $v2) { ?>
        <a data-id_danhmuc="<?=$v1['id']?>" data-id="<?=$v2['id']?>"><?=$v2['name'.$lang]?></a>
        <?php } ?>
    </div>
    <div class="page_slick_cat<?=$v1['id']?> css_flex_ajax"></div>
    </div>
</div>
<?php } }*/ ?>

<?php /*<div class="box-brand">
    <div class="wrap-content">
        <div class="layout-brand">
                <div class="title-main"><span>Thương hiệu nổi bật</span></div>
                <div class="list_monnb list_tab_brand  mb-3 text-center text-2xl">
                    <?php foreach ($brand as $k => $v) { ?>
                        <a class="font-weight-bold" role="button" data-id="<?= $v['id'] ?>"><?=$v['name' . $lang]?></a>
                    <?php } ?>
                </div>
                <div class="page_slick_thuonghieu"></div>
        </div>
    </div>
</div> */ ?>


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
<p class="title-intro"><span>liên hệ báo giá</span></p>                
                <p class="newsletter-slogan"><?=$slogank[3]['desc'.$lang]?></p>
                <form class="validation-newsletter newsletter-form" novalidate method="post" action="" enctype="multipart/form-data">
                    <div class="w-clear chia2">
                        <div class="newsletter-input">
                            <input type="text" class="form-control text-sm" id="fullname-newsletter" name="dataNewsletter[fullname]" placeholder="<?=hoten?>" required />
                            <div class="invalid-feedback"><?=vuilongnhaphoten?></div>
                        </div>
                        <div class="newsletter-input">
                            <input type="number" class="form-control text-sm" id="phone-newsletter" name="dataNewsletter[phone]" placeholder="<?=sodienthoai?>" required />
                            <div class="invalid-feedback"><?=vuilongnhapsodienthoai?></div>
                        </div>
                    </div>
                    <div class="w-clear chia2">
                        <div class="newsletter-input">
                            <input type="email" class="form-control text-sm" id="email-newsletter" name="dataNewsletter[email]" placeholder="Email" required />
                            <div class="invalid-feedback"><?= vuilongnhapdiachiemail ?></div>
                        </div>
                        <div class="newsletter-input">
                            <input type="text" class="form-control text-sm" id="address-newsletter" name="dataNewsletter[address]" placeholder="<?=diachi?>" />
                            <div class="invalid-feedback"><?=vuilongnhapdiachi?></div>
                        </div>
                    </div> 
                    <div class="newsletter-input">
                        <textarea type="text" class="form-control text-sm" id="content-newsletter" name="dataNewsletter[content]" placeholder="<?=noidung?>" ></textarea>
                        <div class="invalid-feedback"><?=vuilongnhapnoidung?></div>
                    </div>
                    <div class="newsletter-button">
                        <input type="submit" class="btn btn-sm btn-danger w-100 guimail" value="Gửi ngay" disabled>
                        <input type="hidden" name="submit-newsletter" value="1">
                        <input type="hidden" name="recaptcha_response_newsletter" id="recaptchaResponseNewsletter">
                    </div>
                </form>
*/ ?>