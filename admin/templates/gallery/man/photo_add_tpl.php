<?php
$linkMan = "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&kind=" . $kind . "&val=" . $val . "&type=" . $type;
$linkSave = "index.php?com=" . $com . "&act=save_photo&id_parent=" . $id_parent . "&kind=" . $kind . "&val=" . $val . "&type=" . $type;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Thêm mới <?= $config[$com][$type][$dfgallery][$val]['title_main_photo'] ?></li>
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
        <?php if (isset($config[$com][$type][$dfgallery][$val]['cart_photo']) && $config[$com][$type][$dfgallery][$val]['cart_photo'] == true) { ?>
            <?php
            $color = $d->rawQuery("select id_color from #_product_sale where id_parent = ?", array($id_parent));
            $color = (!empty($color)) ? $func->joinCols($color, 'id_color') : array();
            $color = (!empty($color)) ? explode(",", $color) : array();

            if (!empty($color)) {
                $cols = ["namevi", "id", "color", "type_show"];
                $d->where('id', $color, 'IN');
                $d->where('type', $type);
                $result_color = $d->get("color", null, $cols);
            }
            ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Danh mục màu sắc</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($result_color) && count($result_color) > 0) {
                        foreach ($result_color as $k => $v) { ?>
                            <div class="custom-control custom-radio d-inline-block mr-3 text-md">
                                <input class="custom-control-input" type="radio" id="id_color<?= $k ?>" name="data[id_color]" value="<?= @$v['id'] ?>">
                                <label for="id_color<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v['namevi'] ?></label>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="alert alert-warning" role="alert">
                            <strong>Không có màu sắc</strong>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php $numberPhoto = (isset($config[$com][$type][$dfgallery][$val]['number_photo'])) ? $config[$com][$type][$dfgallery][$val]['number_photo'] : 0; ?>
        <?php for ($i = 0; $i < $numberPhoto; $i++) {
            $numb = $i + 1; ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Thêm mới <?= $config[$com][$type][$dfgallery][$val]['title_main_photo'] . ": " . $numb ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (isset($config[$com][$type][$dfgallery][$val]['images_photo']) && $config[$com][$type][$dfgallery][$val]['images_photo'] == true) { ?>
                        <div class="form-group">
                            <div class="upload-file">
                                <label class="d-block mb-2">Upload hình ảnh:</label>
                                <label class="upload-file-label mb-2" for="file<?= $i ?>">
                                    <div class="upload-file-image rounded mb-3">
                                        <?= $func->getImage(['class' => 'rounded img-upload', 'sizes' => '250x250x1', 'upload' => 'assets/images/', 'image' => 'noimage.png', 'alt' => 'No Image']) ?>
                                    </div>
                                    <div class="custom-file my-custom-file">
                                        <input type="file" class="custom-file-input" name="file<?= $i ?>" id="file<?= $i ?>" lang="vi">
                                        <label class="custom-file-label mb-0" data-browse="Chọn" for="file<?= $i ?>">Chọn file</label>
                                    </div>
                                </label>
                                <strong class="d-block text-sm"><?php echo "Width: " . $config[$com][$type][$dfgallery][$val]['width_photo'] . " px - Height: " . $config[$com][$type][$dfgallery][$val]['height_photo'] . " px (" . $config[$com][$type][$dfgallery][$val]['img_type_photo'] . ")" ?></strong>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($config[$com][$type][$dfgallery][$val]['file_photo']) && $config[$com][$type][$dfgallery][$val]['file_photo'] == true) { ?>
                        <div class="form-group">
                            <div class="upload-file mb-2">
                                <p>Upload tập tin:</p>
                                <label class="upload-file-label mb-2" for="file_attach<?= $i ?>">
                                    <div class="custom-file my-custom-file">
                                        <input type="file" class="custom-file-input" name="file_attach<?= $i ?>" id="file_attach<?= $i ?>" lang="vi">
                                        <label class="custom-file-label mb-0" data-browse="Chọn" for="file_attach<?= $i ?>">Chọn file</label>
                                    </div>
                                </label>
                                <strong class="d-block text-sm"><?= $config[$com][$type][$dfgallery][$val]['file_type_photo'] ?></strong>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($config[$com][$type][$dfgallery][$val]['video_photo']) && $config[$com][$type][$dfgallery][$val]['video_photo'] == true) { ?>
                        <div class="form-group">
                            <label for="link_video<?= $i ?>">Video:</label>
                            <input type="text" class="form-control text-sm" name="dataMulti[<?= $i ?>][link_video]" id="link_video<?= $i ?>" onchange="youtubePreview(this.value,'#loadVideo<?= $i ?>');" placeholder="Video">
                        </div>
                        <div class="form-group">
                            <label for="link_video">Video preview:</label>
                            <div><iframe id="loadVideo<?= $i ?>" width="0px" height="0px" frameborder="0" allowfullscreen></iframe></div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <?php if (isset($config[$com][$type][$dfgallery][$val]['check_photo'])) {
                            foreach ($config[$com][$type][$dfgallery][$val]['check_photo'] as $key => $value) { ?>
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
                    <?php if (isset($config[$com][$type][$dfgallery][$val]['name_photo']) && $config[$com][$type][$dfgallery][$val]['name_photo'] == true) { ?>
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
                                            <?php if (isset($config[$com][$type][$dfgallery][$val]['name_photo']) && $config[$com][$type][$dfgallery][$val]['name_photo'] == true) { ?>
                                                <div class="form-group">
                                                    <label for="name<?= $k ?><?= $i ?>">Tiêu đề (<?= $k ?>):</label>
                                                    <input type="text" class="form-control text-sm" name="dataMulti[<?= $i ?>][name<?= $k ?>]" id="name<?= $k ?><?= $i ?>" placeholder="Tiêu đề (<?= $k ?>)">
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