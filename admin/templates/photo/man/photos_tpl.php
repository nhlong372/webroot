<?php
$linkMan = "index.php?com=photo&act=man_photo&type=" . $type;
$linkAdd = "index.php?com=photo&act=add_photo&type=" . $type;
$linkEdit = "index.php?com=photo&act=edit_photo&type=" . $type;
$linkDelete = "index.php?com=photo&act=delete_photo&type=" . $type;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý hình ảnh - video</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <?php if($config['photo']['man_photo'][$type]['notadd']!='khongthemxoa') { ?>
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
    </div>
    <?php } ?>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title">Danh sách <?= $config['photo']['man_photo'][$type]['title_main_photo'] ?></h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">
                            <div class="custom-control custom-checkbox my-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                                <label for="selectall-checkbox" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="align-middle text-center" width="10%">STT</th>
                        <?php if (isset($config['photo']['man_photo'][$type]['avatar_photo']) && $config['photo']['man_photo'][$type]['avatar_photo'] == true) { ?>
                            <th class="align-middle text-center" width="8%">Hình</th>
                        <?php } ?>
                        <?php if (isset($config['photo']['man_photo'][$type]['name_photo']) && $config['photo']['man_photo'][$type]['name_photo'] == true) { ?>
                            <th class="align-middle" style="width:30%">Tiêu đề</th>
                        <?php } ?>
                        <?php if (isset($config['photo']['man_photo'][$type]['link_photo']) && $config['photo']['man_photo'][$type]['link_photo'] == true) { ?>
                            <th class="align-middle">Link</th>
                        <?php } ?>
                        <?php if (isset($config['photo']['man_photo'][$type]['video_photo']) && $config['photo']['man_photo'][$type]['video_photo'] == true) { ?>
                            <th class="align-middle">Link video</th>
                        <?php } ?>
                        <?php if (isset($config['photo']['man_photo'][$type]['check_photo'])) {
                            foreach ($config['photo']['man_photo'][$type]['check_photo'] as $key => $value) { ?>
                                <th class="align-middle text-center"><?= $value ?></th>
                        <?php }
                        } ?>
                        <th class="align-middle text-center">Thao tác</th>
                    </tr>
                </thead>
                <?php if (empty($items)) { ?>
                    <tbody>
                        <tr>
                            <td colspan="100" class="text-center">Không có dữ liệu</td>
                        </tr>
                    </tbody>
                <?php } else { ?>
                    <tbody>
                        <?php for ($i = 0; $i < count($items); $i++) { ?>
                            <tr>
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?= $items[$i]['id'] ?>" value="<?= $items[$i]['id'] ?>">
                                        <label for="select-checkbox-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="photo">
                                </td>
                                <?php if (isset($config['photo']['man_photo'][$type]['avatar_photo']) && $config['photo']['man_photo'][$type]['avatar_photo'] == true) { ?>
                                    <td class="align-middle text-center">
                                        <a href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>">
                                            <p class="mb-0" style="<?=$config['photo']['man_photo'][$type]['css_hinh']?>">
                                            <?= $func->getImage(['class' => 'rounded img-preview', 'sizes' => $config['photo']['man_photo'][$type]['thumb_photo'], 'upload' => UPLOAD_PHOTO_L, 'image' => $items[$i]['photo'], 'alt' => $items[$i]['namevi']]) ?>
                                            </p>
                                        </a>
                                    </td>
                                <?php } ?>
                                <?php if (isset($config['photo']['man_photo'][$type]['name_photo']) && $config['photo']['man_photo'][$type]['name_photo'] == true) { ?>
                                    <td class="align-middle">
                                        <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><?= $items[$i]['namevi'] ?></a>
                                    </td>
                                <?php } ?>
                                <?php if (isset($config['photo']['man_photo'][$type]['link_photo']) && $config['photo']['man_photo'][$type]['link_photo'] == true) { ?>
                                    <td class="align-middle"><?= $items[$i]['link'] ?></td>
                                <?php } ?>
                                <?php if (isset($config['photo']['man_photo'][$type]['video_photo']) && $config['photo']['man_photo'][$type]['video_photo'] == true) { ?>
                                    <td class="align-middle"><?= $items[$i]['link_video'] ?></td>
                                <?php } ?>
                                <?php $status_array = (!empty($items[$i]['status'])) ? explode(',', $items[$i]['status']) : array(); ?>
                                <?php if (isset($config['photo']['man_photo'][$type]['check_photo'])) {
                                    foreach ($config['photo']['man_photo'][$type]['check_photo'] as $key => $value) { ?>
                                        <td class="align-middle text-center">
                                            <div class="custom-control custom-checkbox my-checkbox">
                                                <input type="checkbox" class="custom-control-input show-checkbox" id="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" data-table="photo" data-id="<?= $items[$i]['id'] ?>" data-attr="<?= $key ?>" <?= (in_array($key, $status_array)) ? 'checked' : '' ?>>
                                                <label for="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                            </div>
                                        </td>
                                <?php }
                                } ?>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-primary mr-2" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                    <?php if($config['photo']['man_photo'][$type]['notadd']!='khongthemxoa') { ?>
                                    <a class="text-danger" id="delete-item" data-url="<?= $linkDelete ?>&id=<?= $items[$i]['id'] ?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if ($paging) { ?>
        <div class="card-footer text-sm pb-0">
            <?= $paging ?>
        </div>
    <?php } ?>
    <?php if($config['photo']['man_photo'][$type]['notadd']!='khongthemxoa') { ?>
    <div class="card-footer text-sm">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
    </div>
    <?php } ?>
</section>