<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = "Chỉnh sửa";
else if ($act == "copy")  $labelAct = "Sao chép";

$linkMan = "index.php?com=news&act=man&type=" . $type;
if ($act == 'add') $linkFilter = "index.php?com=news&act=add&type=" . $type;
else if ($act == 'edit') $linkFilter = "index.php?com=news&act=edit&type=" . $type . "&id=" . $id;
if ($act == "copy") $linkSave = "index.php?com=news&act=save_copy&type=" . $type;
else $linkSave = "index.php?com=news&act=save&type=" . $type;

$options = (isset($item['options']) && $item['options'] != '') ? json_decode($item['options'],true) : null;
$options2 = (isset($item['options2']) && $item['options2'] != '') ? json_decode($item['options2'],true) : null;
/* Check cols */
if (isset($config['news'][$type]['gallery']) && count($config['news'][$type]['gallery']) > 0) {
    foreach ($config['news'][$type]['gallery'] as $key => $value) {
        if ($key == $type) {
            $keyGallery = $key;
            $flagGallery = true;
            break;
        }
    }
}

if (
    (isset($config['news'][$type]['dropdown']) && $config['news'][$type]['dropdown'] == true) &&
    (isset($config['news'][$type]['list']) && $config['news'][$type]['list'] == true) ||
    (isset($config['news'][$type]['cat']) && $config['news'][$type]['cat'] == true) ||
    (isset($config['news'][$type]['item']) && $config['news'][$type]['item'] == true) ||
    (isset($config['news'][$type]['sub']) && $config['news'][$type]['sub'] == true) ||
    (isset($config['news'][$type]['other']) && $config['news'][$type]['other'] == true) ||
    (isset($config['news'][$type]['tags']) && $config['news'][$type]['tags'] == true) ||
    (isset($config['news'][$type]['images']) && $config['news'][$type]['images'] == true)
) {
    $colLeft = "col-xl-8";
    $colRight = "col-xl-4";
} else {
    $colLeft = "col-12";
    $colRight = "d-none";
}
if(isset($config['news'][$type]['readonly']) && $config['news'][$type]['readonly'] == true) $readonly = 'readonly';
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?> <?= $config['news'][$type]['title_main'] ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i>Lưu tại trang</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="row">
            <div class="<?= $colLeft ?>">
                <?php
                if (isset($config['news'][$type]['slug']) && $config['news'][$type]['slug'] == true) {
                    $slugchange = ($act == 'edit') ? 1 : 0;
                    $copy = ($act != 'copy') ? 0 : 1;
                    include TEMPLATE . LAYOUT . "slug.php";
                }
                ?>
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung <?= $config['news'][$type]['title_main'] ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                                    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang" data-toggle="pill" href="#tabs-lang-<?= $k ?>" role="tab" aria-controls="tabs-lang-<?= $k ?>" aria-selected="true"><?= $v ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="card-body card-article">
                                <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                        <div class="tab-pane fade show <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang-<?= $k ?>" role="tabpanel" aria-labelledby="tabs-lang">
                                            <div class="form-group">
                                                <label for="name<?= $k ?>">Tiêu đề (<?= $k ?>):</label>
                                                <input type="text" class="form-control for-seo text-sm" name="data[name<?= $k ?>]" id="name<?= $k ?>" placeholder="Tiêu đề (<?= $k ?>)" value="<?= (!empty($flash->has('name' . $k))) ? $flash->get('name' . $k) : @$item['name' . $k] ?>" data-seo="title" required <?=$readonly?>>
                                            </div>
                                            <?php if (isset($config['news'][$type]['desc']) && $config['news'][$type]['desc'] == true) { ?>
                                                <div class="form-group">
                                                    <label for="desc<?= $k ?>">Mô tả (<?= $k ?>):</label>
                                                    <textarea class="form-control for-seo text-sm <?= (isset($config['news'][$type]['desc_cke']) && $config['news'][$type]['desc_cke'] == true) ? 'form-control-ckeditor' : '' ?>" name="data[desc<?= $k ?>]" id="desc<?= $k ?>" rows="5" placeholder="Mô tả (<?= $k ?>)" data-seo="description"><?= $func->decodeHtmlChars($flash->get('desc' . $k)) ?: $func->decodeHtmlChars(@$item['desc' . $k]) ?></textarea>
                                                </div>
                                            <?php } ?>
                                            <?php if (isset($config['news'][$type]['content']) && $config['news'][$type]['content'] == true) { ?>
                                                <div class="form-group">
                                                    <label for="content<?= $k ?>">Nội dung (<?= $k ?>):</label>
                                                    <textarea class="form-control for-seo text-sm <?= (isset($config['news'][$type]['content_cke']) && $config['news'][$type]['content_cke'] == true) ? 'form-control-ckeditor' : '' ?>" name="data[content<?= $k ?>]" id="content<?= $k ?>" rows="5" placeholder="Nội dung (<?= $k ?>)" data-seo="content"><?= $func->decodeHtmlChars($flash->get('content' . $k)) ?: $func->decodeHtmlChars(@$item['content' . $k]) ?></textarea>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="<?= $colRight ?>">
                <?php if (
                    (isset($config['news'][$type]['dropdown']) && $config['news'][$type]['dropdown'] == true) &&
                    ((isset($config['news'][$type]['list']) && $config['news'][$type]['list'] == true) ||
                    (isset($config['news'][$type]['cat']) && $config['news'][$type]['cat'] == true) ||
                    (isset($config['news'][$type]['item']) && $config['news'][$type]['item'] == true) ||
                    (isset($config['news'][$type]['sub']) && $config['news'][$type]['sub'] == true) ||
                    (isset($config['news'][$type]['tags']) && $config['news'][$type]['tags'] == true))
                ) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Danh mục <?= $config['news'][$type]['title_main'] ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group-category row">
                                <?php if (
                                    (isset($config['news'][$type]['dropdown']) && $config['news'][$type]['dropdown'] == true) &&
                                    ((isset($config['news'][$type]['list']) && $config['news'][$type]['list'] == true) ||
                                    (isset($config['news'][$type]['cat']) && $config['news'][$type]['cat'] == true) ||
                                    (isset($config['news'][$type]['item']) && $config['news'][$type]['item'] == true) ||
                                    (isset($config['news'][$type]['sub']) && $config['news'][$type]['sub'] == true) ||
                                    (isset($config['news'][$type]['tags']) && $config['news'][$type]['tags'] == true))
                                ) { ?>
                                    <?php if (isset($config['news'][$type]['list']) && $config['news'][$type]['list'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_list">Danh mục cấp 1:</label>
                                            <?= $func->getAjaxCategory('news', 'list', $type) ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($config['news'][$type]['cat']) && $config['news'][$type]['cat'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_cat">Danh mục cấp 2:</label>
                                            <?= $func->getAjaxCategory('news', 'cat', $type) ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($config['news'][$type]['item']) && $config['news'][$type]['item'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_item">Danh mục cấp 3:</label>
                                            <?= $func->getAjaxCategory('news', 'item', $type) ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($config['news'][$type]['sub']) && $config['news'][$type]['sub'] == true) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_sub">Danh mục cấp 4:</label>
                                            <?= $func->getAjaxCategory('news', 'sub', $type) ?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (isset($config['news'][$type]['tags']) && $config['news'][$type]['tags'] == true) { ?>
                                    <div class="form-group col-xl-6 col-sm-4">
                                        <label class="d-block" for="id_tags">Danh mục tags:</label>
                                        <?= $func->getTags(@$item['id'], 'dataTags', 'news_tags', $type) ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($config['news'][$type]['images']) && $config['news'][$type]['images'] == true) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh <?= $config['news'][$type]['title_main'] ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            /* Photo detail */
                            $photoDetail = array();
                            $photoDetail['upload'] = UPLOAD_NEWS_L;
                            $photoDetail['image'] = (!empty($item) && $act != 'copy') ? $item['photo'] : '';
                            $photoDetail['dimension'] = "Width: " . $config['news'][$type]['width'] . " px - Height: " . $config['news'][$type]['height'] . " px (" . $config['news'][$type]['img_type'] . ")";

                            /* Image */
                            include TEMPLATE . LAYOUT . "image.php";
                            ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if(isset($config['news'][$type]['images2']) && $config['news'][$type]['images2'] == true) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh <?=$config['news'][$type]['title_main']?> 2</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                                $photoDetail2 = ($act != 'copy') ? UPLOAD_NEWS.@$item['photo2'] : '';
                                $dimension2 = "Width: ".$config['news'][$type]['width2']." px - Height: ".$config['news'][$type]['height2']." px (".$config['news'][$type]['img_type'].")";
                                include TEMPLATE.LAYOUT."image2.php";
                            ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if(isset($config['news'][$type]['file_attach']) && $config['news'][$type]['file_attach'] == true) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">File <?=$config['news'][$type]['title_main']?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                                $tailieuDetail = ($act != 'copy') ? UPLOAD_FILE.@$item['file_attach'] : '';
                                $dimensiontailieu = "Upload có đuôi file: ". $config['news'][$type]['file_type'] ;
                                include TEMPLATE.LAYOUT."file.php";
                            ?>
                        </div>
                    </div>
                <?php } ?>

                <!-- Video MP4 -->
                <?php if (isset($config['news'][$type]['videomp4']) && $config['news'][$type]['videomp4'] == true) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Video <?= $config['news'][$type]['title_main'] ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">                            
                            <?php
                            /* Video MP4 detail */
                            $photoDetail = array();
                            $photoDetail['upload'] = '../' . UPLOAD_VIDEO_L;
                            $photoDetail['video'] = (!empty($item)) ? $item['videomp4'] : '';
                            $photoDetail['dimension'] = "(" . $config['news'][$type]['videomp4_type'] . ")";
                            /* Video MP4 */
                            include TEMPLATE . LAYOUT . "videomp4.php";
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin <?= $config['news'][$type]['title_main'] ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <?php $status_array = (!empty($item['status'])) ? explode(',', $item['status']) : array(); ?>
                    <?php if($_GET['act']=='add'){?>
                        <?php if (isset($config['news'][$type]['check'])) {
                            foreach ($config['news'][$type]['check'] as $key => $value) { ?>
                                <div class="form-group d-inline-block mb-2 mr-2">
                                    <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle">
                                        <input type="checkbox" class="custom-control-input <?= $key ?>-checkbox" name="status[<?= $key ?>]" id="<?= $key ?>-checkbox" <?=($key=='hienthi') ? 'checked' : ''?> value="<?= $key ?>">
                                        <label for="<?= $key ?>-checkbox" class="custom-control-label"></label>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    <?php }else{ ?>
                        <?php if (isset($config['news'][$type]['check'])) {
                            foreach ($config['news'][$type]['check'] as $key => $value) { ?>
                                <div class="form-group d-inline-block mb-2 mr-2">
                                    <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle">
                                        <input type="checkbox" class="custom-control-input <?= $key ?>-checkbox" name="status[<?= $key ?>]" id="<?= $key ?>-checkbox" <?= (empty($status_array) && empty($item['id']) ? 'checked' : in_array($key, $status_array)) ? 'checked' : '' ?> value="<?= $key ?>">
                                        <label for="<?= $key ?>-checkbox" class="custom-control-label"></label>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="numb" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>" <?=$readonly?>>
                </div>
                <?php if(isset($config['news'][$type]['dienthoai']) && $config['news'][$type]['dienthoai'] == true) { ?>
                    <div class="form-group col-md-4 col-sm-6">
                        <label for="dienthoai">Điện thoại:</label>
                        <input type="text" class="form-control" name="data[options2][dienthoai]" id="dienthoai" placeholder="Điện thoại" value="<?=$options2['dienthoai']?>">
                    </div>
                <?php } ?>
                <?php if(isset($config['news'][$type]['email']) && $config['news'][$type]['email'] == true) { ?>
                    <div class="form-group col-md-4 col-sm-6">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" name="data[options2][email]" id="email" placeholder="Email" value="<?=$options2['email']?>">
                    </div>
                <?php } ?>
                <?php if(isset($config['news'][$type]['website']) && $config['news'][$type]['website'] == true) { ?>
                    <div class="form-group col-md-4 col-sm-6">
                        <label for="website">Website:</label>
                        <input type="text" class="form-control" name="data[options2][website]" id="website" placeholder="Website" value="<?=$options2['website']?>">
                    </div>
                <?php } ?>
                <?php if(isset($config['news'][$type]['facebook']) && $config['news'][$type]['facebook'] == true) { ?>
                    <div class="form-group col-md-4 col-sm-6">
                        <label for="facebook">Facebook:</label>
                        <input type="text" class="form-control" name="data[options2][facebook]" id="facebook" placeholder="Facebook" value="<?=$options2['facebook']?>">
                    </div>
                <?php } ?>
                <?php if(isset($config['news'][$type]['zalo']) && $config['news'][$type]['zalo'] == true) { ?>
                    <div class="form-group col-md-4 col-sm-6">
                        <label for="zalo">Zalo:</label>
                        <input type="text" class="form-control" name="data[options2][zalo]" id="zalo" placeholder="Zalo" value="<?=$options2['zalo']?>">
                    </div>
                <?php } ?>
                <?php if(isset($config['news'][$type]['skype']) && $config['news'][$type]['skype'] == true) { ?>
                    <div class="form-group col-md-4 col-sm-6">
                        <label for="skype">Skype:</label>
                        <input type="text" class="form-control" name="data[options2][skype]" id="skype" placeholder="Skype" value="<?=$options2['skype']?>">
                    </div>
                <?php } ?>
                <?php if(isset($config['news'][$type]['chucvu']) && $config['news'][$type]['chucvu'] == true) { ?>
                    <div class="form-group col-md-4 col-sm-6">
                        <label for="chucvu">Chức vụ:</label>
                        <input type="text" class="form-control" name="data[options2][chucvu]" id="chucvu" placeholder="Chức vụ" value="<?=$options2['chucvu']?>">
                    </div>
                <?php } ?>
                <?php if(isset($config['news'][$type]['bando']) && $config['news'][$type]['bando'] == true) { ?>
                    <div class="form-group col-md-4 col-sm-6">
                        <label for="bando">Bản đồ:</label>                        
                        <textarea class="form-control for-seo" name="data[options2][bando]" id="bando" rows="5" placeholder="Bản đồ"><?=htmlspecialchars_decode(@$options2['bando'])?></textarea>
                    </div>
                <?php } ?>
                <?php if(isset($config['news'][$type]['diachi']) && $config['news'][$type]['diachi'] == true) { ?>
                    <div class="form-group col-md-4 col-sm-6">
                        <label for="diachi">Địa chỉ:</label>                        
                        <textarea class="form-control for-seo" name="data[options2][diachi]" id="diachi" rows="5" placeholder="Địa chỉ"><?=htmlspecialchars_decode(@$options2['diachi'])?></textarea>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php if (isset($flagGallery) && $flagGallery == true) { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Bộ sưu tập <?= $config['news'][$type]['title_main'] ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="filer-gallery" class="label-filer-gallery mb-3">Album hình: (<?= $config['news'][$type]['gallery'][$keyGallery]['img_type_photo'] ?>)</label>
                        <input type="file" name="files[]" id="filer-gallery" multiple="multiple">
                        <input type="hidden" class="col-filer" value="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
                        <input type="hidden" class="act-filer" value="man">
                        <input type="hidden" class="folder-filer" value="news">
                    </div>
                    <?php if (isset($gallery) && count($gallery) > 0) { ?>
                        <div class="form-group form-group-gallery">
                            <label class="label-filer">Album hiện tại:</label>
                            <div class="action-filer mb-3">
                                <a class="btn btn-sm bg-gradient-primary text-white check-all-filer mr-1"><i class="far fa-square mr-2"></i>Chọn tất cả</a>
                                <button type="button" class="btn btn-sm bg-gradient-success text-white sort-filer mr-1"><i class="fas fa-random mr-2"></i>Sắp xếp</button>
                                <a class="btn btn-sm bg-gradient-danger text-white delete-all-filer"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
                            </div>
                            <div class="alert my-alert alert-sort-filer alert-info text-sm text-white bg-gradient-info"><i class="fas fa-info-circle mr-2"></i>Có thể chọn nhiều hình để di chuyển</div>
                            <div class="jFiler-items my-jFiler-items jFiler-row">
                                <ul class="jFiler-items-list jFiler-items-grid row scroll-bar" id="jFilerSortable">
                                    <?php foreach ($gallery as $v) echo $func->galleryFiler($v['numb'], $v['id'], $v['photo'], $v['namevi'], 'news', 'col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6'); ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($config['news'][$type]['seo']) && $config['news'][$type]['seo'] == true) { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Nội dung SEO</h3>
                    <a class="btn btn-sm bg-gradient-success d-inline-block text-white float-right create-seo" title="Tạo SEO">Tạo SEO</a>
                </div>
                <div class="card-body">
                    <?php
                    $seoDB = $seo->getOnDB($id, $com, 'man', $type);
                    include TEMPLATE . LAYOUT . "seo.php";
                    ?>
                    <?php /*
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <?php include_once TEMPLATE."check_seo_tpl.php"; ?>
                    </div>
                    */ ?>                   
                </div>
            </div>
        <?php } ?>
        <?php if (isset($config['news'][$type]['schema']) && $config['news'][$type]['schema'] == true) { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Schema JSON Article</h3>
                    <button type="submit" class="btn btn-sm bg-gradient-success float-right submit-check" name="build-schema" value="1"><i class="far fa-save mr-2"></i>Lưu và tạo tự động Schema</button>
                </div>
                <div class="card-body">
                    <?php
                    $seoDB = $seo->getOnDB($id, $com, 'man', $type);
                    include TEMPLATE . LAYOUT . "schema.php";
                    ?>
                    <input type="hidden" id="schema-type" value="news">
                </div>
            </div>
        <?php } ?>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i>Lưu tại trang</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>