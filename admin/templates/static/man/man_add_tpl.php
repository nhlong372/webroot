<?php
$linkSave = "index.php?com=static&act=save&type=" . $type;

if (isset($config['static'][$type]['images']) && $config['static'][$type]['images'] == true) {
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
                <li class="breadcrumb-item active">Quản lý trang tĩnh</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="row">
            <div class="<?= $colLeft ?>">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung <?= $config['static'][$type]['title_main'] ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (isset($config['static'][$type]['file']) && $config['static'][$type]['file'] == true) { ?>
                            <div class="form-group">
                                <div class="upload-file mb-2">
                                    <p>Upload tập tin:</p>
                                    <label class="upload-file-label mb-2" for="file_attach">
                                        <div class="custom-file my-custom-file">
                                            <input type="file" class="custom-file-input" name="file_attach" id="file_attach" lang="vi">
                                            <label class="custom-file-label mb-0" data-browse="Chọn" for="file_attach">Chọn file</label>
                                        </div>
                                    </label>
                                    <?php if (isset($item['file_attach']) && $item['file_attach'] != '') { ?>
                                        <div class="file-uploaded mb-2">
                                            <a class="btn btn-sm bg-gradient-primary text-white d-inline-block align-middle rounded p-2" href="<?= UPLOAD_FILE . @$item['file_attach'] ?>" title="Download tập tin hiện tại"><i class="fas fa-download mr-2"></i>Download tập tin hiện tại</a>
                                        </div>
                                    <?php } ?>
                                    <strong class="d-block text-sm"><?= $config['static'][$type]['file_type'] ?></strong>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <?php $status_array = (!empty($item['status'])) ? explode(',', $item['status']) : array(); ?>
                            <?php if (isset($config['static'][$type]['check'])) {
                                foreach ($config['static'][$type]['check'] as $key => $value) { ?>
                                    <div class="form-group d-inline-block mb-2 mr-2">
                                        <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle">
                                            <input type="checkbox" class="custom-control-input <?= $key ?>-checkbox" name="status[<?= $key ?>]" id="<?= $key ?>-checkbox" <?= (empty($status_array) && empty($item['id']) ? 'checked' : in_array($key, $status_array)) ? 'checked' : '' ?> value="<?= $key ?>">
                                            <label for="<?= $key ?>-checkbox" class="custom-control-label"></label>
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                        <?php if (
                            (isset($config['static'][$type]['name']) && $config['static'][$type]['name'] == true) ||
                            (isset($config['static'][$type]['desc']) && $config['static'][$type]['desc'] == true) ||
                            (isset($config['static'][$type]['content']) && $config['static'][$type]['content'] == true)
                        ) { ?>
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
                                                <?php if (isset($config['static'][$type]['name']) && $config['static'][$type]['name'] == true) { ?>
                                                    <div class="form-group">
                                                        <label for="name<?= $k ?>">Tiêu đề (<?= $k ?>):</label>
                                                        <input type="text" class="form-control for-seo text-sm" name="data[name<?= $k ?>]" id="name<?= $k ?>" placeholder="Tiêu đề (<?= $k ?>)" value="<?= (!empty($flash->has('name' . $k))) ? $flash->get('name' . $k) : @$item['name' . $k] ?>" required>
                                                    </div>
                                                <?php } ?>
                                                <?php if (isset($config['static'][$type]['desc']) && $config['static'][$type]['desc'] == true) { ?>
                                                    <div class="form-group">
                                                        <label for="desc<?= $k ?>">Mô tả (<?= $k ?>):</label>
                                                        <textarea class="form-control for-seo text-sm <?= (isset($config['static'][$type]['desc_cke']) && $config['static'][$type]['desc_cke'] == true) ? 'form-control-ckeditor' : '' ?>" name="data[desc<?= $k ?>]" id="desc<?= $k ?>" rows="5" placeholder="Mô tả (<?= $k ?>)"><?= $func->decodeHtmlChars($flash->get('desc' . $k)) ?: $func->decodeHtmlChars(@$item['desc' . $k]) ?></textarea>
                                                    </div>
                                                <?php } ?>
                                                <?php if (isset($config['static'][$type]['content']) && $config['static'][$type]['content'] == true) { ?>
                                                    <div class="form-group">
                                                        <label for="content<?= $k ?>">Nội dung (<?= $k ?>):</label>
                                                        <textarea class="form-control for-seo text-sm <?= (isset($config['static'][$type]['content_cke']) && $config['static'][$type]['content_cke'] == true) ? 'form-control-ckeditor' : '' ?>" name="data[content<?= $k ?>]" id="content<?= $k ?>" rows="5" placeholder="Nội dung (<?= $k ?>)"><?= $func->decodeHtmlChars($flash->get('content' . $k)) ?: $func->decodeHtmlChars(@$item['content' . $k]) ?></textarea>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="<?= $colRight ?>">
                <!-- Photo 1 -->
                <?php if (isset($config['static'][$type]['images']) && $config['static'][$type]['images'] == true) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh <?= $config['static'][$type]['title_main'] ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">                            
                            <?php
                            /* Photo detail */
                            $photoDetail = array();
                            $photoDetail['upload'] = UPLOAD_NEWS_L;
                            $photoDetail['image'] = (!empty($item)) ? $item['photo'] : '';
                            $photoDetail['dimension'] = "Width: " . $config['static'][$type]['width'] . " px - Height: " . $config['static'][$type]['height'] . " px (" . $config['static'][$type]['img_type'] . ")";

                            /* Image */
                            include TEMPLATE . LAYOUT . "image.php";
                            ?>
                        </div>
                    </div>
                <?php } ?>
                
                <!-- Photo 2 -->
                <?php if(isset($config['static'][$type]['images2']) && $config['static'][$type]['images2'] == true) { ?>
                    <div class="card card-primary card-outline text-sm" >
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh <?=$config['static'][$type]['title_main']?> 2</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                                $photoDetail2 = ($act != 'copy') ? UPLOAD_NEWS.@$item['photo2'] : '';
                                $dimension2 = "Width: ".$config['static'][$type]['width2']." px - Height: ".$config['static'][$type]['height2']." px (".$config['static'][$type]['img_type'].")";
                                include TEMPLATE.LAYOUT."image2.php";
                            ?>                            
                        </div>
                    </div>
                <?php } ?>
                
                <!-- Photo 3 -->
                <?php if(isset($config['static'][$type]['images3']) && $config['static'][$type]['images3'] == true) { ?>
                    <div class="card card-primary card-outline text-sm" >
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh <?=$config['static'][$type]['title_main']?> 3</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                                $photoDetail3 = ($act != 'copy') ? UPLOAD_NEWS.@$item['photo3'] : '';
                                $dimension3 = "Width: ".$config['static'][$type]['width3']." px - Height: ".$config['static'][$type]['height3']." px (".$config['static'][$type]['img_type'].")";
                                include TEMPLATE.LAYOUT."image3.php";
                            ?>                            
                        </div>
                    </div>
                <?php } ?>

                <!-- Photo 4 -->
                <?php if(isset($config['static'][$type]['images4']) && $config['static'][$type]['images4'] == true) { ?>
                    <div class="card card-primary card-outline text-sm" >
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh <?=$config['static'][$type]['title_main']?> 4</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                                $photoDetail4 = ($act != 'copy') ? UPLOAD_NEWS.@$item['photo4'] : '';
                                $dimension4 = "Width: ".$config['static'][$type]['width4']." px - Height: ".$config['static'][$type]['height4']." px (".$config['static'][$type]['img_type'].")";
                                include TEMPLATE.LAYOUT."image4.php";
                            ?>                            
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
        <?php if (isset($config['static'][$type]['seo']) && $config['static'][$type]['seo'] == true) { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Nội dung SEO</h3>
                    <a class="btn btn-sm bg-gradient-success d-inline-block text-white float-right create-seo" title="Tạo SEO">Tạo SEO</a>
                </div>
                <div class="card-body">
                    <?php
                    $seoDB = $seo->getOnDB(0, $com, 'update', $type);
                    include TEMPLATE . LAYOUT . "seo.php";
                    ?>
                </div>
            </div>
        <?php } ?>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
        </div>
    </form>
</section>