<?php
$linkMan = "index.php?com=newsletter&act=man&type=" . $type;
$linkAdd = "index.php?com=newsletter&act=add&type=" . $type;
$linkEdit = "index.php?com=newsletter&act=edit&type=" . $type;
$linkDelete = "index.php?com=newsletter&act=delete&type=" . $type;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý nhận tin</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <?php if (isset($config['newsletter'][$type]['is_send']) && $config['newsletter'][$type]['is_send'] == true) { ?>
            <a class="btn btn-sm bg-gradient-success text-white" id="send-email" title="Gửi email"><i class="fas fa-paper-plane mr-2"></i>Gửi email</a>
        <?php } ?>
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
            <h3 class="card-title">Danh sách <?= $config['newsletter'][$type]['title_main'] ?></h3>
            <?php if (isset($config['newsletter'][$type]['is_send']) && $config['newsletter'][$type]['is_send'] == true) { ?>
                <p class="d-block text-secondary w-100 float-left mb-0 mt-1">Chọn email sau đó kéo xuống dưới cùng danh sách này để có thể thiết lập nội dung email muốn gửi đi.</p>
            <?php } ?>
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
                        <?php if (isset($config['newsletter'][$type]['show_name']) && $config['newsletter'][$type]['show_name'] == true) { ?>
                            <th class="align-middle">Họ tên</th>
                        <?php } ?>
                        <?php if (isset($config['newsletter'][$type]['email']) && $config['newsletter'][$type]['email'] == true) { ?>
                            <th class="align-middle">Email</th>
                        <?php } ?>
                        <?php if (isset($config['newsletter'][$type]['show_phone']) && $config['newsletter'][$type]['show_phone'] == true) { ?>
                            <th class="align-middle">Điện thoại</th>
                        <?php } ?>
                        <?php if (isset($config['newsletter'][$type]['file']) && $config['newsletter'][$type]['file'] == true) { ?>
                            <th class="align-middle">Download</th>
                        <?php } ?>
                        <?php if (isset($config['newsletter'][$type]['show_date']) && $config['newsletter'][$type]['show_date'] == true) { ?>
                            <th class="align-middle">Gửi từ ngày</th>
                        <?php } ?>
                        <?php if (isset($config['newsletter'][$type]['confirm_status']) && count($config['newsletter'][$type]['confirm_status']) > 0) { ?>
                            <th class="align-middle">Tình trạng</th>
                        <?php } ?>
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
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="newsletter">
                                </td>
                                <?php if (isset($config['newsletter'][$type]['show_name']) && $config['newsletter'][$type]['show_name'] == true) { ?>
                                    <td class="align-middle">
                                        <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['fullname'] ?>"><?= $items[$i]['fullname'] ?></a>
                                    </td>
                                <?php } ?>
                                <?php if (isset($config['newsletter'][$type]['email']) && $config['newsletter'][$type]['email'] == true) { ?>
                                    <td class="align-middle">
                                        <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['email'] ?>"><?= $items[$i]['email'] ?></a>
                                    </td>
                                <?php } ?>
                                <?php if (isset($config['newsletter'][$type]['show_phone']) && $config['newsletter'][$type]['show_phone'] == true) { ?>
                                    <td class="align-middle"><?= $items[$i]['phone'] ?></td>
                                <?php } ?>
                                <?php if (isset($config['newsletter'][$type]['file']) && $config['newsletter'][$type]['file'] == true) { ?>
                                    <td class="align-middle">
                                        <?php if (isset($items[$i]['file_attach']) && ($items[$i]['file_attach'] != '')) { ?>
                                            <a class="btn btn-sm bg-gradient-primary text-white d-inline-block p-1 rounded" href="<?= UPLOAD_FILE . $items[$i]['file_attach'] ?>" title="Download tập tin"><i class="fas fa-download mr-2"></i>Download tập tin</a>
                                        <?php } else { ?>
                                            <a class="bg-gradient-secondary text-white d-inline-block p-1 rounded" href="#" title="Tập tin trống"><i class="fas fa-download mr-2"></i>Tập tin trống</a>
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                                <?php if (isset($config['newsletter'][$type]['show_date']) && $config['newsletter'][$type]['show_date'] == true) { ?>
                                    <td class="align-middle"><?= date("h:i:s A - d/m/Y", $items[$i]['date_created']) ?></td>
                                <?php } ?>
                                <?php if (isset($config['newsletter'][$type]['confirm_status']) && count($config['newsletter'][$type]['confirm_status']) > 0) { ?>
                                    <td class="align-middle"><?= $func->getStatusNewsletter($items[$i]['confirm_status'], $type) ?></td>
                                <?php } ?>
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
        <div class="card-footer text-sm">
            <?= $paging ?>
        </div>
    <?php } ?>
    <?php if (isset($config['newsletter'][$type]['is_send']) && $config['newsletter'][$type]['is_send'] == true) { ?>
        <div class="card card-primary card-outline text-sm mb-0 <?= (!$paging) ? 'mt-3' : ''; ?>">
            <form name="frmsendemail" method="post" action="<?= $linkMan ?>" enctype="multipart/form-data">
                <div class="card-header">
                    <h3 class="card-title">Gửi email đến danh sách được chọn</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="subject">Tiêu đề:</label>
                        <input type="text" class="form-control text-sm" name="subject" id="subject" placeholder="Tiêu đề">
                    </div>
                    <div class="form-group">
                        <label class="d-inline-block align-middle mb-1 mr-2">Upload tập tin:</label>
                        <strong class="d-block mt-2 mb-2 text-sm"><?php echo $config['newsletter'][$type]['file_type'] ?></strong>
                        <div class="custom-file my-custom-file">
                            <input type="file" class="custom-file-input" name="file" id="file">
                            <label class="custom-file-label" for="file">Chọn file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung thông tin:</label>
                        <textarea class="form-control form-control-ckeditor" name="content" id="content" rows="5" placeholder="Nội dung thông tin"></textarea>
                    </div>
                    <input type="hidden" name="listemail" id="listemail">
                </div>
            </form>
        </div>
    <?php } ?>
    <div class="card-footer text-sm">
        <?php if (isset($config['newsletter'][$type]['is_send']) && $config['newsletter'][$type]['is_send'] == true) { ?>
            <a class="btn btn-sm bg-gradient-success text-white" id="send-email" title="Gửi email"><i class="fas fa-paper-plane mr-2"></i>Gửi email</a>
        <?php } ?>
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
    </div>
</section>