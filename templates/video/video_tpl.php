<div class="title-main"><span><?= @$titleMain ?></span></div>
<div class="content-main">
    <div class="css_flex_video">
    <?php if (!empty($video)) {
        echo $func->lay_video2($video,'600x405x1');
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