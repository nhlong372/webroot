<?php
$linkSaveImg = "index.php?com=import&act=saveImages&type=" . $type;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý hình ảnh import excel</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSaveImg ?>" enctype="multipart/form-data">
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Chi tiết hình ảnh import</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="upload-file">
                        <p>Upload hình ảnh:</p>
                        <label class="upload-file-label mb-2" for="file">
                            <div class="upload-file-image rounded mb-3">
                                <?= $func->getImage(['class' => 'rounded img-upload', 'size-error' => '250x250x1', 'upload' => UPLOAD_EXCEL_L, 'image' => (!empty($item['photo'])) ? $item['photo'] : '', 'alt' => 'Alt Photo']) ?>
                            </div>
                            <div class="custom-file my-custom-file">
                                <input type="file" class="custom-file-input" name="file" id="file" lang="vi">
                                <label class="custom-file-label mb-0" data-browse="Chọn" for="file">Chọn file</label>
                            </div>
                        </label>
                        <strong class="d-block text-sm"><?php echo $config['import']['img_type'] ?></strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>