<?php
$linkMan = "index.php?com=news&act=man_list&type=" . $type;
$linkAdd = "index.php?com=news&act=add_list&type=" . $type;
$linkEdit = "index.php?com=news&act=edit_list&type=" . $type;
$linkDelete = "index.php?com=news&act=delete_list&type=" . $type;
$linkMulti = "index.php?com=news&act=man_photo&kind=man_list&type=" . $type;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý <?= $config['news'][$type]['title_main_list'] ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
        <div class="form-inline form-search d-inline-block align-middle ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="Tìm kiếm" aria-label="Tìm kiếm" value="<?= (isset($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" onkeypress="doEnter(event,'keyword','<?= $linkMan ?>')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','<?= $linkMan ?>')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title">Danh sách <?= $config['news'][$type]['title_main_list'] ?></h3>
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
                        <?php if (isset($config['news'][$type]['show_images_list']) && $config['news'][$type]['show_images_list'] == true) { ?>
                            <th class="align-middle">Hình</th>
                        <?php } ?>
                        <th class="align-middle" style="width:30%">Tiêu đề</th>
                        <?php if (isset($config['news'][$type]['gallery_list']) && count($config['news'][$type]['gallery_list']) > 0) { ?>
                            <th class="align-middle">Gallery</th>
                        <?php } ?>
                        <?php if (isset($config['news'][$type]['check_list'])) {
                            foreach ($config['news'][$type]['check_list'] as $key => $value) { ?>
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
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="news_list">
                                </td>
                                <?php if (isset($config['news'][$type]['show_images_list']) && $config['news'][$type]['show_images_list'] == true) { ?>
                                    <td class="align-middle">
                                        <a href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>">
                                            <?= $func->getImage(['class' => 'rounded img-preview', 'sizes' => $config['news'][$type]['thumb_list'], 'upload' => UPLOAD_NEWS_L, 'image' => $items[$i]['photo'], 'alt' => $items[$i]['namevi']]) ?>
                                        </a>
                                    </td>
                                <?php } ?>
                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><?= $items[$i]['namevi'] ?></a>
                                </td>
                                <?php if (isset($config['news'][$type]['gallery_list']) && count($config['news'][$type]['gallery_list']) > 0) { ?>
                                    <td class="align-middle">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm bg-gradient-success dropdown-toggle" id="dropdown-gallery" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Thêm</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdown-gallery">
                                                <?php foreach ($config['news'][$type]['gallery_list'] as $key => $value) { ?>
                                                    <a class="dropdown-item text-dark" href="<?= $linkMulti ?>&id_parent=<?= $items[$i]['id'] ?>&val=<?= $key ?>" title="<?= $value['title_sub_photo'] ?>"><i class="far fa-caret-square-right text-secondary mr-2"></i><?= $value['title_sub_photo'] ?></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php } ?>
                                <?php $status_array = (!empty($items[$i]['status'])) ? explode(',', $items[$i]['status']) : array(); ?>
                                <?php if (isset($config['news'][$type]['check_list'])) {
                                    foreach ($config['news'][$type]['check_list'] as $key => $value) { ?>
                                        <td class="align-middle text-center">
                                            <div class="custom-control custom-checkbox my-checkbox">
                                                <input type="checkbox" class="custom-control-input show-checkbox" id="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" data-table="news_list" data-id="<?= $items[$i]['id'] ?>" data-attr="<?= $key ?>" <?= (in_array($key, $status_array)) ? 'checked' : '' ?>>
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
    </div>
</section>