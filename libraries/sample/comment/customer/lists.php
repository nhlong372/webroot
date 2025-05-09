<div class="comment-item">
    <div class="comment-item-poster">
        <div class="comment-item-letter"><?= $this->subName($params['lists']['fullname']) ?></div>
        <div class="comment-item-name"><?= $params['lists']['fullname'] ?></div>
        <div class="comment-item-posttime"><?= $this->timeAgo($params['lists']['date_posted']) ?></div>
    </div>
    <div class="comment-item-information">
        <div class="comment-item-rating mb-2 w-clear">
            <div class="comment-item-star comment-star mb-0">
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <span style="width: <?= $this->scoreStar($params['lists']['star']) ?>%;">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </span>
            </div>
            <div class="comment-item-title"><?= $this->func->decodeHtmlChars($params['lists']['title']) ?></div>
        </div>

        <div class="comment-item-content mb-2"><?= nl2br($this->func->decodeHtmlChars($params['lists']['content'])) ?></div>

        <a class="btn-reply-comment d-inline-block align-top text-decoration-none text-primary mb-2" href="javascript:void(0)" data-name="<?= $params['lists']['fullname'] ?>">Trả lời</a>

        <?php
        if ($this->hasMedia && (!empty($params['lists']['photo']) || !empty($params['lists']['video']))) {
            include LIBRARIES . "sample/comment/customer/media.php";
        }
        ?>

        <?php if (!empty($params['lists']['replies'])) {
            $params['replies'] = $params['lists']['replies']; ?>
            <!-- Replies -->
            <div class="comment-replies mt-3">
                <div class="comment-replies-load">
                    <?php include LIBRARIES . "sample/comment/customer/replies.php"; ?>
                </div>
                <?php if ($this->totalReplies($params['lists']['id'], $params['id_variant'], $params['type']) > $this->limitChildShow) { ?>
                    <div class="comment-load-more-control border-top text-left mt-4 pt-3">
                        <input type="hidden" class="limit-from" value="<?= $this->limitChildShow ?>">
                        <input type="hidden" class="limit-get" value="<?= $this->limitChildGet ?>">
                        <input type="hidden" class="id-parent" value="<?= $params['lists']['id'] ?>">
                        <input type="hidden" class="id-variant" value="<?= $params['id_variant'] ?>">
                        <input type="hidden" class="type" value="<?= $params['type'] ?>">
                        <button class="btn-load-more-comment-child text-primary text-decoration-none" href="javascript:void(0)" title="Xem thêm bình luận">Xem thêm bình luận</button>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <?php include LIBRARIES . "sample/comment/customer/reply.php"; ?>
    </div>
</div>