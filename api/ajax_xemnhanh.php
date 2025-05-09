<?php
include "config.php";

$id = (isset($_POST['id']) && $_POST['id'] > 0) ? htmlspecialchars($_POST['id']) : 0;
$rowDetail = $d->rawQueryone(" select * from #_product where id = '" . $id . "'  ");
$thumb = '1066x540x2';
/* Lấy màu */
$productColor = $d->rawQuery("select id_color from #_product_sale_color where id_parent = ?", array($rowDetail['id']));
$productColor = (!empty($productColor)) ? $func->joinCols($productColor, 'id_color') : array();
if (!empty($productColor)) {
  $rowColor = $d->rawQuery("select type_show, photo, color, id from #_color where type='" . $type . "' and id in ($productColor) and find_in_set('hienthi',status) order by numb,id desc");
}
/* Lấy size */
$productSize = $d->rawQuery("select id_size from #_product_sale_size where id_parent = ?", array($rowDetail['id']));
$productSize = (!empty($productSize)) ? $func->joinCols($productSize, 'id_size') : array();
if (!empty($productSize)) {
  $rowSize = $d->rawQuery("select id, name$lang from #_size where type='" . $type . "' and id in ($productSize) and find_in_set('hienthi',status) order by numb,id desc");
}
/* Cập nhật lượt xem */
$views = array();
$views['view'] = $rowDetail['view'] + 1;
$d->where('id', $rowDetail['id']);
$d->update('product', $views);
/* Lấy hình con */
if (!empty($rowDetail)) {
  $rowDetailPhoto = $d->rawQuery("select photo from #_gallery where id_parent = ? and com='product' and type = ? and kind='man' and val = ? and find_in_set('hienthi',status) order by numb,id desc", array($id, 'san-pham', 'san-pham'));
?>
  <div id="layout-pro-quickview">
    <div class="left-pro-detail col-md-6 col-lg-5 mb-4">
      <a id="pro-detail-photo" class="" href="<?= $rowDetail[$sluglang] ?>">
        <?= $func->getImage(['isLazy' => false, 'sizes' => '540x540x2', 'isWatermark' => WATERMARKPRODUCT, 'prefix' => 'product', 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetail['photo'], 'alt' => $rowDetail['name' . $lang]]) ?>
      </a>
      <?php if ($rowDetailPhoto) {
        if (count($rowDetailPhoto) > 0) { ?>
          <div class="gallery-thumb-pro">
            <div class="owl-page owl-carousel owl-theme owl-pro-detail" data-items="screen:0|items:5|margin:10" data-nav="1" data-navcontainer=".control-pro-detail">
              <div>
                <a class="thumb-pro-detail" data-zoom-id="Zoom-1" href="<?= ASSET . THUMBS ?>/540x540x2/<?= UPLOAD_PRODUCT_L . $rowDetail['photo'] ?>" title="<?= $rowDetail['name' . $lang] ?>">
                  <?= $func->getImage(['isLazy' => false, 'sizes' => '540x540x2', 'isWatermark' => WATERMARKPRODUCT, 'prefix' => 'product', 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetail['photo'], 'alt' => $rowDetail['name' . $lang]]) ?>
                </a>
              </div>
              <?php foreach ($rowDetailPhoto as $v) { ?>
                <div>
                  <a class="thumb-pro-detail" data-zoom-id="Zoom-1" href="<?= ASSET . THUMBS ?>/540x540x2/<?= UPLOAD_PRODUCT_L . $v['photo'] ?>" title="<?= $rowDetail['name' . $lang] ?>">
                    <?= $func->getImage(['isLazy' => false, 'sizes' => '540x540x2', 'isWatermark' => WATERMARKPRODUCT, 'prefix' => 'product', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $rowDetail['name' . $lang]]) ?>
                  </a>
                </div>
              <?php } ?>
            </div>
            <div class="control-pro-detail control-owl transition"></div>
          </div>
      <?php }
      } ?>
    </div>

    <div class="right-pro-detail col-md-6 col-lg-7 mb-4">
      <p class="title-pro-detail mb-2"><?= $rowDetail['name' . $lang] ?></p>
      <ul class="attr-pro-detail">
        <?php if (!empty($rowDetail['code'])) { ?>
          <li class="w-clear">
            <label class="attr-label-pro-detail"><b><?= masp ?>:</b></label>
            <div class="attr-content-pro-detail"><?= $rowDetail['code'] ?></div>
          </li>
        <?php } ?>
        <li class="w-clear">
          <label class="attr-label-pro-detail"><b><?= gia ?>:</b></label>
          <div class="attr-content-pro-detail">
            <?php if ($rowDetail['sale_price']) { ?>
              <span class="price-new-pro-detail"><?= $func->formatMoney($rowDetail['sale_price']) ?></span>
              <span class="price-old-pro-detail"><?= $func->formatMoney($rowDetail['regular_price']) ?></span>
            <?php } else { ?>
              <span class="price-new-pro-detail"><?= ($rowDetail['regular_price']) ? $func->formatMoney($rowDetail['regular_price']) : lienhe ?></span>
            <?php } ?>
          </div>
        </li>
        <li class="w-clear">
          <label class="attr-label-pro-detail"><b><?= luotxem ?>:</b></label>
          <div class="attr-content-pro-detail"><?= $rowDetail['view'] ?></div>
        </li>
        <?php  //Dành cho giỏ hàng size - color không đổi giá 
        if (CARTSITE == true) {
        ?>
          <li class="color-block-pro-detail w-clear">
            <label class="attr-label-pro-detail d-block"><b><?= mausac ?>:</b></label>
            <div class="attr-content-pro-detail d-block">
              <?php foreach ($rowColor as $k => $v) { ?>
                <?php if ($v['type_show'] == 1) { ?>
                  <label for="color-pro-detail-<?= $v['id'] ?>" class="color-pro-detail text-decoration-none" data-idproduct="<?= $rowDetail['id'] ?>" style="background-image: url(<?= UPLOAD_COLOR_L . $v['photo'] ?>)">
                    <input type="radio" value="<?= $v['id'] ?>" id="color-pro-detail-<?= $v['id'] ?>" name="color-pro-detail">
                  </label>
                <?php } else { ?>
                  <label for="color-pro-detail-<?= $v['id'] ?>" class="color-pro-detail text-decoration-none" data-idproduct="<?= $rowDetail['id'] ?>" style="background-color: #<?= $v['color'] ?>">
                    <input type="radio" value="<?= $v['id'] ?>" id="color-pro-detail-<?= $v['id'] ?>" name="color-pro-detail">
                  </label>
                <?php } ?>
              <?php } ?>
            </div>
          </li>
          <li class="size-block-pro-detail w-clear">
            <label class="attr-label-pro-detail d-block"><b><?= kichthuoc ?>:</b></label>
            <div class="attr-content-pro-detail d-block">
              <?php foreach ($rowSize as $k => $v) { ?>
                <label for="size-pro-detail-<?= $v['id'] ?>" class="size-pro-detail text-decoration-none">
                  <input type="radio" value="<?= $v['id'] ?>" id="size-pro-detail-<?= $v['id'] ?>" name="size-pro-detail">
                  <?= $v['name' . $lang] ?>
                </label>
              <?php } ?>
            </div>
          </li>
          <li class="w-clear quantity-block-pro-detail">
            <label class="attr-label-pro-detail d-block"><b><?= soluong ?>:</b></label>
            <div class="attr-content-pro-detail d-block">
              <div class="quantity-pro-detail">
                <span class="quantity-minus-pro-detail">-</span>
                <input type="number" class="qty-pro" min="1" value="1" readonly />
                <span class="quantity-plus-pro-detail">+</span>
              </div>
            </div>
          </li>
        <?php } ?>
      </ul>
      <?php /*if(OPENDESC == true) {*/ ?>
      <div class="mota">
        <b><?= motasanpham ?>:</b>&nbsp
        <span class="catchuoi5"><?= $rowDetail['desc' . $lang] ?></span>
      </div>
      <?php /*}*/ ?>
      <?php if (CARTSITE == true) { ?>
        <div class="cart-pro-detail">
          <a class="btn btn-success addcart rounded-0 mr-2" data-id="<?= $rowDetail['id'] ?>" data-action="addnow">
            <i class="fa-sharp fa-regular fa-cart-plus mr-1"></i>
            <span>Thêm vào giỏ hàng</span>
          </a>
          <a class="btn btn-dark addcart rounded-0" data-id="<?= $rowDetail['id'] ?>" data-action="buynow">
            <i class="fa-sharp fa-regular fa-cash-register mr-1"></i>
            <span>Mua ngay</span>
          </a>
        </div>
      <?php } ?>
    </div>
    <script src="assets/magiczoomplus/magiczoomplus.js"></script>
    <script src="assets/owlcarousel2/owl.carousel.js"></script>
  <?php } ?>