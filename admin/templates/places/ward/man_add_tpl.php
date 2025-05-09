<?php
$linkMan = "index.php?com=places&act=man_ward";
if ($act == 'add_ward') $linkFilter = "index.php?com=places&act=add_ward";
else if ($act == 'edit_ward') $linkFilter = "index.php?com=places&act=edit_ward&id=" . $id;
$linkSave = "index.php?com=places&act=save_ward";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Chi tiết phường xã</li>
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
                <h3 class="card-title"><?= ($act == "edit_ward") ? "Cập nhật" : "Thêm mới"; ?> phường xã</h3>
            </div>
            <div class="card-body">
                <div class="form-group-category row">
                    <div class="form-group col-md-3 col-sm-4">
                        <label class="d-block" for="id_city">Danh sách tỉnh thành:</label>
                        <?= $func->getAjaxPlace("city") ?>
                    </div>
                    <div class="form-group col-md-3 col-sm-4">
                        <label class="d-block" for="id_district">Danh sách quận huyện:</label>
                        <?= $func->getAjaxPlace("district") ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Tiêu đề: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control text-sm" name="data[name]" id="name" placeholder="Tiêu đề" value="<?= (!empty($flash->has('name'))) ? $flash->get('name') : @$item['name'] ?>" required>
                </div>
                <?php if (isset($config['places']['placesship']) && $config['places']['placesship'] == true) { ?>
                    <div class="form-group">
                        <label for="ship_price" class="d-block">Phí vận chuyển:</label>
                        <input type="text" class="form-control format-price w-auto d-inline-block align-middle text-sm" name="data[ship_price]" id="ship_price" placeholder="Phí vận chuyển" value="<?= (!empty($flash->has('ship_price'))) ? $flash->get('ship_price') : @$item['ship_price'] ?>" required>
                        <span class="d-inline-block align-middle ml-1">VNĐ</span>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <?php $status_array = (!empty($item['status'])) ? explode(',', $item['status']) : array(); ?>
                    <?php if (isset($config['places']['check_ward'])) {
                        foreach ($config['places']['check_ward'] as $key => $value) { ?>
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