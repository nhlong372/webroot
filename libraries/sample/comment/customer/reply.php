<form class="mt-3" id="form-reply" action="" method="post" enctype="multipart/form-data">
    <div class="response-reply"></div>
    <div class="form-group">
        <textarea class="form-control text-sm" placeholder="Viết câu trả lời của bạn" name="dataReview[content]" id="reply-content" data-name="@<?= $params['lists']['fullname'] ?>:" rows="5"></textarea>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-4">
                <input type="text" class="form-control text-sm" name="dataReview[fullname]" id="reply-fullname" placeholder="Nhập họ tên liên hệ *">
            </div>
            <div class="col-4">
                <input type="text" class="form-control text-sm" name="dataReview[phone]" id="reply-phone" placeholder="Nhập số điện thoại liên hệ *">
            </div>
            <div class="col-4">
                <input type="text" class="form-control text-sm" name="dataReview[email]" id="reply-email" placeholder="Nhập email liên hệ *">
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="submit" class="btn btn-sm btn-warning py-2 px-3">Gửi trả lời</button>
        <button type="button" class="btn btn-sm btn-secondary btn-cancel-reply py-2 px-3">Hủy bỏ</button>
    </div>
    <input type="hidden" name="dataReview[fullname_parent]" value="@<?= $params['lists']['fullname'] ?>:">
    <input type="hidden" name="dataReview[id_parent]" value="<?= $params['lists']['id'] ?>">
    <input type="hidden" name="dataReview[id_variant]" value="<?= $params['id_variant'] ?>">
    <input type="hidden" name="dataReview[type]" value="<?= $params['type'] ?>">
</form>