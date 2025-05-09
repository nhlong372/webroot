<div class="title-main"><span><?= $rowDetail['name' . $lang] ?></span></div>
<div class="content-main album-gallery css_flex_album w-clear">
    <?php if (!empty($rowDetailPhoto)) {
        foreach ($rowDetailPhoto as $k => $v) { ?>

            <?php if($source=='thuvien'){ ?>
                <a class="album text-decoration-none" rel="album-<?=$rowDetail['id']?>" href="<?=UPLOAD_PHOTO_L.$v['photo']?>" title="<?=$rowDetail['name'.$lang]?>">
                    <p class="pic-album scale-img"><img onerror="this.src='<?=THUMBS?>/480x360x2/assets/images/noimage.png';" src="<?=THUMBS?>/480x360x1/<?=UPLOAD_PHOTO_L.$v['photo']?>" alt="<?=$rowDetail['name'.$lang]?>"/></p>
                </a>

            <?php }else{ ?>

                <a class="album text-decoration-none" rel="album-<?=$rowDetail['id']?>" href="<?=UPLOAD_PRODUCT_L.$v['photo']?>" title="<?=$rowDetail['name'.$lang]?>">
                    <p class="pic-album scale-img"><img onerror="this.src='<?=THUMBS?>/480x360x2/assets/images/noimage.png';" src="<?=THUMBS?>/480x360x1/<?=UPLOAD_PRODUCT_L.$v['photo']?>" alt="<?=$rowDetail['name'.$lang]?>"/></p>
                </a>
            <?php } ?>

            <?php /*
            <div class="album col-6 col-md-4 col-lg-3 col-xl-3 mb-2 pb-1">
                <a class="album-image scale-img img-thumbnail mb-0" rel="album-<?= $rowDetail['id'] ?>" href="<?= ASSET . UPLOAD_PRODUCT_L . $v['photo'] ?>" title="<?= $rowDetail['name' . $lang] ?>">
                    <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '480x360x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $rowDetail['name' . $lang]]) ?>
                </a>
            </div>
            */ ?>
        <?php }
    } else { ?>
        <div class="col-12">
            <div class="alert alert-warning w-100" role="alert">
                <strong><?= khongtimthayketqua ?></strong>
            </div>
        </div>
    <?php } ?>
</div>