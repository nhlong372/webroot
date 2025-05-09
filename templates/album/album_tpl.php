<div class="title-main"><span><?= $titleMain ?></span></div>
<div class="content-main">
    <div class="css_flex_album">
    <?php if (!empty($product)) {
        echo $func->lay_thuvien($product,0,'480x360x1'); //1:click hình zoom tại trang, 0: vào chi tiết
    } else { ?>
        <div class="col-12">
            <div class="alert alert-warning w-100" role="alert">
                <strong><?= khongtimthayketqua ?></strong>
            </div>
        </div>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <div class="col-12">
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    </div>
</div>