<?php
include "config.php";

$id_color = (!empty($_POST['id_color'])) ? htmlspecialchars($_POST['id_color']) : 0;
$id_pro = (!empty($_POST['id_pro'])) ? htmlspecialchars($_POST['id_pro']) : 0;
$rowDetailPhoto = $d->rawQuery("select photo, id_parent, id from #_gallery where id_color = ? and id_parent = ? and com = ? and type = ? and kind = ? and val = ?", array($id_color, $id_pro, 'product', 'san-pham', 'man', 'san-pham'));
$rowDetail = $d->rawQueryOne("select name$lang, photo from #_product where id = ? and type = ? limit 0,1", array($id_pro, 'san-pham'));
?>
<?php if (!empty($rowDetailPhoto)) { ?>
    <a id="Zoom-1" class="MagicZoom" data-options="zoomMode: off; hint: off; rightClick: true; selectorTrigger: hover; expandCaption: false; history: false;" href="<?= ASSET . WATERMARK ?>/product/540x540x1/<?= UPLOAD_PRODUCT_L . $rowDetailPhoto[0]['photo'] ?>" title="<?= $rowDetail['name' . $lang] ?>">
        <?= $func->getImage(['isLazy' => false, 'sizes' => '540x540x1', 'isWatermark' => true, 'prefix' => 'product', 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetailPhoto[0]['photo'], 'alt' => $rowDetail['name' . $lang]]) ?>
    </a>
    <div class="gallery-thumb-pro">
        <div class="owl-page owl-carousel owl-theme owl-pro-detail" data-items="screen:0|items:5|margin:10" data-nav="1" data-navcontainer=".control-pro-detail">
            <?php foreach ($rowDetailPhoto as $v) { ?>
                <a class="thumb-pro-detail" data-zoom-id="Zoom-1" href="<?= ASSET . WATERMARK ?>/product/540x540x1/<?= UPLOAD_PRODUCT_L . $v['photo'] ?>" title="<?= $rowDetail['name' . $lang] ?>">
                    <?= $func->getImage(['isLazy' => false, 'sizes' => '540x540x1', 'isWatermark' => true, 'prefix' => 'product', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $rowDetail['name' . $lang]]) ?>
                </a>
            <?php } ?>
        </div>
        <div class="control-pro-detail control-owl transition"></div>
    </div>
<?php } ?>