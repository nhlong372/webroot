<div class="display-news-detail">
    <div class="title-main"><span><?= $rowDetail['name' . $lang] ?></span></div>
    <div class="time-main"><i class="fas fa-calendar-week"></i><span><?= ngaydang ?>: <?= $func->humanTiming($rowDetail['date_created']) ?></span></div>
    <?php if (!empty($rowDetail['content' . $lang])) { ?>

        <!-- <div class="meta-toc">
        <div class="box-readmore">
            <ul class="toc-list" data-toc="article" data-toc-headings="h1, h2, h3"></ul>
        </div>
    </div> -->

        <div class="content-main autoHeight w-clear" id="toc-content"><?= $func->decodeHtmlChars($rowDetail['content' . $lang]) ?></div>
    <?php } else { ?>
        <div class="alert alert-warning w-100" role="alert">
            <strong><?= noidungdangcapnhat ?></strong>
        </div>
    <?php } ?>

    <div class="content-main album-gallery css_flex_album w-clear">
        <?php if (!empty($rowDetailPhoto)) {
            foreach ($rowDetailPhoto as $k => $v) { ?>
                <a class="album text-decoration-none" rel="album-<?= $rowDetail['id'] ?>" href="<?= UPLOAD_NEWS_L . $v['photo'] ?>" title="<?= $rowDetail['name' . $lang] ?>">
                    <p class="pic-album scale-img"><img onerror="this.src='<?= THUMBS ?>/480x360x2/assets/images/noimage.png';" src="<?= THUMBS ?>/480x360x1/<?= UPLOAD_NEWS_L . $v['photo'] ?>" alt="<?= $rowDetail['name' . $lang] ?>" /></p>
                </a>
        <?php }
        }  ?>
    </div>

    <?php if (!empty($rowDetail['content' . $lang])) { ?>
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
    <?php } ?>
</div>
<?php if (!empty($news_other)) { ?>
    <div class="display-news-other">
        <div class="share othernews mb-3">
            <b><?= baivietkhac ?>:</b>
            <ul class="list-news-other">
                <?php foreach ($news_other as $k => $v) { ?>
                    <li><a class="text-decoration-none" href="<?= $v[$sluglang] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?> - <?= date("d/m/Y", $v['date_created']) ?></a></li>
                <?php } ?>
            </ul>
            <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
        </div>
    </div>
<?php } ?>

<?php /*if (!empty($news_same)) { ?>
    <div class="display-news-same">
        <div class="share othernews mb-3">
            <b><?= baivietkhac ?>:</b>
            <ul class="list-news-other">
                <?php foreach ($news_same as $k => $v) { ?>
                    <li><a class="text-decoration-none" href="<?= $v[$sluglang] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?> - <?= date("d/m/Y", $v['date_created']) ?></a></li>
                <?php } ?>
            </ul>
            <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
        </div>
    </div>
<?php }*/ ?>