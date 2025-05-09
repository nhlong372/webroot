<div class="card card-primary card-outline text-sm">
    <div class="card-header">
        <h3 class="card-title">Đường dẫn</h3>
        <span class="pl-2 text-danger">(Vui lòng không nhập trùng tiêu đề)</span>
    </div>
    <div class="card-body card-slug">
        <?php if (isset($slugchange) && $slugchange == 1) { ?>
            <div class="form-group mb-2">
                <label for="slugchange" class="d-inline-block align-middle text-info mb-0 mr-2">Thay đổi đường dẫn theo tiêu đề mới:</label>
                <div class="custom-control custom-checkbox d-inline-block align-middle">
                    <input type="checkbox" class="custom-control-input" name="slugchange" id="slugchange">
                    <label for="slugchange" class="custom-control-label"></label>
                </div>
            </div>
        <?php } ?>

        <input type="hidden" class="slug-id" value="<?= isset($id) ? $id : '' ?>">
        <input type="hidden" class="slug-copy" value="<?= (isset($copy) && $copy == true) ? 1 : 0 ?>">

        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                    <?php foreach ($config['website']['slug'] as $k => $v) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang" data-toggle="pill" href="#tabs-sluglang-<?= $k ?>" role="tab" aria-controls="tabs-sluglang-<?= $k ?>" aria-selected="true"><?= $v ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                    <?php foreach ($config['website']['slug'] as $k => $v) { ?>
                        <div class="tab-pane fade show <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-sluglang-<?= $k ?>" role="tabpanel" aria-labelledby="tabs-lang">
                            <div class="form-gourp mb-0">
                                <label class="d-block">Đường dẫn mẫu (<?= $k ?>):<span class="pl-2 font-weight-normal" id="slugurlpreview<?= $k ?>"><?= $configBase ?><strong class="text-info"><?= @$item['slug' . $k] ?></strong></span></label>
                                <input type="text" class="form-control slug-input no-validate text-sm" name="slug<?= $k ?>" id="slug<?= $k ?>" placeholder="Đường dẫn (<?= $k ?>)" value="<?= @$item['slug' . $k] ?>" required>
                                <input type="hidden" id="slug-default<?= $k ?>" value="<?= @$item['slug' . $k] ?>">
                                <p class="alert-slug<?= $k ?> text-danger d-none mt-2 mb-0" id="alert-slug-danger<?= $k ?>">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <span>Đường dẫn đã tồn tại. Đường dẫn truy cập mục này có thể bị trùng lặp.</span>
                                </p>
                                <p class="alert-slug<?= $k ?> text-success d-none mt-2 mb-0" id="alert-slug-success<?= $k ?>">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    <span>Đường dẫn hợp lệ.</span>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>