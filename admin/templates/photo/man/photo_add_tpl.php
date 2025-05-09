<?php
$linkMan = "index.php?com=photo&act=man_photo&type=" . $type;
$linkSave = "index.php?com=photo&act=save_photo&type=" . $type;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item"><a href="<?= $linkMan ?>" title="<?= $config['photo']['man_photo'][$type]['title_main_photo'] ?>">Quản lý <?= $config['photo']['man_photo'][$type]['title_main_photo'] ?></a></li>
                <li class="breadcrumb-item active">Thêm mới <?= $config['photo']['man_photo'][$type]['title_main_photo'] ?></li>
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
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <?php $numberPhoto = (isset($config['photo']['man_photo'][$type]['number_photo'])) ? $config['photo']['man_photo'][$type]['number_photo'] : 0; ?>
        <?php for ($i = 0; $i < $numberPhoto; $i++) {
            $numb = $i + 1; ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title"><?= $config['photo']['man_photo'][$type]['title_main_photo'] . ": " . $numb ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (isset($config['photo']['man_photo'][$type]['images_photo']) && $config['photo']['man_photo'][$type]['images_photo'] == true) { ?>
                        <div class="form-group">
                            <div class="upload-file">
                                <p>Upload hình ảnh:</p>
                                <label class="upload-file-label mb-2" for="file<?= $i ?>">
                                    <div class="upload-file-image rounded mb-3">
                                        <?= $func->getImage(['class' => 'rounded img-upload', 'size-error' => '250x250x1', 'upload' => 'assets/images/', 'image' => 'noimage.png', 'alt' => 'No Image']) ?>
                                    </div>
                                    <div class="custom-file my-custom-file">
                                        <input type="file" class="custom-file-input" name="file<?= $i ?>" id="file<?= $i ?>" lang="vi">
                                        <label class="custom-file-label mb-0" data-browse="Chọn" for="file<?= $i ?>">Chọn file</label>
                                    </div>
                                </label>
                                <strong class="d-block text-sm"><?php echo "Width: " . $config['photo']['man_photo'][$type]['width_photo'] . " px - Height: " . $config['photo']['man_photo'][$type]['height_photo'] . " px (" . $config['photo']['man_photo'][$type]['img_type_photo'] . ")" ?></strong>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['photo']['man_photo'][$type]['link_photo']) && $config['photo']['man_photo'][$type]['link_photo'] == true) { ?>
                        <div class="form-group">
                            <label for="link<?= $i ?>">Link:</label>
                            <input type="text" class="form-control text-sm" name="dataMulti[<?= $i ?>][link]" id="link<?= $i ?>" placeholder="Link" value="<?= (!empty($flash->has('link' . $i))) ? $flash->get('link' . $i) : '' ?>">
                        </div>
                    <?php } ?>
                    <?php if (isset($config['photo']['man_photo'][$type]['video_photo']) && $config['photo']['man_photo'][$type]['video_photo'] == true) { ?>
                        <div class="form-group">
                            <label for="link_video<?= $i ?>">Video:</label>
                            <input type="text" class="form-control text-sm" name="dataMulti[<?= $i ?>][link_video]" id="link_video<?= $i ?>" onchange="youtubePreview(this.value,'#loadVideo<?= $i ?>');" placeholder="Video" value="<?= (!empty($flash->has('link_video' . $i))) ? $flash->get('link_video' . $i) : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="link_video">Video preview:</label>
                            <div><iframe id="loadVideo<?= $i ?>" width="0px" height="0px" frameborder="0" allowfullscreen></iframe></div>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['photo']['man_photo'][$type]['file_photo']) && $config['photo']['man_photo'][$type]['file_photo'] == true) { ?>
                        <div class="form-group">
                            <div class="upload-file upload-file-man">
                                <p>Upload file đính kèm:</p>
                                <?php
                                $dimensiontailieu = "Đuôi file: ". $config['photo']['man_photo'][$type]['file_type_photo'];
                                include TEMPLATE.LAYOUT."file2.php";
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <?php if (isset($config['photo']['man_photo'][$type]['check_photo'])) {
                            foreach ($config['photo']['man_photo'][$type]['check_photo'] as $key => $value) { ?>
                                <div class="form-group d-inline-block mb-2 mr-2">
                                    <label for="<?= $key ?>-checkbox<?= $i ?>" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle">
                                        <input type="checkbox" class="custom-control-input <?= $key ?>-checkbox<?= $i ?>" name="dataMulti[<?= $i ?>][status][]" id="<?= $key ?>-checkbox<?= $i ?>" value="<?= $key ?>" checked>
                                        <label for="<?= $key ?>-checkbox<?= $i ?>" class="custom-control-label"></label>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                    <div class="form-group">
                        <label for="numb<?= $i ?>" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                        <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="dataMulti[<?= $i ?>][numb]" id="numb<?= $i ?>" placeholder="Số thứ tự" value="1">
                    </div>
                    <?php if (
                        (isset($config['photo']['man_photo'][$type]['name_photo']) && $config['photo']['man_photo'][$type]['name_photo'] == true) ||
                        (isset($config['photo']['man_photo'][$type]['desc_photo']) && $config['photo']['man_photo'][$type]['desc_photo'] == true) ||
                        (isset($config['photo']['man_photo'][$type]['content_photo']) && $config['photo']['man_photo'][$type]['content_photo'] == true)
                    ) { ?>
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                                    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang" data-toggle="pill" href="#tabs-lang-<?= $k ?>-<?= $i ?>" role="tab" aria-controls="tabs-lang-<?= $k ?>-<?= $i ?>" aria-selected="true"><?= $v ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                        <div class="tab-pane fade show <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang-<?= $k ?>-<?= $i ?>" role="tabpanel" aria-labelledby="tabs-lang">
                                            <?php if ((isset($config['photo']['man_photo'][$type]['name_photo']) && $config['photo']['man_photo'][$type]['name_photo'] == true)) { ?>
                                                <div class="form-group">
                                                    <label for="name<?= $k ?><?= $i ?>">Tiêu đề (<?= $k ?>):</label>
                                                    <input type="text" class="form-control text-sm" name="dataMulti[<?= $i ?>][name<?= $k ?>]" id="name<?= $k ?><?= $i ?>" placeholder="Tiêu đề (<?= $k ?>)" value="<?= (!empty($flash->has('name' . $k . $i))) ? $flash->get('name' . $k . $i) : '' ?>">
                                                </div>
                                            <?php } ?>
                                            <?php if ((isset($config['photo']['man_photo'][$type]['desc_photo']) && $config['photo']['man_photo'][$type]['desc_photo'] == true)) { ?>
                                                <div class="form-group">
                                                    <label for="desc<?= $k ?><?= $i ?>">Mô tả (<?= $k ?>):</label>
                                                    <textarea class="form-control text-sm <?= ((isset($config['photo']['man_photo'][$type]['desc_cke_photo']) && $config['photo']['man_photo'][$type]['desc_cke_photo'] == true)) ? 'form-control-ckeditor' : '' ?>" name="dataMulti[<?= $i ?>][desc<?= $k ?>]" id="desc<?= $k ?><?= $i ?>" rows="5" placeholder="Mô tả (<?= $k ?>)"><?= $func->decodeHtmlChars($flash->get('desc' . $k . $i)) ?></textarea>
                                                </div>
                                            <?php } ?>
                                            <?php if ((isset($config['photo']['man_photo'][$type]['content_photo']) && $config['photo']['man_photo'][$type]['content_photo'] == true)) { ?>
                                                <div class="form-group">
                                                    <label for="content<?= $k ?><?= $i ?>">Nội dung (<?= $k ?>):</label>
                                                    <textarea class="form-control text-sm <?= ((isset($config['photo']['man_photo'][$type]['content_cke_photo']) && $config['photo']['man_photo'][$type]['content_cke_photo'] == true)) ? 'form-control-ckeditor' : '' ?>" name="dataMulti[<?= $i ?>][content<?= $k ?>]" id="content<?= $k ?><?= $i ?>" rows="5" placeholder="Nội dung (<?= $k ?>)"><?= $func->decodeHtmlChars($flash->get('content' . $k . $i)) ?></textarea>
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
        <?php } ?>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>
    </form>
</section>