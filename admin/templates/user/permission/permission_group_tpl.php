<?php
$linkMan = "index.php?com=user&act=permission_group";
$linkSave = "index.php?com=user&act=save_permission_group";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= ($act == "edit_permission_group") ? "Cập nhật" : "Thêm mới"; ?> nhóm quyền</li>
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
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin chính</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Tên nhóm quyền: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control text-sm" name="data[name]" id="name" placeholder="Tên nhóm quyền" value="<?= @$item['name'] ?>" required>
                </div>
                <div class="form-group">
                    <label class="d-inline-block align-middle mb-0" for="selectall-checkbox">Chọn tất cả:</label>
                    <div class="custom-control custom-checkbox d-inline-block align-middle ml-2">
                        <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                        <label for="selectall-checkbox" class="custom-control-label"></label>
                    </div>
                </div>
                <div class="form-group">
                    <?php $status_array = (!empty($item['status'])) ? explode(',', $item['status']) : array(); ?>
                    <?php if (isset($config['permission']['check'])) {
                        foreach ($config['permission']['check'] as $key => $value) { ?>
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
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                </div>
            </div>
        </div>
        <?php if (isset($config['product'])) { ?>
            <?php foreach ($config['product'] as $key => $value) { ?>
                <div class="card card-permission card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Quản lý <?= $value['title_main'] ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (isset($value['list']) && $value['list'] == true) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-list-<?= $key ?>">Danh mục cấp 1:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-list-view-<?= $key ?>" value="product_man_list_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_man_list_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-list-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-list-add-<?= $key ?>" value="product_add_list_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_add_list_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-list-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-list-edit-<?= $key ?>" value="product_edit_list_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_edit_list_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-list-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-list-delete-<?= $key ?>" value="product_delete_list_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_delete_list_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-list-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($value['cat']) && $value['cat'] == true) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-cat-<?= $key ?>">Danh mục cấp 2:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-cat-view-<?= $key ?>" value="product_man_cat_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_man_cat_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-cat-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-cat-add-<?= $key ?>" value="product_add_cat_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_add_cat_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-cat-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-cat-edit-<?= $key ?>" value="product_edit_cat_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_edit_cat_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-cat-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-cat-delete-<?= $key ?>" value="product_delete_cat_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_delete_cat_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-cat-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($value['item']) && $value['item'] == true) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-item-<?= $key ?>">Danh mục cấp 3:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-item-view-<?= $key ?>" value="product_man_item_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_man_item_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-item-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-item-add-<?= $key ?>" value="product_add_item_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_add_item_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-item-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-item-edit-<?= $key ?>" value="product_edit_item_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_edit_item_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-item-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-item-delete-<?= $key ?>" value="product_delete_item_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_delete_item_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-item-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($value['sub']) && $value['sub'] == true) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-sub-<?= $key ?>">Danh mục cấp 4:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-sub-view-<?= $key ?>" value="product_man_sub_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_man_sub_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-sub-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-sub-add-<?= $key ?>" value="product_add_sub_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_add_sub_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-sub-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-sub-edit-<?= $key ?>" value="product_edit_sub_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_edit_sub_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-sub-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-sub-delete-<?= $key ?>" value="product_delete_sub_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_delete_sub_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-sub-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($value['brand']) && $value['brand'] == true) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-brand-<?= $key ?>">Danh mục hãng:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-brand-view-<?= $key ?>" value="product_man_brand_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_man_brand_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-brand-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-brand-add-<?= $key ?>" value="product_add_brand_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_add_brand_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-brand-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-brand-edit-<?= $key ?>" value="product_edit_brand_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_edit_brand_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-brand-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-brand-delete-<?= $key ?>" value="product_delete_brand_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_delete_brand_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-brand-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($value['color']) && $value['color'] == true) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-color-<?= $key ?>">Danh mục màu sắc:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-color-view-<?= $key ?>" value="product_man_color_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_man_color_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-color-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-color-add-<?= $key ?>" value="product_add_color_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_add_color_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-color-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-color-edit-<?= $key ?>" value="product_edit_color_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_edit_color_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-color-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-color-delete-<?= $key ?>" value="product_delete_color_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_delete_color_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-color-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($value['size']) && $value['size'] == true) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-size-<?= $key ?>">Danh mục kích thước:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-size-view-<?= $key ?>" value="product_man_size_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_man_size_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-size-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-size-add-<?= $key ?>" value="product_add_size_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_add_size_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-size-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-size-edit-<?= $key ?>" value="product_edit_size_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_edit_size_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-size-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-size-delete-<?= $key ?>" value="product_delete_size_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_delete_size_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-size-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group row">
                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-<?= $key ?>"><?= $value['title_main'] ?>:</label>
                            <div class="col-md-7">
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-view-<?= $key ?>" value="product_man_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_man_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-product-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-add-<?= $key ?>" value="product_add_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_add_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-product-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-edit-<?= $key ?>" value="product_edit_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_edit_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-product-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-delete-<?= $key ?>" value="product_delete_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_delete_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-product-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($value['comment']) && $value['comment'] == true) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-comment-product-<?= $key ?>"><?= $value['title_main'] ?> <span class="font-weight-normal">(Bình luận)</span>:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-comment-product-view-<?= $key ?>" value="comment_man_product_<?= $key ?>" <?= (isset($lists_permission) && in_array('comment_man_product_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-comment-product-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($value['gallery']) && count($value['gallery']) > 0) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-photo-<?= $key ?>"><?= $value['title_main'] ?> <span class="font-weight-normal">(Hình ảnh)</span>:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-photo-view-<?= $key ?>" value="product_man_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_man_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-photo-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-photo-add-<?= $key ?>" value="product_add_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_add_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-photo-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-photo-edit-<?= $key ?>" value="product_edit_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_edit_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-photo-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-photo-delete-<?= $key ?>" value="product_delete_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('product_delete_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-photo-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($value['import']) && $value['import'] == true) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-import-<?= $key ?>">Import:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-import-man-<?= $key ?>" value="import_man_<?= $key ?>" <?= (isset($lists_permission) && in_array('import_man_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-import-man-<?= $key ?>" class="custom-control-label font-weight-normal">Upload danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-import-editImages-<?= $key ?>" value="import_editImages_<?= $key ?>" <?= (isset($lists_permission) && in_array('import_editImages_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-import-editImages-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa hình ảnh</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-import-deleteImages-<?= $key ?>" value="import_deleteImages_<?= $key ?>" <?= (isset($lists_permission) && in_array('import_deleteImages_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-import-deleteImages-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa hình ảnh</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($value['export']) && $value['export'] == true) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-export-<?= $key ?>">Export:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-product-export-<?= $key ?>" value="export_man_<?= $key ?>" <?= (isset($lists_permission) && in_array('export_man_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-product-export-<?= $key ?>" class="custom-control-label font-weight-normal">Export danh sách</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
        <?php if (isset($config['news'])) { ?>
            <?php foreach ($config['news'] as $key => $value) {
                if (isset($value['dropdown']) && $value['dropdown'] == true) { ?>
                    <div class="card card-permission card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Quản lý <?= $value['title_main'] ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (isset($value['list']) && $value['list'] == true) { ?>
                                <div class="form-group row">
                                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-news-list-<?= $key ?>">Danh mục cấp 1:</label>
                                    <div class="col-md-7">
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-list-view-<?= $key ?>" value="news_man_list_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_man_list_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-list-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-list-add-<?= $key ?>" value="news_add_list_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_add_list_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-list-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-list-edit-<?= $key ?>" value="news_edit_list_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_edit_list_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-list-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-list-delete-<?= $key ?>" value="news_delete_list_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_delete_list_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-list-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($value['cat']) && $value['cat'] == true) { ?>
                                <div class="form-group row">
                                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-news-cat-<?= $key ?>">Danh mục cấp 2:</label>
                                    <div class="col-md-7">
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-cat-view-<?= $key ?>" value="news_man_cat_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_man_cat_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-cat-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-cat-add-<?= $key ?>" value="news_add_cat_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_add_cat_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-cat-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-cat-edit-<?= $key ?>" value="news_edit_cat_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_edit_cat_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-cat-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-cat-delete-<?= $key ?>" value="news_delete_cat_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_delete_cat_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-cat-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($value['item']) && $value['item'] == true) { ?>
                                <div class="form-group row">
                                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-news-item-<?= $key ?>">Danh mục cấp 3:</label>
                                    <div class="col-md-7">
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-item-view-<?= $key ?>" value="news_man_item_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_man_item_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-item-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-item-add-<?= $key ?>" value="news_add_item_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_add_item_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-item-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-item-edit-<?= $key ?>" value="news_edit_item_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_edit_item_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-item-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-item-delete-<?= $key ?>" value="news_delete_item_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_delete_item_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-item-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($value['sub']) && $value['sub'] == true) { ?>
                                <div class="form-group row">
                                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-news-sub-<?= $key ?>">Danh mục cấp 4:</label>
                                    <div class="col-md-7">
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-sub-view-<?= $key ?>" value="news_man_sub_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_man_sub_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-sub-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-sub-add-<?= $key ?>" value="news_add_sub_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_add_sub_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-sub-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-sub-edit-<?= $key ?>" value="news_edit_sub_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_edit_sub_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-sub-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-sub-delete-<?= $key ?>" value="news_delete_sub_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_delete_sub_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-sub-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-news-<?= $key ?>"><?= $value['title_main'] ?>:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-view-<?= $key ?>" value="news_man_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_man_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-news-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-add-<?= $key ?>" value="news_add_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_add_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-news-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-edit-<?= $key ?>" value="news_edit_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_edit_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-news-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-delete-<?= $key ?>" value="news_delete_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_delete_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-news-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($value['comment']) && $value['comment'] == true) { ?>
                                <div class="form-group row">
                                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-comment-news-<?= $key ?>"><?= $value['title_main'] ?> <span class="font-weight-normal">(Bình luận)</span>:</label>
                                    <div class="col-md-7">
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-comment-news-view-<?= $key ?>" value="comment_man_news_<?= $key ?>" <?= (isset($lists_permission) && in_array('comment_man_news_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-comment-news-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($value['gallery']) && count($value['gallery']) > 0) { ?>
                                <div class="form-group row">
                                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-news-photo-<?= $key ?>"><?= $value['title_main'] ?> <span class="font-weight-normal">(Hình ảnh)</span>:</label>
                                    <div class="col-md-7">
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-photo-view-<?= $key ?>" value="news_man_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_man_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-photo-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-photo-add-<?= $key ?>" value="news_add_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_add_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-photo-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-photo-edit-<?= $key ?>" value="news_edit_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_edit_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-photo-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-photo-delete-<?= $key ?>" value="news_delete_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_delete_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-photo-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
            <?php }
            } ?>
        <?php } ?>
        <?php if (isset($config['shownews']) && $config['shownews'] == true) { ?>
            <div class="card card-permission card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Quản lý bài viết</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php foreach ($config['news'] as $key => $value) {
                        if (!isset($value['dropdown']) || $value['dropdown'] == false) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-news-<?= $key ?>"><?= $value['title_main'] ?>:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-view-<?= $key ?>" value="news_man_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_man_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-news-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-add-<?= $key ?>" value="news_add_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_add_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-news-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-edit-<?= $key ?>" value="news_edit_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_edit_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-news-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-delete-<?= $key ?>" value="news_delete_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_delete_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-news-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($value['gallery']) && count($value['gallery']) > 0) { ?>
                                <div class="form-group row">
                                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-news-photo-<?= $key ?>"><?= $value['title_main'] ?> <span class="font-weight-normal">(Hình ảnh)</span>:</label>
                                    <div class="col-md-7">
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-photo-view-<?= $key ?>" value="news_man_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_man_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-photo-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-photo-add-<?= $key ?>" value="news_add_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_add_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-photo-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-photo-edit-<?= $key ?>" value="news_edit_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_edit_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-photo-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                            <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-news-photo-delete-<?= $key ?>" value="news_delete_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('news_delete_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                            <label for="quyen-news-photo-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                    <?php }
                    } ?>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($config['photo'])) { ?>
            <div class="card card-permission card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Quản lý hình ảnh - video</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (isset($config['photo']['photo_static'])) {
                        foreach ($config['photo']['photo_static'] as $key => $value) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-photo-static-<?= $key ?>"><?= $value['title_main'] ?>:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-photo-static-<?= $key ?>" value="photo_photo_static_<?= $key ?>" <?= (isset($lists_permission) && in_array('photo_photo_static_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-photo-static-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                    <?php if (isset($config['photo']['man_photo'])) {
                        foreach ($config['photo']['man_photo'] as $key => $value) { ?>
                            <div class="form-group row">
                                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-man-photo-<?= $key ?>"><?= $value['title_main_photo'] ?>:</label>
                                <div class="col-md-7">
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-man-photo-view-<?= $key ?>" value="photo_man_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('photo_man_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-man-photo-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-man-photo-add-<?= $key ?>" value="photo_add_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('photo_add_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-man-photo-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-man-photo-edit-<?= $key ?>" value="photo_edit_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('photo_edit_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-man-photo-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-man-photo-delete-<?= $key ?>" value="photo_delete_photo_<?= $key ?>" <?= (isset($lists_permission) && in_array('photo_delete_photo_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                        <label for="quyen-man-photo-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($config['order']['active']) && $config['order']['active'] == true) { ?>
            <div class="card card-permission card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Quản lý đơn hàng</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-order-view" value="order_man" <?= (isset($lists_permission) && in_array('order_man', $lists_permission)) ? 'checked' : ''; ?>>
                        <label for="quyen-order-view" class="custom-control-label font-weight-normal">Xem danh sách</label>
                    </div>
                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-order-edit" value="order_edit" <?= (isset($lists_permission) && in_array('order_edit', $lists_permission)) ? 'checked' : ''; ?>>
                        <label for="quyen-order-edit" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                    </div>
                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-order-delete" value="order_delete" <?= (isset($lists_permission) && in_array('order_delete', $lists_permission)) ? 'checked' : ''; ?>>
                        <label for="quyen-order-delete" class="custom-control-label font-weight-normal">Xóa</label>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($config['tags'])) { ?>
            <div class="card card-permission card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Quản lý tags</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php foreach ($config['tags'] as $key => $value) { ?>
                        <div class="form-group row">
                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-tags-<?= $key ?>"><?= $value['title_main'] ?>:</label>
                            <div class="col-md-7">
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-tags-view-<?= $key ?>" value="tags_man_<?= $key ?>" <?= (isset($lists_permission) && in_array('tags_man_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-tags-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-tags-add-<?= $key ?>" value="tags_add_<?= $key ?>" <?= (isset($lists_permission) && in_array('tags_add_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-tags-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-tags-edit-<?= $key ?>" value="tags_edit_<?= $key ?>" <?= (isset($lists_permission) && in_array('tags_edit_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-tags-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-tags-delete-<?= $key ?>" value="tags_delete_<?= $key ?>" <?= (isset($lists_permission) && in_array('tags_delete_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-tags-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($config['newsletter'])) { ?>
            <div class="card card-permission card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Quản lý nhận tin</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php foreach ($config['newsletter'] as $key => $value) { ?>
                        <div class="form-group row">
                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-email-<?= $key ?>"><?= $value['title_main'] ?>:</label>
                            <div class="col-md-7">
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-email-view-<?= $key ?>" value="newsletter_man_<?= $key ?>" <?= (isset($lists_permission) && in_array('newsletter_man_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-email-view-<?= $key ?>" class="custom-control-label font-weight-normal">Xem danh sách</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-email-add-<?= $key ?>" value="newsletter_add_<?= $key ?>" <?= (isset($lists_permission) && in_array('newsletter_add_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-email-add-<?= $key ?>" class="custom-control-label font-weight-normal">Thêm mới</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-email-edit-<?= $key ?>" value="newsletter_edit_<?= $key ?>" <?= (isset($lists_permission) && in_array('newsletter_edit_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-email-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-email-delete-<?= $key ?>" value="newsletter_delete_<?= $key ?>" <?= (isset($lists_permission) && in_array('newsletter_delete_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-email-delete-<?= $key ?>" class="custom-control-label font-weight-normal">Xóa</label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($config['static'])) { ?>
            <div class="card card-permission card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Quản lý trang tĩnh</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php foreach ($config['static'] as $key => $value) { ?>
                        <div class="form-group row">
                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-static-<?= $key ?>"><?= $value['title_main'] ?>:</label>
                            <div class="col-md-7">
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-static-edit-<?= $key ?>" value="static_update_<?= $key ?>" <?= (isset($lists_permission) && in_array('static_update_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                    <label for="quyen-static-edit-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($config['places']['active']) && $config['places']['active'] == true) { ?>
            <div class="card card-permission card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Quản lý địa điểm</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-places-city">Tỉnh thành:</label>
                        <div class="col-md-7">
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-city-view" value="places_man_city" <?= (isset($lists_permission) && in_array('places_man_city', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-city-view" class="custom-control-label font-weight-normal">Xem danh sách</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-city-add" value="places_add_city" <?= (isset($lists_permission) && in_array('places_add_city', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-city-add" class="custom-control-label font-weight-normal">Thêm mới</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-city-edit" value="places_edit_city" <?= (isset($lists_permission) && in_array('places_edit_city', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-city-edit" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-city-delete" value="places_delete_city" <?= (isset($lists_permission) && in_array('places_delete_city', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-city-delete" class="custom-control-label font-weight-normal">Xóa</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-places-district">Quận huyện:</label>
                        <div class="col-md-7">
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-district-view" value="places_man_district" <?= (isset($lists_permission) && in_array('places_man_district', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-district-view" class="custom-control-label font-weight-normal">Xem danh sách</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-district-add" value="places_add_district" <?= (isset($lists_permission) && in_array('places_add_district', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-district-add" class="custom-control-label font-weight-normal">Thêm mới</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-district-edit" value="places_edit_district" <?= (isset($lists_permission) && in_array('places_edit_district', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-district-edit" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-district-delete" value="places_delete_district" <?= (isset($lists_permission) && in_array('places_delete_district', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-district-delete" class="custom-control-label font-weight-normal">Xóa</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-places-ward">Phường xã:</label>
                        <div class="col-md-7">
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-ward-view" value="places_man_ward" <?= (isset($lists_permission) && in_array('places_man_ward', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-ward-view" class="custom-control-label font-weight-normal">Xem danh sách</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-ward-add" value="places_add_ward" <?= (isset($lists_permission) && in_array('places_add_ward', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-ward-add" class="custom-control-label font-weight-normal">Thêm mới</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-ward-edit" value="places_edit_ward" <?= (isset($lists_permission) && in_array('places_edit_ward', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-ward-edit" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-places-ward-delete" value="places_delete_ward" <?= (isset($lists_permission) && in_array('places_delete_ward', $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-places-ward-delete" class="custom-control-label font-weight-normal">Xóa</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($config['onesignal']) && $config['onesignal'] == true) { ?>
            <div class="card card-permission card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Quản lý thông báo đẩy</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-onesignal-view" value="pushOnesignal_man" <?= (isset($lists_permission) && in_array('pushOnesignal_man', $lists_permission)) ? 'checked' : ''; ?>>
                        <label for="quyen-onesignal-view" class="custom-control-label font-weight-normal">Xem danh sách</label>
                    </div>
                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-onesignal-add" value="pushOnesignal_add" <?= (isset($lists_permission) && in_array('pushOnesignal_add', $lists_permission)) ? 'checked' : ''; ?>>
                        <label for="quyen-onesignal-add" class="custom-control-label font-weight-normal">Thêm mới</label>
                    </div>
                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-onesignal-edit" value="pushOnesignal_edit" <?= (isset($lists_permission) && in_array('pushOnesignal_edit', $lists_permission)) ? 'checked' : ''; ?>>
                        <label for="quyen-onesignal-edit" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                    </div>
                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-onesignal-push" value="pushOnesignal_sync" <?= (isset($lists_permission) && in_array('pushOnesignal_sync', $lists_permission)) ? 'checked' : ''; ?>>
                        <label for="quyen-onesignal-push" class="custom-control-label font-weight-normal">Đẩy tin</label>
                    </div>
                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-onesignal-delete" value="pushOnesignal_delete" <?= (isset($lists_permission) && in_array('pushOnesignal_delete', $lists_permission)) ? 'checked' : ''; ?>>
                        <label for="quyen-onesignal-delete" class="custom-control-label font-weight-normal">Xóa</label>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($config['seopage']) && count($config['seopage']['page']) > 0) { ?>
            <div class="card card-permission card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Quản lý SEO page</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php foreach ($config['seopage']['page'] as $key => $value) { ?>
                        <div class="form-group row">
                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-seopage-<?= $key ?>"><?= $value ?>:</label>
                            <div class="custom-control custom-checkbox d-inline-block align-middle text-md mb-2 col-md-7">
                                <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-seopage-<?= $key ?>" value="seopage_update_<?= $key ?>" <?= (isset($lists_permission) && in_array('seopage_update_' . $key, $lists_permission)) ? 'checked' : ''; ?>>
                                <label for="quyen-seopage-<?= $key ?>" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="card card-permission card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Quản lý thông tin công ty</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="custom-control custom-checkbox text-md">
                        <input type="checkbox" class="custom-control-input" name="dataPermission[]" id="quyen-setting" value="setting_update" <?= (isset($lists_permission) && in_array('setting_update', $lists_permission)) ? 'checked' : ''; ?>>
                        <label for="quyen-setting" class="custom-control-label font-weight-normal">Chỉnh sửa</label>
                    </div>
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