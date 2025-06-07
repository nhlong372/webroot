<?php
$options = (isset($item['options']) && $item['options'] != '') ? json_decode($item['options'], true) : null;
$options2 = (isset($item['options2']) && $item['options2'] != '') ? json_decode($item['options2'], true) : null;
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = "Chỉnh sửa";
else if ($act == "copy")  $labelAct = "Sao chép";

$linkMan = "index.php?com=product&act=man&type=" . $type;
if ($act == 'add') $linkFilter = "index.php?com=product&act=add&type=" . $type;
else if ($act == 'edit') $linkFilter = "index.php?com=product&act=edit&type=" . $type . "&id=" . $id;
if ($act == "copy") $linkSave = "index.php?com=product&act=save_copy&type=" . $type;
else $linkSave = "index.php?com=product&act=save&type=" . $type;

/* Check cols */
if (isset($config['product'][$type]['gallery']) && count($config['product'][$type]['gallery']) > 0) {
    foreach ($config['product'][$type]['gallery'] as $key => $value) {
        if ($key == $type) {
            $keyGallery = $key;
            $flagGallery = true;
            break;
        }
    }
}

if (
    (isset($config['product'][$type]['dropdown']) && $config['product'][$type]['dropdown'] == true) ||
    (isset($config['product'][$type]['other']) && $config['product'][$type]['other'] == true) ||
    (isset($config['product'][$type]['brand']) && $config['product'][$type]['brand'] == true) ||
    (isset($config['product'][$type]['tags']) && $config['product'][$type]['tags'] == true) ||
    (isset($config['product'][$type]['color']) && $config['product'][$type]['color'] == true) ||
    (isset($config['product'][$type]['size']) && $config['product'][$type]['size'] == true) ||
    (isset($config['product'][$type]['images']) && $config['product'][$type]['images'] == true)
) {
    $colLeft = "col-xl-8";
    $colRight = "col-xl-4";
} else {
    $colLeft = "col-12";
    $colRight = "d-none";
}
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?> <?= $config['product'][$type]['title_main'] ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i>Lưu tại trang</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="row">
            <div class="<?= $colLeft ?>">
                <?php
                if (isset($config['product'][$type]['slug']) && $config['product'][$type]['slug'] == true) {
                    $slugchange = ($act == 'edit') ? 1 : 0;
                    $copy = ($act != 'copy') ? 0 : 1;
                    include TEMPLATE . LAYOUT . "slug.php";
                }
                ?>
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung <?= $config['product'][$type]['title_main'] ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                                    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang" data-toggle="pill" href="#tabs-lang-<?= $k ?>" role="tab" aria-controls="tabs-lang-<?= $k ?>" aria-selected="true"><?= $v ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="card-body card-article">
                                <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                        <div class="tab-pane fade show <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang-<?= $k ?>" role="tabpanel" aria-labelledby="tabs-lang">
                                            <div class="form-group">
                                                <label for="name<?= $k ?>">Tiêu đề (<?= $k ?>):</label>
                                                <input type="text" class="form-control for-seo text-sm" name="data[name<?= $k ?>]" id="name<?= $k ?>" placeholder="Tiêu đề (<?= $k ?>)" value="<?= (!empty($flash->has('name' . $k))) ? $flash->get('name' . $k) : @$item['name' . $k] ?>" required>
                                            </div>
                                            <?php if (isset($config['product'][$type]['desc']) && $config['product'][$type]['desc'] == true) { ?>
                                                <div class="form-group">
                                                    <label for="desc<?= $k ?>">Mô tả (<?= $k ?>):</label>
                                                    <textarea class="form-control for-seo text-sm <?= (isset($config['product'][$type]['desc_cke']) && $config['product'][$type]['desc_cke'] == true) ? 'form-control-ckeditor' : '' ?>" name="data[desc<?= $k ?>]" id="desc<?= $k ?>" rows="5" placeholder="Mô tả (<?= $k ?>)"><?= $func->decodeHtmlChars($flash->get('desc' . $k)) ?: $func->decodeHtmlChars(@$item['desc' . $k]) ?></textarea>
                                                </div>
                                            <?php } ?>
                                            <?php if (isset($config['product'][$type]['content']) && $config['product'][$type]['content'] == true) { ?>
                                                <div class="form-group">
                                                    <label for="content<?= $k ?>">Nội dung (<?= $k ?>):</label>
                                                    <textarea class="form-control for-seo text-sm <?= (isset($config['product'][$type]['content_cke']) && $config['product'][$type]['content_cke'] == true) ? 'form-control-ckeditor' : '' ?>" name="data[content<?= $k ?>]" id="content<?= $k ?>" rows="5" placeholder="Nội dung (<?= $k ?>)"><?= $func->decodeHtmlChars($flash->get('content' . $k)) ?: $func->decodeHtmlChars(@$item['content' . $k]) ?></textarea>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="<?= $colRight ?>">
                <?php if (
                    (isset($config['product'][$type]['dropdown']) && $config['product'][$type]['dropdown'] == true) ||
                    (isset($config['product'][$type]['brand']) && $config['product'][$type]['brand'] == true) ||
                    (isset($config['product'][$type]['tags']) && $config['product'][$type]['tags'] == true) ||
                    (isset($config['product'][$type]['color']) && $config['product'][$type]['color'] == true) ||
                    (isset($config['product'][$type]['size']) && $config['product'][$type]['size'] == true)
                ) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Danh mục <?= $config['product'][$type]['title_main'] ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group-category row">
                                <?php if (isset($config['product'][$type]['dropdown']) && $config['product'][$type]['dropdown'] == true) { ?>
                                    <?php if (isset($config['product'][$type]['list']) && $config['product'][$type]['list'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_list">Danh mục cấp 1:</label>
                                            <?= $func->getAjaxCategory('product', 'list', $type) ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($config['product'][$type]['cat']) && $config['product'][$type]['cat'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_cat">Danh mục cấp 2:</label>
                                            <?= $func->getAjaxCategory('product', 'cat', $type) ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($config['product'][$type]['item']) && $config['product'][$type]['item'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_item">Danh mục cấp 3:</label>
                                            <?= $func->getAjaxCategory('product', 'item', $type) ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($config['product'][$type]['sub']) && $config['product'][$type]['sub'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_sub">Danh mục cấp 4:</label>
                                            <?= $func->getAjaxCategory('product', 'sub', $type) ?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (isset($config['product'][$type]['brand']) && $config['product'][$type]['brand'] == true) { ?>
                                    <div class="form-group col-xl-6 col-sm-4">
                                        <label class="d-block" for="id_brand">Danh mục hãng:</label>
                                        <?= $func->getAjaxCategory('product', 'brand', $type, 'Chọn hãng') ?>
                                    </div>
                                <?php } ?>
                                <?php if (isset($config['product'][$type]['tags']) && $config['product'][$type]['tags'] == true) { ?>
                                    <div class="form-group col-xl-6 col-sm-4">
                                        <label class="d-block" for="id_tags">Danh mục tags:</label>
                                        <?= $func->getTags(@$item['id'], 'dataTags', 'product_tags', $type) ?>
                                    </div>
                                <?php } ?>
                                <?php if (CARTSITEADVANCE == true) { ?>
                                    <?php if (isset($config['product'][$type]['color']) && $config['product'][$type]['color'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_color">Danh mục màu sắc:</label>
                                            <?= $func->getColorSale(@$item['id']) ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($config['product'][$type]['size']) && $config['product'][$type]['size'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_size">Danh mục kích thước:</label>
                                            <?= $func->getSizeSale(@$item['id']) ?>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php if (isset($config['product'][$type]['color']) && $config['product'][$type]['color'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_color">Danh mục màu sắc:</label>
                                            <?= $func->getColor(@$item['id']) ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($config['product'][$type]['size']) && $config['product'][$type]['size'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_size">Danh mục kích thước:</label>
                                            <?= $func->getSize(@$item['id']) ?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($config['product'][$type]['images']) && $config['product'][$type]['images'] == true) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh <?= $config['product'][$type]['title_main'] ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            /* Photo detail */
                            $photoDetail = array();
                            $photoDetail['upload'] = UPLOAD_PRODUCT_L;
                            $photoDetail['image'] = (!empty($item) && $act != 'copy') ? $item['photo'] : '';
                            $photoDetail['dimension'] = "Width: " . $config['product'][$type]['width'] . " px - Height: " . $config['product'][$type]['height'] . " px (" . $config['product'][$type]['img_type'] . ")";

                            /* Image */
                            include TEMPLATE . LAYOUT . "image.php";
                            ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($config['product'][$type]['images2']) && $config['product'][$type]['images2'] == true) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh <?= $config['product'][$type]['title_main'] ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            $photoDetail2 = ($act != 'copy') ? UPLOAD_PRODUCT . @$item['photo2'] : '';
                            $dimension2 = "Width: " . $config['product'][$type]['width2'] . " px - Height: " . $config['product'][$type]['height2'] . " px (" . $config['product'][$type]['img_type'] . ")";
                            /* Image */
                            include TEMPLATE . LAYOUT . "image2.php";
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin của <?= $config['product'][$type]['title_main'] ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="numb" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                </div>

                <div class="form-group">
                    <?php $status_array = (!empty($item['status'])) ? explode(',', $item['status']) : array(); ?>
                    <?php if ($_GET['act'] == 'add') { ?>
                        <?php if (isset($config['product'][$type]['check'])) {
                            foreach ($config['product'][$type]['check'] as $key => $value) { ?>
                                <div class="form-group d-inline-block mb-2 mr-2">
                                    <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle">
                                        <input type="checkbox" class="custom-control-input <?= $key ?>-checkbox" name="status[<?= $key ?>]" id="<?= $key ?>-checkbox" <?= ($key == 'hienthi') ? 'checked' : '' ?> value="<?= $key ?>">
                                        <label for="<?= $key ?>-checkbox" class="custom-control-label"></label>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    <?php } else { ?>
                        <?php if (isset($config['product'][$type]['check'])) {
                            foreach ($config['product'][$type]['check'] as $key => $value) { ?>
                                <div class="form-group d-inline-block mb-2 mr-2">
                                    <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle">
                                        <input type="checkbox" class="custom-control-input <?= $key ?>-checkbox" name="status[<?= $key ?>]" id="<?= $key ?>-checkbox" <?= (empty($status_array) && empty($item['id']) ? 'checked' : in_array($key, $status_array)) ? 'checked' : '' ?> value="<?= $key ?>">
                                        <label for="<?= $key ?>-checkbox" class="custom-control-label"></label>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    <?php } ?>
                </div>
                <div class="row">
                    <?php if (isset($config['product'][$type]['code']) && $config['product'][$type]['code'] == true) { ?>
                        <div class="form-group col-md-4">
                            <label class="d-block" for="code">Mã sản phẩm:</label>
                            <input type="text" class="form-control text-sm" name="data[code]" id="code" placeholder="Mã sản phẩm" value="<?= (!empty($flash->has('code'))) ? $flash->get('code') : @$item['code'] ?>">
                        </div>
                    <?php } ?>
                    <?php if (isset($config['product'][$type]['regular_price']) && $config['product'][$type]['regular_price'] == true) { ?>
                        <div class="form-group col-md-4">
                            <label class="d-block" for="regular_price">Giá bán:</label>
                            <div class="input-group">
                                <input type="text" class="form-control format-price regular_price text-sm" name="data[regular_price]" id="regular_price" placeholder="Giá bán" value="<?= (!empty($flash->has('regular_price'))) ? $flash->get('regular_price') : @$item['regular_price'] ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text"><strong>VNĐ</strong></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['product'][$type]['sale_price']) && $config['product'][$type]['sale_price'] == true) { ?>
                        <div class="form-group col-md-4">
                            <label class="d-block" for="sale_price">Giá mới:</label>
                            <div class="input-group">
                                <input type="text" class="form-control format-price sale_price text-sm" name="data[sale_price]" id="sale_price" placeholder="Giá mới" value="<?= (!empty($flash->has('sale_price'))) ? $flash->get('sale_price') : @$item['sale_price'] ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text"><strong>VNĐ</strong></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['product'][$type]['discount']) && $config['product'][$type]['discount'] == true) { ?>
                        <div class="form-group col-md-4">
                            <label class="d-block" for="discount">Chiết khấu:</label>
                            <div class="input-group">
                                <input type="text" class="form-control discount text-sm" name="data[discount]" id="discount" placeholder="Chiết khấu" value="<?= (!empty($flash->has('discount'))) ? $flash->get('discount') : @$item['discount'] ?>" maxlength="3" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text"><strong>%</strong></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php if (isset($config['product'][$type]['option']) && $config['product'][$type]['option'] == true) { ?>
                    <div class="row">

                        <div class="form-group col-md-4 col-sm-4">
                            <label for="dientich">Diện tích:</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-sm" name="data[options2][dientich]" id="dientich" placeholder="Diện tích" value="<?= $options2['dientich'] ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text"><strong>M<sup>2</sup></strong></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4 col-sm-4">
                            <label for="phaply">Pháp lý:</label>
                            <input type="text" class="form-control" name="data[options2][phaply]" id="phaply" placeholder="Pháp lý" value="<?= $options2['phaply'] ?>">
                        </div>

                        <div class="form-group col-md-4 col-sm-4">
                            <label for="nhucau">Nhu cầu:</label>
                            <input type="text" class="form-control" name="data[options2][nhucau]" id="nhucau" placeholder="Nhu cầu" value="<?= $options2['nhucau'] ?>">
                        </div>

                        <div class="form-group col-md-4 col-sm-4">
                            <label for="loai">Loại:</label>
                            <input type="text" class="form-control" name="data[options2][loai]" id="loai" placeholder="Loại" value="<?= $options2['loai'] ?>">
                        </div>

                        <div class="form-group col-md-4 col-sm-4">
                            <label for="tang">Số tầng:</label>
                            <input type="text" class="form-control" name="data[options2][tang]" id="tang" placeholder="Số tầng" value="<?= $options2['tang'] ?>">
                        </div>

                        <div class="form-group col-md-4 col-sm-4">
                            <label for="toa">Tòa:</label>
                            <input type="text" class="form-control" name="data[options2][toa]" id="toa" placeholder="Tòa" value="<?= $options2['toa'] ?>">
                        </div>

                        <div class="form-group col-md-4 col-sm-4">
                            <label for="huong">Hướng ban công:</label>
                            <input type="text" class="form-control" name="data[options2][huong]" id="huong" placeholder="Hướng ban công" value="<?= $options2['huong'] ?>">
                        </div>

                        <div class="form-group col-md-4 col-sm-4">
                            <label for="phongngu">Phòng ngủ:</label>
                            <input type="text" class="form-control" name="data[options2][phongngu]" id="phongngu" placeholder="Phòng ngủ" value="<?= $options2['phongngu'] ?>">
                        </div>

                        <div class="form-group col-md-4 col-sm-4">
                            <label for="phongwc">Phòng wc:</label>
                            <input type="text" class="form-control" name="data[options2][phongwc]" id="phongwc" placeholder="Phòng wc" value="<?= $options2['phongwc'] ?>">
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php if (CARTSITEADVANCE == true) { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Thêm hình ảnh cho từng màu</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $variants = $d->rawQuery("select * from #_product_sale_color where id_parent = ? order by id asc", array($item['id']));
                    ?>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr align="center">
                                <th scope="col">STT</th>
                                <th scope="col">Màu sắc</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Giá mới theo từng màu</th>
                                <th scope="col">Giá cũ theo từng màu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($variants as $key => $value) {
                                $sql = "select * from table_variants_color where id_parent = " . $value['id_parent'] . " and color = " . $value['id_color'] . " limit 0,1";
                                $var_check = $d->rawQueryOne($sql);
                                $color_detail = $d->rawQueryOne("select namevi, id from #_color where id = ? limit 0,1", array($value['id_color']));
                                $code = ($value['id_parent'] . $value['id_color']);
                            ?>
                                <tr align="center">
                                    <input type="hidden" name="code[]" value="<?= $code ?>">
                                    <input type="hidden" name="id_parent<?= $code ?>" value="<?= $value['id_parent'] ?>" />
                                    <input type="hidden" name="color<?= $code ?>" value="<?= $value['id_color'] ?>" />
                                    <td class="text-bold"><?= $key + 1 ?></td>
                                    <td><?= $color_detail['namevi'] ?></td>
                                    <td>
                                        <div class="viewPicture">
                                            <div class="viewPictureIcon">
                                                <img id="output<?= $value['id'] ?>" src="<?= ($var_check['photo'] != '') ? UPLOAD_PRODUCT . $var_check['photo'] : 'assets/images/noimage.png' ?>" />
                                            </div>
                                            <input type="file" name="photo<?= $code ?>" onchange="loadFile(event, 'output<?= $value['id'] ?>')" accept="image/*">
                                        </div>
                                    </td>
                                    <td style="width: 200px !important">
                                        <input type="text" name="price_new_color<?= $code ?>" class="format-price form-control" value="<?= ($var_check['price_new'] != '') ? number_format($var_check['price_new']) : 0 ?>" />
                                    </td>
                                    <td style="width: 200px !important">
                                        <input type="text" name="price_old_color<?= $code ?>" class="format-price form-control" value="<?= ($var_check['price_old'] != '') ? number_format($var_check['price_old']) : 0 ?>" />
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Thêm giá cho từng size</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $variants1 = $d->rawQuery("select * from #_product_sale_size where id_parent = ? order by id asc", array($item['id']));
                    ?>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr align="center">
                                <th scope="col">STT</th>
                                <th scope="col">Size</th>
                                <th scope="col">Giá mới theo từng size</th>
                                <th scope="col">Giá cũ theo từng size</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($variants1 as $key => $value1) {
                                $sql1 = "select * from table_variants_size where id_parent = " . $value1['id_parent'] . " and size = " . $value1['id_size'] . " limit 0,1";
                                $var_check1 = $d->rawQueryOne($sql1);
                                $size_detail1 = $d->rawQueryOne("select namevi, id from #_size where id = ? limit 0,1", array($value1['id_size']));
                                $code1 = ($value1['id_parent'] . $value1['id_size']);
                            ?>
                                <tr align="center">
                                    <input type="hidden" name="code1[]" value="<?= $code1 ?>">
                                    <input type="hidden" name="id_parent<?= $code1 ?>" value="<?= $value1['id_parent'] ?>" />
                                    <input type="hidden" name="size<?= $code1 ?>" value="<?= $value1['id_size'] ?>" />
                                    <td class="text-bold"><?= $key + 1 ?></td>
                                    <td><?= $size_detail1['namevi'] ?></td>
                                    <td style="width: 200px !important">
                                        <input type="text" name="price_new_size<?= $code1 ?>" class="format-price form-control" value="<?= ($var_check1['price_new'] != '') ? number_format($var_check1['price_new']) : 0 ?>" />
                                    </td>
                                    <td style="width: 200px !important">
                                        <input type="text" name="price_old_size<?= $code1 ?>" class="format-price form-control" value="<?= ($var_check1['price_old'] != '') ? number_format($var_check1['price_old']) : 0 ?>" />
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

        <?php if (isset($flagGallery) && $flagGallery == true) { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title"><?= $type == 'san-pham' ? 'Hình ảnh chi tiết ' . $config['product'][$type]['title_main'] : 'Bộ sưu tập ' . $config['product'][$type]['title_main'] ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="filer-gallery" class="label-filer-gallery mb-3">Thêm hình <?= $type == 'san-pham' ? 'chi tiết' : '' ?>: (<?= $config['product'][$type]['gallery'][$keyGallery]['img_type_photo'] ?>)</label>
                        <input type="file" name="files[]" id="filer-gallery" multiple="multiple">
                        <input type="hidden" class="col-filer" value="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
                        <input type="hidden" class="act-filer" value="man">
                        <input type="hidden" class="folder-filer" value="product">
                    </div>
                    <?php if (isset($gallery) && count($gallery) > 0) { ?>
                        <div class="form-group form-group-gallery">
                            <label class="label-filer"><?= $type == 'san-pham' ? 'Danh sách ảnh chi tiết' : 'Danh sách hình trong bộ sưu tập' ?>:</label>
                            <div class="action-filer mb-3">
                                <a class="btn btn-sm bg-gradient-primary text-white check-all-filer mr-1"><i class="far fa-square mr-2"></i>Chọn tất cả</a>
                                <button type="button" class="btn btn-sm bg-gradient-success text-white sort-filer mr-1"><i class="fas fa-random mr-2"></i>Sắp xếp</button>
                                <a class="btn btn-sm bg-gradient-danger text-white delete-all-filer"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
                            </div>
                            <div class="alert my-alert alert-sort-filer alert-info text-sm text-white bg-gradient-info"><i class="fas fa-info-circle mr-2"></i>Có thể chọn nhiều hình để di chuyển</div>
                            <div class="jFiler-items my-jFiler-items jFiler-row">
                                <ul class="jFiler-items-list jFiler-items-grid row scroll-bar" id="jFilerSortable">
                                    <?php foreach ($gallery as $v) echo $func->galleryFiler($v['numb'], $v['id'], $v['photo'], $v['namevi'], 'product', 'col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6'); ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if (isset($config['product'][$type]['seo']) && $config['product'][$type]['seo'] == true) { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Nội dung SEO</h3>
                    <a class="btn btn-sm bg-gradient-success d-inline-block text-white float-right create-seo" title="Tạo SEO">Tạo SEO</a>
                </div>
                <div class="card-body">
                    <?php
                    $seoDB = $seo->getOnDB($id, $com, 'man', $type);
                    include TEMPLATE . LAYOUT . "seo.php";
                    ?>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($config['product'][$type]['schema']) && $config['product'][$type]['schema'] == true) { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Schema JSON Product</h3>
                    <button type="submit" class="btn btn-sm bg-gradient-success float-right submit-check" name="build-schema" value="1"><i class="far fa-save mr-2"></i>Lưu và tạo tự động Schema</button>
                </div>
                <div class="card-body">
                    <?php
                    $seoDB = $seo->getOnDB($id, $com, 'man', $type);
                    include TEMPLATE . LAYOUT . "schema.php";
                    ?>
                    <input type="hidden" id="schema-type" value="product">
                </div>
            </div>
        <?php } ?>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i>Lưu tại trang</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>