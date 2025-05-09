<?php
$linkParent = "index.php?com=" . $com . "&act=" . $kind . "&type=" . $type;
$linkMan = "index.php?com=" . $com . "&act=man_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val;
$linkAdd = "index.php?com=" . $com . "&act=add_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val;
$linkEdit = "index.php?com=" . $com . "&act=edit_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val;
$linkDelete = "index.php?com=" . $com . "&act=delete_photo&id_parent=" . $id_parent . "&type=" . $type . "&kind=" . $kind . "&val=" . $val;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý <?= $config[$com][$type][$dfgallery][$val]['title_main_photo'] ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
        <a class="btn btn-sm bg-gradient-secondary" href="<?= $linkParent ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
    </div>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title">Danh sách <?= $config[$com][$type][$dfgallery][$val]['title_main_photo'] ?></h3>
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
                        <?php if (isset($config[$com][$type][$dfgallery][$val]['avatar_photo']) && $config[$com][$type][$dfgallery][$val]['avatar_photo'] == true) { ?>
                            <th class="align-middle text-center" width="8%">Hình</th>
                        <?php } ?>
                        <?php if (isset($config[$com][$type][$dfgallery][$val]['name_photo']) && $config[$com][$type][$dfgallery][$val]['name_photo'] == true) { ?>
                            <th class="align-middle" style="width:30%">Tiêu đề</th>
                        <?php } ?>
                        <?php if (isset($config[$com][$type][$dfgallery][$val]['cart_photo']) && $config[$com][$type][$dfgallery][$val]['cart_photo'] == true) { ?>
                            <th class="align-middle">Màu sắc (Giỏ hàng)</th>
                        <?php } ?>
                        <?php if (isset($config[$com][$type][$dfgallery][$val]['file_photo']) && $config[$com][$type][$dfgallery][$val]['file_photo'] == true) { ?>
                            <th class="align-middle">Tập tin</th>
                        <?php } ?>
                        <?php if (isset($config[$com][$type][$dfgallery][$val]['video_photo']) && $config[$com][$type][$dfgallery][$val]['video_photo'] == true) { ?>
                            <th class="align-middle">Video</th>
                        <?php } ?>
                        <?php if (isset($config[$com][$type][$dfgallery][$val]['check_photo'])) {
                            foreach ($config[$com][$type][$dfgallery][$val]['check_photo'] as $key => $value) { ?>
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
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="gallery">
                                </td>
                                <?php if (isset($config[$com][$type][$dfgallery][$val]['avatar_photo']) && $config[$com][$type][$dfgallery][$val]['avatar_photo'] == true) { ?>
                                    <td class="align-middle text-center">
                                        <a href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>">
                                            <?= $func->getImage(['class' => 'rounded img-preview', 'sizes' => $config[$com][$type][$dfgallery][$val]['thumb_photo'], 'upload' => 'upload/' . $com . '/', 'image' => $items[$i]['photo'], 'alt' => $items[$i]['namevi']]) ?>
                                        </a>
                                    </td>
                                <?php } ?>
                                <?php if (isset($config[$com][$type][$dfgallery][$val]['name_photo']) && $config[$com][$type][$dfgallery][$val]['name_photo'] == true) { ?>
                                    <td class="align-middle">
                                        <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><?= $items[$i]['namevi'] ?></a>
                                    </td>
                                <?php } ?>
                                <?php if (isset($config[$com][$type][$dfgallery][$val]['cart_photo']) && $config[$com][$type][$dfgallery][$val]['cart_photo'] == true) { ?>
                                    <td class="align-middle">
                                        <?php $color_detail = $func->getInfoDetail('color, type_show, photo, namevi', 'color', $items[$i]['id_color']); ?>
                                        <?php if (isset($color_detail['type_show']) && $color_detail['type_show'] == 0) { ?>
                                            <span class="color-preview rounded" style="background-color:#<?= $color_detail['color'] ?>"></span>
                                        <?php } else { ?>
                                            <?= $func->getImage(['class' => 'rounded img-preview', 'sizes' => '55x55x1', 'upload' => UPLOAD_COLOR_L, 'image' => (!empty($color_detail['photo'])) ? $color_detail['photo'] : '', 'alt' => (!empty($color_detail['namevi'])) ? $color_detail['namevi'] : '']) ?>
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                                <?php if (isset($config[$com][$type][$dfgallery][$val]['file_photo']) && $config[$com][$type][$dfgallery][$val]['file_photo'] == true) { ?>
                                    <td class="align-middle">
                                        <?php if (isset($items[$i]['file_attach']) && ($items[$i]['file_attach'] != '')) { ?>
                                            <a class="btn btn-sm bg-gradient-primary text-white d-inline-block p-1 rounded" href="<?= UPLOAD_FILE . $items[$i]['file_attach'] ?>" title="Download tập tin"><i class="fas fa-download mr-2"></i>Download tập tin</a>
                                        <?php } else { ?>
                                            <a class="bg-gradient-secondary text-white d-inline-block p-1 rounded" href="#" title="Tập tin trống"><i class="fas fa-download mr-2"></i>Tập tin trống</a>
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                                <?php if (isset($config[$com][$type][$dfgallery][$val]['video_photo']) && $config[$com][$type][$dfgallery][$val]['video_photo'] == true) { ?>
                                    <td class="align-middle"><?= $items[$i]['link_video'] ?></td>
                                <?php } ?>
                                <?php $status_array = (!empty($items[$i]['status'])) ? explode(',', $items[$i]['status']) : array(); ?>
                                <?php if (isset($config[$com][$type][$dfgallery][$val]['check_photo'])) {
                                    foreach ($config[$com][$type][$dfgallery][$val]['check_photo'] as $key => $value) { ?>
                                        <td class="align-middle text-center">
                                            <div class="custom-control custom-checkbox my-checkbox">
                                                <input type="checkbox" class="custom-control-input show-checkbox" id="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" data-table="gallery" data-id="<?= $items[$i]['id'] ?>" data-attr="<?= $key ?>" <?= (in_array($key, $status_array)) ? 'checked' : '' ?>>
                                                <label for="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                            </div>
                                        </td>
                                <?php }
                                } ?>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-primary mr-2" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                    <a class="text-danger" id="delete-item" data-url="<?= $linkDelete ?>&id=<?= $items[$i]['id'] ?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
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
    <div class="card-footer text-sm">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
        <a class="btn btn-sm bg-gradient-secondary" href="<?= $linkParent ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
    </div>
</section>