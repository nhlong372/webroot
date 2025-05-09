<?php
$linkExportExcel = "index.php?com=export&act=exportExcel&type=" . $type;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Export Excel</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkExportExcel ?>" enctype="multipart/form-data">
        <div class="card card-primary card-outline text-sm mb-0">
            <div class="card-header">
                <h3 class="card-title">Export danh sách dữ liệu</h3>
            </div>
            <div class="card-body">
                <?php if (isset($config['export']['category']) && $config['export']['category'] == true) { ?>
                    <div class="form-group-category row">
                        <?php if (isset($config['product'][$type]['list']) && $config['product'][$type]['list'] == true) { ?>
                            <div class="form-group col-md-3 col-sm-4">
                                <label class="d-block" for="id_list">Danh mục cấp 1:</label>
                                <?= $func->getAjaxCategory('product', 'list', $type) ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($config['product'][$type]['cat']) && $config['product'][$type]['cat'] == true) { ?>
                            <div class="form-group col-md-3 col-sm-4">
                                <label class="d-block" for="id_cat">Danh mục cấp 2:</label>
                                <?= $func->getAjaxCategory('product', 'cat', $type) ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($config['product'][$type]['item']) && $config['product'][$type]['item'] == true) { ?>
                            <div class="form-group col-md-3 col-sm-4">
                                <label class="d-block" for="id_item">Danh mục cấp 3:</label>
                                <?= $func->getAjaxCategory('product', 'item', $type) ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($config['product'][$type]['sub']) && $config['product'][$type]['sub'] == true) { ?>
                            <div class="form-group col-md-3 col-sm-4">
                                <label class="d-block" for="id_sub">Danh mục cấp 4:</label>
                                <?= $func->getAjaxCategory('product', 'sub', $type) ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="alert my-alert alert-info mb-0" role="alert">Xuất danh sách sản phẩm thành tập tin excel</div>
                <?php } ?>
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-success" name="exportExcel"><i class="fas fa-file-export mr-2"></i>Export</button>
        </div>
    </form>
</section>