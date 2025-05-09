<div class="comment-item">
    <div class="comment-item-poster">
        <div class="comment-item-letter"><?= $this->subName($params['lists']['fullname']) ?></div>
        <div class="comment-item-name"><?= $params['lists']['fullname'] ?></div>
        <div class="comment-item-email text-secondary"><?= $params['lists']['email'] ?></div>
        <div class="comment-item-phone text-secondary mb-1"><?= $this->func->formatPhone($params['lists']['phone']) ?></div>
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
            <div class="comment-item-title"><?= $this->func->decodeHtmlChars($params['lists']['title']) ?><?= (strpos($params['lists']['status'], 'new-admin') !== false) ? '<strong class="comment-new bg-danger rounded text-white small ml-2 px-2 py-1">Mới</strong>' : '' ?></div>
        </div>

        <div class="comment-item-content mb-2"><?= nl2br($this->func->decodeHtmlChars($params['lists']['content'])) ?></div>

        <div class="comment-action mb-2">
            <a class="btn btn-sm btn-info btn-reply-comment mr-1" href="javascript:void(0)" data-name="<?= $params['lists']['fullname'] ?>">Trả lời</a>
            <a class="btn btn-sm <?= (strpos($params['lists']['status'], 'hienthi') !== false) ? 'btn-warning' : 'btn-primary' ?> btn-status-comment mr-1" href="javascript:void(0)" data-id="<?= $params['lists']['id'] ?>" data-new-sibling="comment-item-rating" data-status="hienthi"><?= (strpos($params['lists']['status'], 'hienthi') !== false) ? 'Bỏ duyệt' : 'Duyệt' ?></a>
            <a class="btn btn-sm btn-danger btn-delete-comment" href="javascript:void(0)" data-id="<?= $params['lists']['id'] ?>" data-class="comment-item" data-parents="comment-lists">Xóa</a>
        </div>

        <?php
        if ($this->hasMedia && (!empty($params['lists']['photo']) || !empty($params['lists']['video']))) {
            include LIBRARIES . "sample/comment/admin/media.php";
        }
        ?>

        <?php if (!empty($params['lists']['replies'])) {
            $params['replies'] = $params['lists']['replies']; ?>
            <!-- Replies -->
            <div class="comment-replies mt-3">
                <div class="comment-replies-load">
                    <?php include LIBRARIES . "sample/comment/admin/replies.php"; ?>
                </div>
                <?php if ($this->totalReplies($params['lists']['id'], $params['id_variant'], $params['type'], $params['is_admin']) > $this->limitChildShow) { ?>
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

        <?php include LIBRARIES . "sample/comment/admin/reply.php"; ?>
    </div>
</div>