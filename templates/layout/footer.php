<div class="footer">
    <div class="footer-article">
        <div class="wrap-content">
            <div class="wap_footer">
                <div class="footer-news">
                    <p class="footer-title"><?=$setting['name' . $lang] ?></p>
                    <div class="footer-info"><?=$func->decodeHtmlChars($footer['content' . $lang]) ?></div>
                    <?php /* ?><ul>
                        <li class="w-clear"><i class="fas fa-map-marker-alt"></i><span></span><?=$optsetting['address']?></li>
                        <li class="w-clear"><i class="fas fa-phone-volume"></i><span></span><?=$optsetting['phone']?></li>
                        <li class="w-clear"><i class="fas fa-envelope"></i><span></span><?=$optsetting['email']?></li>
                        <li class="w-clear"><i class="fas fa-globe"></i><span></span><?=$optsetting['website']?></li>
                    </ul><?php */ ?>
                </div>
                <div class="footer-news">
                    <p class="footer-title"><?= chinhsach ?></p>
                    <ul class="footer-ul">
                        <?php foreach ($policy as $v) { ?>
                            <li><a href="<?= $v[$sluglang] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="footer-news">
                    <p class="footer-title"><?= mangxahoi ?></p>
                    <ul class="social footer-social">
                        <?php foreach($social as $k => $v) { ?>
                            <li><a href="<?=$v['link']?>" target="_blank"><img src="<?=UPLOAD_PHOTO_L.$v['photo']?>" alt="<?=$v['name'.$lang]?>" width="40" height="40"><span><?=$v['name'.$lang]?></span></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="footer-news">
                    <p class="footer-title">Fanpage facebook</p>
                    <?= $addons->set('fanpage-facebook', 'fanpage-facebook', 2); ?>
                </div>
            </div>
        </div>
    </div>
    <?php /*
    <div class="footer-tags">
        <div class="wrap-content">
            <p class="footer-title">Tags sản phẩm:</p>
            <ul class="footer-tags-lists w-clear mb-3">
                <?php foreach ($tagsProduct as $v) { ?>
                    <li class="mr-1 mb-1"><a class="btn btn-sm btn-danger rounded" href="<?= $v[$sluglang] ?>" target="_blank" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?></a></li>
                <?php } ?>
            </ul>
            <p class="footer-title">Tags tin tức:</p>
            <ul class="footer-tags-lists w-clear">
                <?php foreach ($tagsNews as $v) { ?>
                    <li class="mr-1 mb-1"><a class="btn btn-sm btn-danger rounded" href="<?= $v[$sluglang] ?>" target="_blank" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    */ ?>
    <div class="footer-powered">
        <div class="wrap-content">
            <div class="wap_copy">
                <div class="footer-copyright">Copyright © <?= date("Y", time()) ?> <span><?=$setting['name'.$lang]?></span>. All rights reserved. Designed by <a href="https://nina.vn/" target="_blank">Nina</a></div>
                <div class="footer-statistic">
                    <span><?= dangonline ?>: <?= $online ?></span>
                    <span><?= homnay ?>: <?= $counter['today'] ?></span>
                    <?php /*
                    <span><?= homqua ?>: <?= $counter['yesterday'] ?></span>
                    <span><?= trongtuan ?>: <?= $counter['week'] ?></span>
                    <span><?= trongthang ?>: <?= $counter['month'] ?></span>
                    */ ?>
                    <span><?= tongtruycap ?>: <?= $counter['total'] ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php /*if(count($chinhanh)>0){ 
            $optnews0 = (isset($chinhanh[0]['options2']) && $chinhanh[0]['options2'] != '') ? json_decode($chinhanh[0]['options2'],true) : null;?>
        <div class="box-hethong">
            <div class="ht-left">
                <?php for($i=0;$i<count($chinhanh);$i++){
                    $optnews = (isset($chinhanh[$i]['options2']) && $chinhanh[$i]['options2'] != '') ? json_decode($chinhanh[$i]['options2'],true) : null;
                    ?>
                    <div class="item-ht" data-id="<?=$chinhanh[$i]['id']?>">
                        <span class="ten"><i class="fal fa-map-marker-alt"></i> <?=$chinhanh[$i]['name'.$lang]?></span> 
                    </div>
                <?php } ?>
            </div>
            <div class="ht-right">
                <?=$optnews0['bando']?>
            </div>
        </div>
    <?php }else{*/ ?>
    <?php echo $addons->set('footer-map', 'footer-map', 6); //} ?>
    <?php //echo $addons->set('messages-facebook', 'messages-facebook', 2); ?>
</div>
<?php if ($com != 'yeu-thich' and FAVORITEPRODUCT) { ?>
<a class="liked-fixed text-decoration-none" href="yeu-thich" title="Danh sách yêu thích">
    <i class="fas fa-heart"></i>
    <span class="count-like"><?= (!empty($_SESSION['list_saved'])) ? count(json_decode($_SESSION['list_saved'], true)) : 0 ?></span>
</a>
<?php } ?>
<?php if ($com != 'gio-hang' and CARTSITE) { ?>
    <a class="cart-fixed text-decoration-none" href="gio-hang" title="Giỏ hàng">
        <i class="fa-solid fa-cart-shopping fa-lg"></i>
        <span class="count-cart"><?= (!empty($_SESSION['cart'])) ? count($_SESSION['cart']) : 0 ?></span>
    </a>
<?php } ?>

<a class="btn-map btn-frame text-decoration-none" target="_blank" href="<?= $optsetting['map'] ?>">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'mp.png', 'alt' => 'Map']) ?></i>
</a>

<a class="btn-zalo btn-frame text-decoration-none" target="_blank" href="https://zalo.me/<?= preg_replace('/[^0-9]/', '', $optsetting['zalo']); ?>">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'zl.png', 'alt' => 'Zalo']) ?></i>
</a>

<a class="btn-phone btn-frame text-decoration-none" href="tel:<?= preg_replace('/[^0-9]/', '', $optsetting['hotline']); ?>">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'hl.png', 'alt' => 'Hotline']) ?></i>
</a>

<a class="btn-messenger btn-frame text-decoration-none" target="_blank" href="<?= $optsetting['messenger'] ?>">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'mg.png', 'alt' => 'Messenger']) ?></i>
</a>

<!-- <a href="javascript:void();" class="btn-datlich" data-toggle="modal" data-target=".booking"><i class="far fa-calendar-alt"></i><br>Đặt lịch</a> -->

<div class="progress-wrap cursor-pointer">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>