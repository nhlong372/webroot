<?php if (!empty($params['replies'])) {
    foreach ($params['replies'] as $v_reply) { ?>
        <div class="comment-replies-item">
            <div class="comment-replies-letter <?= $v_reply['poster'] ?>"><?= $this->subName($v_reply['fullname']) ?></div>
            <div class="comment-replies-info">
                <div class="comment-replies-name mb-1"><?= $v_reply['fullname'] ?><span class="font-weight-normal small text-muted pl-2"><?= $this->timeAgo($v_reply['date_posted']) ?></span><?= ($v_reply['poster'] == 'admin') ? '<span class="font-weight-normal text-info ml-2">(Phản hồi bởi Ban Quản Trị)</span>' : '' ?><?= (strpos($v_reply['status'], 'new-admin') !== false) ? '<strong class="comment-new bg-danger rounded text-white small ml-2 px-2 py-1">Mới</strong>' : '' ?></div>
                <div class="comment-action mb-2">
                    <a class="btn btn-sm <?= (strpos($v_reply['status'], 'hienthi') !== false) ? 'btn-warning' : 'btn-primary' ?> btn-status-comment mr-1" href="javascript:void(0)" data-id="<?= $v_reply['id'] ?>" data-new-sibling="comment-replies-name" data-status="hienthi"><?= (strpos($v_reply['status'], 'hienthi') !== false) ? 'Bỏ duyệt' : 'Duyệt' ?></a>
                    <a class="btn btn-sm btn-danger btn-delete-comment" href="javascript:void(0)" data-id="<?= $v_reply['id'] ?>" data-class="comment-replies-item" data-parents="comment-replies">Xóa</a>
                </div>
                <div class="comment-replies-content"><?= nl2br($this->func->decodeHtmlChars($v_reply['content'])) ?></div>
            </div>
        </div>
<?php }
} ?>