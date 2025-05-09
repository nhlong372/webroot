<li class="jFiler-item my-jFiler-item my-jFiler-item-<?= $params['id'] ?> <?= $params['col'] ?>" data-id="<?= $params['id'] ?>">
    <div class="jFiler-item-container">
        <div class="jFiler-item-inner">
            <div class="jFiler-item-thumb">
                <div class="jFiler-item-thumb-image">
                    <?= $this->getImage(['isLazy' => false, 'sizes' => '235x150x2', 'upload' => 'upload/' . $params['folder'] . '/', 'image' => $params['photo'], 'alt' => $params['name']]); ?>
                    <i class="fas fa-arrows-alt"></i>
                </div>
            </div>
            <div class="jFiler-item-assets jFiler-row">
                <ul class="list-inline pull-right d-flex align-items-center justify-content-between">
                    <li class="ml-1">
                        <a class="icon-jfi-trash jFiler-item-trash-action my-jFiler-item-trash" data-id="<?= $params['id'] ?>" data-folder="<?= $params['folder'] ?>"></a>
                    </li>
                    <li class="mr-1">
                        <div class="custom-control custom-checkbox d-inline-block align-middle text-md">
                            <input type="checkbox" class="custom-control-input filer-checkbox" id="filer-checkbox-<?= $params['id'] ?>" value="<?= $params['id'] ?>">
                            <label for="filer-checkbox-<?= $params['id'] ?>" class="custom-control-label font-weight-normal">Chọn</label>
                        </div>
                    </li>
                </ul>
            </div>
            <input type="number" class="form-control form-control-sm my-jFiler-item-info rounded mb-1 text-sm" value="<?= $params['numb'] ?>" placeholder="Số thứ tự" data-info="numb" data-id="<?= $params['id'] ?>" />
            <input type="text" class="form-control form-control-sm my-jFiler-item-info rounded text-sm" value="<?= $params['name'] ?>" placeholder="Tiêu đề" data-info="name" data-id="<?= $params['id'] ?>" />
        </div>
    </div>
</li>