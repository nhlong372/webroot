<?php
$linkMan = "index.php?com=lang&act=man";
$linkSave = "index.php?com=lang&act=save";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item"><a href="<?= $linkMan ?>" title="Quản lý ngôn ngữ">Quản lý ngôn ngữ</a></li>
                <li class="breadcrumb-item active">Chi tiết ngôn ngữ</li>
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

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title"><?= ($act == "edit") ? "Cập nhật" : "Thêm mới"; ?> ngôn ngữ</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="lang_define">Tên biến:</label>
                    <input type="text" class="form-control text-sm" name="data[lang_define]" id="lang_define" placeholder="Tên biến" value="<?= (!empty($flash->has('lang_define'))) ? $flash->get('lang_define') : @$item['lang_define'] ?>" required>
                </div>
                <?php foreach ($config['website']['lang'] as $key => $value) { ?>
                    <div class="form-group">
                        <label for="lang<?= $key ?>"><?= $value ?>:</label>
                        <input type="text" class="form-control text-sm" name="data[lang<?= $key ?>]" id="lang<?= $key ?>" placeholder="<?= $value ?> *" value="<?= (!empty($flash->has('lang' . $key))) ? $flash->get('lang' . $key) : @$item['lang' . $key] ?>" required>
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