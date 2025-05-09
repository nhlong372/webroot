<?php if (!empty($static)) { ?>
    <div class="title-main"><span><?= $static['name' . $lang] ?></span></div>
    <?php /*
    <div class="meta-toc">
        <div class="box-readmore">
            <ul class="toc-list" data-toc="article" data-toc-headings="h1, h2, h3"></ul>
        </div>
    </div>
    */ ?>
    <div class="content-main autoHeight w-clear" id="toc-content"><?=$func->decodeHtmlChars($static['content'.$lang])?></div>    
    <div class="share">
        <b><?= chiase ?>:</b>
        <div class="social-plugin w-clear">
            <?php
            $params = array();
            $params['oaid'] = $optsetting['oaidzalo'];
            echo $func->markdown('social/share', $params);
            ?>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-warning w-100" role="alert">
        <strong><?= dangcapnhatdulieu ?></strong>
    </div>
<?php } ?>