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
                <li class="breadcrumb-item active">Cập nhật <?= $config[$com][$type][$dfgallery][$val]['title_main_photo'] ?></li>
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
                                <input class="custom-control-input" type="radio" id="id_color<?= $k ?>" name="data[id_color]" <?= ($item['id_color'] == $v['id']) ? 'checked' : '' ?> value="<?= @$v['id'] ?>">
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
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Chi tiết <?= $config[$com][$type][$dfgallery][$val]['title_main_photo'] ?></h3>
            </div>
            <div class="card-body">
                <?php if (isset($config[$com][$type][$dfgallery][$val]['images_photo']) && $config[$com][$type][$dfgallery][$val]['images_photo'] == true) { ?>
                    <div class="form-group">
                        <div class="upload-file">
                            <label class="d-block mb-2">Upload hình ảnh:</label>
                            <label class="upload-file-label mb-2" for="file">
                                <div class="upload-file-image rounded mb-3">
                                    <?= $func->getImage(['class' => 'rounded img-upload', 'sizes' => '250x250x1', 'upload' => 'upload/' . $com . '/', 'image' => (!empty($item['photo'])) ? $item['photo'] : '', 'alt' => 'Alt Photo']) ?>
                                </div>
                                <div class="custom-file my-custom-file">
                                    <input type="file" class="custom-file-input" name="file" id="file" lang="vi">
                                    <label class="custom-file-label mb-0" data-browse="Chọn" for="file">Chọn file</label>
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
                            <strong class="d-block text-sm"><?= $config[$com][$type][$dfgallery][$val]['file_type_photo'] ?></strong>
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($config[$com][$type][$dfgallery][$val]['video_photo']) && $config[$com][$type][$dfgallery][$val]['video_photo'] == true) { ?>
                    <div class="form-group">
                        <label for="link_video">Video:</label>
                        <input type="text" class="form-control text-sm" name="data[link_video]" id="link_video" onchange="youtubePreview(this.value,'#loadVideo');" placeholder="Video" value="<?= @$item['link_video'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="link_video">Video preview:</label>
                        <div><iframe id="loadVideo" width="250" src="//www.youtube.com/embed/<?= $func->getYoutube($item['link_video']) ?>" <?= (@$item["link_video"] == '') ? "height='0'" : "height='150'"; ?> frameborder="0" allowfullscreen></iframe></div>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <?php $status_array = (!empty($item['status'])) ? explode(',', $item['status']) : array(); ?>
                    <?php if (isset($config[$com][$type][$dfgallery][$val]['check_photo'])) {
                        foreach ($config[$com][$type][$dfgallery][$val]['check_photo'] as $key => $value) { ?>
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
                <div class="form-group">
                    <label for="numb" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                </div>
                <?php if (isset($config[$com][$type][$dfgallery][$val]['name_photo']) && $config[$com][$type][$dfgallery][$val]['name_photo'] == true) { ?>
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
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                    <div class="tab-pane fade show <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang-<?= $k ?>" role="tabpanel" aria-labelledby="tabs-lang">
                                        <?php if (isset($config[$com][$type][$dfgallery][$val]['name_photo']) && $config[$com][$type][$dfgallery][$val]['name_photo'] == true) { ?>
                                            <div class="form-group">
                                                <label for="name<?= $k ?>">Tiêu đề (<?= $k ?>):</label>
                                                <input type="text" class="form-control text-sm" name="data[name<?= $k ?>]" id="name<?= $k ?>" placeholder="Tiêu đề (<?= $k ?>)" value="<?= @$item['name' . $k] ?>">
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
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>