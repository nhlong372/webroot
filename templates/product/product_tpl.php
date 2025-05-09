<div class="template-pro">
<div class="row">
    <?php if(SEARCHPRODUCT==true){?>
    <div class="col-12 col-lg-3">
        <?php
            $brand_fitler = $d->rawQuery("select name$lang, id from table_product_brand where type = ? and find_in_set('hienthi', status) order by numb, id desc",array('san-pham'));
            $size_fitler = $d->rawQuery("select name$lang, id from table_size where type = ? and find_in_set('hienthi', status) order by numb, id desc",array('san-pham'));
            $color_filter = $d->rawQuery("select name$lang, color, id from table_color where type = ? and find_in_set('hienthi', status) order by numb, id desc",array('san-pham'));
            if(isset($_REQUEST['brand']) and $_REQUEST['brand']!='') {
                $brand_f = explode(',', $_REQUEST['brand']);
            }
            if(isset($_REQUEST['size']) and $_REQUEST['size']!='') {
                $size_f = explode(',', $_REQUEST['size']);
            }
            if(isset($_REQUEST['color']) and $_REQUEST['color']!='') {
                $color_f = explode(',', $_REQUEST['color']);
            }
        ?>
        <div class="filter_block">
            <div class="filter_title">Danh mục sản phẩm</div>
            <div id="danhmuc">
            <?=$func->formenu_left('product','san-pham');?>
            </div>
        </div>
        
        <div class="filter_block">
            <div class="filter_title">Sắp xếp theo</div>
            <ul id="filter_sort_choose" class="list-unstyled p-0 m-0">
                <li class="list-unstyled">
                    <a class="<?php if($_REQUEST['filter_active']==1 and $_REQUEST['sort']=='price_asc') echo 'checked' ?>" data-id="price_asc">
                        <span></span>Giá thấp đến cao
                    </a>
                </li>
                <li class="list-unstyled">
                    <a class="<?php if($_REQUEST['filter_active']==1 and $_REQUEST['sort']=='price_desc') echo 'checked' ?>" data-id="price_desc">
                        <span></span>Giá cao đến thấp
                    </a>
                </li>
                <li class="list-unstyled">
                    <a class="<?php if($_REQUEST['filter_active']==1 and $_REQUEST['sort']=='ngaytao_desc') echo 'checked' ?>" data-id="ngaytao_desc">
                        <span></span>Mới nhất
                    </a>
                </li>
            </ul>
        </div>
        <div class="filter_block">
            <div class="filter_title">Thương hiệu</div>
            <ul id="filter_os_choose" class="list-unstyled p-0 m-0">
                <?php foreach ($brand_fitler as $key => $value) { ?>
                <li class="list-unstyled">
                    <a class="<?php if($_REQUEST['filter_active']==1 and in_array($value['id'], $brand_f)) echo 'checked' ?>" data-id="<?=$value['id']?>">
                        <span></span><?=$value['name'.$lang]?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="filter_block">
            <div class="filter_title">Kích cỡ</div>
            <ul id="filter_size_choose" class="list-unstyled p-0 m-0">
                <?php foreach ($size_fitler as $key => $value) { ?>
                <li class="list-unstyled">
                    <a class="<?php if($_REQUEST['filter_active']==1 and in_array($value['id'], $size_f)) echo 'checked' ?>" data-id="<?=$value['id']?>">
                        <span></span><?=$value['name'.$lang]?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="filter_block">
            <div class="filter_title">Màu sắc</div>
            <ul id="filter_color_choose" class="list-unstyled p-0 m-0">
                <?php foreach ($color_filter as $key => $value) { ?>
                <li class="list-unstyled">
                    <a class="<?php if($_REQUEST['filter_active']==1 and in_array($value['id'], $color_f)) echo 'checked' ?>" data-id="<?=$value['id']?>">
                        <span></span><?=$value['name'.$lang]?>
                        <?php if($value['color']!='') { ?><i style="background-color: #<?=$value['color']?> !important;"></i><?php } ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php } ?>
    <?php /*include TEMPLATE . LAYOUT . "left.php";*/ ?>
    <div class="col-12 <?=(SEARCHPRODUCT==true)?'col-lg-9':'col-lg-12';?> ">
        <div class="title-main"><span><?= (!empty($titleCate)) ? $titleCate : @$titleMain ?></span></div>
        <div class="content-main w-clear">
            <?php if (!empty($product)) {
                echo $func->GetProducts($product, 'boxProduct',true,'270x270x2');
            } else { ?>
                <div class="col-12">
                    <div class="alert alert-warning w-100" role="alert">
                        <strong><?= khongtimthayketqua ?></strong>
                    </div>
                </div>
            <?php } ?>
            <div class="clear"></div>
            <div class="col-12">
                <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
            </div>
        </div>
    </div>
</div>
</div>