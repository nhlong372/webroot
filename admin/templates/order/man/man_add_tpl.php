<?php
$linkMan = "index.php?com=order&act=man";
$linkSave = "index.php?com=order&act=save";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item"><a href="<?= $linkMan ?>" title="Quản lý đơn hàng">Quản lý đơn hàng</a></li>
                <li class="breadcrumb-item active">Thông tin đơn hàng <span class="text-primary">#<?= $item['code'] ?></span></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin chính</h3>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-4 col-sm-6">
                    <label>Mã đơn hàng:</label>
                    <p class="text-primary"><?= @$item['code'] ?></p>
                </div>
                <div class="form-group col-md-4 col-sm-6">
                    <label>Hình thức thanh toán:</label>
                    <?php $order_payment = $func->getInfoDetail('namevi', 'news', @$item['order_payment']); ?>
                    <p class="text-info"><?= $order_payment['namevi'] ?></p>
                </div>
                <div class="form-group col-md-4 col-sm-6">
                    <label>Họ tên:</label>
                    <p class="font-weight-bold text-uppercase text-success"><?= @$item['fullname'] ?></p>
                </div>
                <div class="form-group col-md-4 col-sm-6">
                    <label>Điện thoại:</label>
                    <p><?= @$item['phone'] ?></p>
                </div>
                <div class="form-group col-md-4 col-sm-6">
                    <label>Email:</label>
                    <p><?= @$item['email'] ?></p>
                </div>
                <div class="form-group col-md-4 col-sm-6">
                    <label>Địa chỉ:</label>
                    <p><?= @$item['address'] ?></p>
                </div>
                <?php if (isset($config['order']['ship']) && $config['order']['ship'] == true) { ?>
                    <div class="form-group col-md-4 col-sm-6">
                        <label>Phí vận chuyển:</label>
                        <p class="font-weight-bold text-danger">
                            <?php if (isset($item['ship_price']) && $item['ship_price'] > 0) { ?>
                                <?= $func->formatMoney($item['ship_price']) ?>
                            <?php } else { ?>
                                Không
                            <?php } ?>
                        </p>
                    </div>
                <?php } ?>
                <div class="form-group col-md-4 col-sm-6">
                    <label>Ngày đặt:</label>
                    <p><?= date("h:i:s A - d/m/Y", @$item['date_created']) ?></p>
                </div>
                <div class="form-group col-12">
                    <label for="requirements">Yêu cầu khác:</label>
                    <textarea class="form-control text-sm" name="data[requirements]" id="requirements" rows="5" placeholder="Yêu cầu khác"><?= @$item['requirements'] ?></textarea>
                </div>
                <div class="form-group col-12">
                    <label for="order_status" class="mr-2">Tình trạng:</label>
                    <?= $func->orderStatus(@$item['order_status']) ?>
                </div>
                <div class="form-group col-12">
                    <label for="notes">Ghi chú:</label>
                    <textarea class="form-control text-sm" name="data[notes]" id="notes" rows="5" placeholder="Ghi chú"><?= @$item['notes'] ?></textarea>
                </div>
                <?php /* ?>
				    <div class="form-group">
	                    <label for="numb" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
	                    <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?=isset($item['numb']) ? $item['numb'] : 1?>">
	                </div>
	            <?php */ ?>
            </div>
        </div>
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Chi tiết đơn hàng</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="align-middle text-center" width="10%">STT</th>
                            <th class="align-middle">Hình ảnh</th>
                            <th class="align-middle" style="width:30%">Tên sản phẩm</th>
                            <th class="align-middle text-center">Đơn giá</th>
                            <th class="align-middle text-right">Số lượng</th>
                            <th class="align-middle text-right">Tạm tính</th>
                        </tr>
                    </thead>
                    <?php if (empty($order_detail)) { ?>
                        <tbody>
                            <tr>
                                <td colspan="100" class="text-center">Không có dữ liệu</td>
                            </tr>
                        </tbody>
                    <?php } else { ?>
                        <tbody>
                            <?php foreach ($order_detail as $k => $v) { ?>
                                <tr>
                                    <td class="align-middle text-center"><?= ($k + 1) ?></td>
                                    <td class="align-middle">
                                        <a title="<?= $v['name'] ?>">
                                            <?= $func->getImage(['class' => 'rounded img-preview', 'sizes' => $config['order']['thumb'], 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name']]) ?>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-primary mb-1"><?= $v['name'] ?></p>
                                        <?php if ($v['color'] != '' || $v['size'] != '') { ?>
                                            <p class="mb-0">
                                                <?php if ($v['color'] != '') { ?>
                                                    <span class="pr-2">Màu: <?= $v['color'] ?></span>
                                                <?php } ?>
                                                <?php if ($v['size'] != '') { ?>
                                                    <span>Size: <?= $v['size'] ?></span>
                                                <?php } ?>
                                            </p>
                                        <?php } ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="price-cart-detail">
                                            <?php if ($v['sale_price']) { ?>
                                                <span class="price-new-cart-detail"><?= $func->formatMoney($v['sale_price']) ?></span>
                                                <span class="price-old-cart-detail"><?= $func->formatMoney($v['regular_price']) ?></span>
                                            <?php } else { ?>
                                                <span class="price-new-cart-detail"><?= $func->formatMoney($v['regular_price']) ?></span>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td class="align-middle text-right"><?= $v['quantity'] ?></td>
                                    <td class="align-middle text-right">
                                        <div class="price-cart-detail">
                                            <?php if ($v['sale_price']) { ?>
                                                <span class="price-new-cart-detail"><?= $func->formatMoney($v['sale_price'] * $v['quantity']) ?></span>
                                                <span class="price-old-cart-detail"><?= $func->formatMoney($v['regular_price'] * $v['quantity']) ?></span>
                                            <?php } else { ?>
                                                <span class="price-new-cart-detail"><?= $func->formatMoney($v['regular_price'] * $v['quantity']) ?></span>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (
                                (isset($config['order']['ship']) && $config['order']['ship'] == true)
                            ) { ?>
                                <tr>
                                    <td colspan="5" class="title-money-cart-detail">Tạm tính:</td>
                                    <td colspan="1" class="cast-money-cart-detail"><?= $func->formatMoney($item['temp_price']) ?></td>
                                </tr>
                            <?php } ?>
                            <?php if (isset($config['order']['ship']) && $config['order']['ship'] == true) { ?>
                                <tr>
                                    <td colspan="5" class="title-money-cart-detail">Phí vận chuyển:</td>
                                    <td colspan="1" class="cast-money-cart-detail">
                                        <?php if ($item['ship_price']) { ?>
                                            <?= $func->formatMoney($item['ship_price']) ?>
                                        <?php } else { ?>
                                            Không
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="5" class="title-money-cart-detail">Tổng giá trị đơn hàng:</td>
                                <td colspan="1" class="cast-money-cart-detail"><?= $func->formatMoney($item['total_price']) ?></td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>