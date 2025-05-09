<?php
$linkMan = "index.php?com=newsletter&act=man&type=" . $type;
$linkSave = "index.php?com=newsletter&act=save&type=" . $type;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item"><a href="<?= $linkMan ?>" title="Quản lý <?= $config['newsletter'][$type]['title_main'] ?>">Quản lý <?= $config['newsletter'][$type]['title_main'] ?></a></li>
                <li class="breadcrumb-item active"><?= ($act == "edit") ? "Cập nhật" : "Thêm mới"; ?> <?= $config['newsletter'][$type]['title_main'] ?></li>
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
                <h3 class="card-title">Chi tiết <?= $config['newsletter'][$type]['title_main'] ?></h3>
            </div>
            <div class="card-body">
                <?php if (isset($config['newsletter'][$type]['file']) && $config['newsletter'][$type]['file'] == true) { ?>
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
                            <strong class="d-block text-sm"><?= $config['newsletter'][$type]['file_type'] ?></strong>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group-category row">
                    <?php if (isset($config['newsletter'][$type]['fullname']) && $config['newsletter'][$type]['fullname'] == true) { ?>
                        <div class="form-group col-md-4">
                            <label for="fullname">Họ tên:</label>
                            <input type="text" class="form-control text-sm" name="data[fullname]" id="fullname" placeholder="Họ tên" value="<?= (!empty($flash->has('fullname'))) ? $flash->get('fullname') : @$item['fullname'] ?>" required>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['newsletter'][$type]['email']) && $config['newsletter'][$type]['email'] == true) { ?>
                        <div class="form-group col-md-4">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control text-sm" name="data[email]" id="email" placeholder="Email" value="<?= (!empty($flash->has('email'))) ? $flash->get('email') : @$item['email'] ?>" required>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['newsletter'][$type]['phone']) && $config['newsletter'][$type]['phone'] == true) { ?>
                        <div class="form-group col-md-4">
                            <label for="phone">Điện thoại:</label>
                            <input type="text" class="form-control text-sm" name="data[phone]" id="phone" placeholder="Điện thoại" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : @$item['phone'] ?>" required>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['newsletter'][$type]['address']) && $config['newsletter'][$type]['address'] == true) { ?>
                        <div class="form-group col-md-4">
                            <label for="address">Địa chỉ:</label>
                            <input type="text" class="form-control text-sm" name="data[address]" id="address" placeholder="Địa chỉ" value="<?= (!empty($flash->has('address'))) ? $flash->get('address') : @$item['address'] ?>" required>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['newsletter'][$type]['subject']) && $config['newsletter'][$type]['subject'] == true) { ?>
                        <div class="form-group col-md-4">
                            <label for="subject">Chủ đề:</label>
                            <input type="text" class="form-control text-sm" name="data[subject]" id="subject" placeholder="Chủ đề" value="<?= (!empty($flash->has('subject'))) ? $flash->get('subject') : @$item['subject'] ?>" required>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['newsletter'][$type]['confirm_status']) && count($config['newsletter'][$type]['confirm_status']) > 0) { ?>
                        <div class="form-group col-md-4">
                            <label for="confirm_status">Tình trạng:</label>
                            <?php $flashConfirmStatus = $flash->get('confirm_status'); ?>
                            <select id="confirm_status" name="data[confirm_status]" class="form-control select2">
                                <option value="0">Cập nhật tình trạng</option>
                                <?php foreach ($config['newsletter'][$type]['confirm_status'] as $key => $value) { ?>
                                    <option <?= (!empty($flashConfirmStatus) && $flashConfirmStatus == $key) ? 'selected' : ((@$item['confirm_status'] == $key) ? 'selected' : '') ?> value="<?= $key ?>"><?= $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                </div>
                <?php if (isset($config['newsletter'][$type]['content']) && $config['newsletter'][$type]['content'] == true) { ?>
                    <div class="form-group">
                        <label for="content">Nội dung:</label>
                        <textarea class="form-control text-sm" name="data[content]" id="content" rows="5" placeholder="Nội dung" required><?= (!empty($flash->has('content'))) ? $flash->get('content') : @$item['content'] ?></textarea>
                    </div>
                <?php } ?>
                <?php if (isset($config['newsletter'][$type]['notes']) && $config['newsletter'][$type]['notes'] == true) { ?>
                    <div class="form-group">
                        <label for="notes">Ghi chú:</label>
                        <textarea class="form-control text-sm" name="data[notes]" id="notes" rows="5" placeholder="Ghi chú"><?= (!empty($flash->has('notes'))) ? $flash->get('notes') : @$item['notes'] ?></textarea>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label for="numb" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
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