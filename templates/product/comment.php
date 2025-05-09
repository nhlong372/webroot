<div class="comment-page">
    <!-- Statistic comment -->
    <div class="comment-statistic mb-4">
        <div class="card">
            <div class="card-header text-uppercase"><strong>Đánh giá sản phẩm</strong></div>
            <div class="card-body">
                <div class="row align-items-center py-3">
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <div class="text-center">
                            <div class="comment-title"><strong>Đánh Giá Trung Bình</strong></div>
                            <div class="comment-point"><strong><?= $comment->avgPoint() ?>/5</strong></div>
                            <div class="comment-star">
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <span style="width: <?= $comment->avgStar() ?>%">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </span>
                            </div>
                            <div class="comment-count"><a>(<?= $comment->total ?> nhận xét)</a></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <div class="comment-progress rate-5">
                            <span class="progress-num">5</span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(5) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(5) ?>%</span>
                        </div>
                        <div class="comment-progress rate-4">
                            <span class="progress-num">4</span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(4) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(4) ?>%</span>
                        </div>
                        <div class="comment-progress rate-3">
                            <span class="progress-num">3</span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(3) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(3) ?>%</span>
                        </div>
                        <div class="comment-progress rate-2">
                            <span class="progress-num">2</span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(2) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(2) ?>%</span>
                        </div>
                        <div class="comment-progress rate-1">
                            <span class="progress-num">1</span>
                            <div class="progress">
                                <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(1) ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="progress-total"><?= $comment->perScore(1) ?>%</span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="text-center">
                            <p class="mb-2">Chia sẻ nhận xét về sản phẩm</p>
                            <button type="button" class="btn btn-sm btn-warning btn-write-comment py-2 px-3"><strong>Viết nhận xét của bạn</strong></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Write comment -->
    <div class="comment-write mb-4" id="comment-write">
        <div class="card">
            <div class="card-header text-uppercase"><strong>Gửi nhận xét của bạn</strong></div>
            <div class="card-body">
                <form id="form-comment" action="" method="post" enctype="multipart/form-data">
                    <div class="response-review"></div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label>1. Đánh giá của bạn về sản phẩm này:</label>
                                <div class="review-rating-star">
                                    <div class="review-rating-star-icon">
                                        <i class="fa fa-star star-empty" data-value="1"></i>
                                        <i class="fa fa-star star-empty" data-value="2"></i>
                                        <i class="fa fa-star star-empty" data-value="3"></i>
                                        <i class="fa fa-star star-empty" data-value="4"></i>
                                        <i class="fa fa-star star-empty" data-value="5"></i>
                                    </div>
                                    <input type="number" class="review-rating-star-input hidden" name="dataReview[star]" id="review-star" data-min="1" data-max="5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="review-title">2. Tiêu đề của nhận xét:</label>
                                <input type="text" class="form-control text-sm" name="dataReview[title]" id="review-title" placeholder="Nhập tiêu đề nhận xét *">
                            </div>
                            <div class="form-group">
                                <label for="review-content">3. Viết nhận xét của bạn vào bên dưới:</label>
                                <textarea class="form-control text-sm" name="dataReview[content]" id="review-content" placeholder="Nhận xét của bạn về sản phẩm này *" rows="11"></textarea>
                            </div>
                            <div class="form-group">
                                <label>4. Thông tin liên hệ:</label>
                                <div class="form-row">
                                    <div class="col-4">
                                        <input type="text" class="form-control text-sm" name="dataReview[fullname]" id="review-fullname" placeholder="Nhập họ tên liên hệ *">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control text-sm" name="dataReview[phone]" id="review-phone" placeholder="Nhập số điện thoại liên hệ *">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control text-sm" name="dataReview[email]" id="review-email" placeholder="Nhập email liên hệ *">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group review-preview">
                                <div class="row">
                                    <div class="col-4">
                                        <?= $func->getImage(['class' => 'border rounded lazy w-100', 'sizes' => '150x150x2', 'upload' => UPLOAD_PRODUCT_L, 'image' => $rowDetail['photo'], 'alt' => $rowDetail['name' . $lang]]) ?>
                                    </div>
                                    <div class="col-8">
                                        <h6 class="text-uppercase"><?= $rowDetail['name' . $lang] ?></h6>
                                        <div class="comment-star">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span style="width: <?= $comment->avgStar() ?>%">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </span>
                                        </div>
                                        <div class="comment-count mb-2"><strong>(<?= $comment->total ?> nhận xét)</strong></div>
                                        <div class="text-split mb-0"><?= $func->decodeHtmlChars($rowDetail['desc' . $lang]) ?></div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($comment->hasMedia) { ?>
                                <hr>

                                <div class="form-group">
                                    <label><strong>Hình ảnh: (Tối đa 3 hình)</strong></label>
                                    <div class="review-file-uploader">
                                        <input type="file" id="review-file-photo" name="review-file-photo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="d-block"><strong>Video clip:</strong></label>
                                    <div class="review-poster-video-avatar avatar mb-3">
                                        <div class="avatar-zone mr-3">
                                            <label class="avatar-label d-block mb-0" id="review-poster-video-label" for="review-poster-video">
                                                <div class="avatar-detail border rounded overflow-hidden" id="review-poster-video-preview">
                                                    <?= $func->getImage(['class' => 'lazy rounded', 'sizes' => '150x150x2', 'upload' => 'assets/images/', 'image' => 'noimage.png', 'alt' => 'Blank video poster']) ?>
                                                </div>
                                                <input type="file" class="d-none" name="review-poster-video" id="review-poster-video">
                                            </label>
                                        </div>
                                        <div class="avatar-dimension">
                                            <p class="mb-0">Hình ảnh đại diện</p>
                                            <p class="mb-0">Định dạng: <strong><?= $config['website']['video']['poster']['extension'] ?></strong></p>
                                        </div>
                                    </div>
                                    <div class="custom-file mb-2" style="max-width:300px;">
                                        <input type="file" class="custom-file-input" name="review-file-video" id="review-file-video" lang="vi">
                                        <label class="custom-file-label mb-0" data-browse="Chọn" for="review-file-video">Tập tin video</label>
                                    </div>
                                    <div class="video-config">
                                        <span class="d-inline-block mr-2">Định dạng: <strong><?= implode(" | ", $config['website']['video']['extension']) ?></strong></span>
                                        <span class="d-inline-block">Tối đa: <strong><?= $config['website']['video']['allow-size'] ?></strong></span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-warning text-capitalize py-2 px-3"><strong>Gửi nhận xét</strong></button>
                    <input type="hidden" name="dataReview[id_variant]" value="<?= $rowDetail['id'] ?>">
                    <input type="hidden" name="dataReview[type]" value="<?= $rowDetail['type'] ?>">
                </form>
            </div>
        </div>
    </div>

    <!-- Lists comment -->
    <?php if (!empty($comment->lists)) { ?>
        <div class="comment-lists">
            <div class="card">
                <div class="card-header text-uppercase"><strong>Các bình luận khác</strong></div>
                <div class="card-body pt-5 pb-3">
                    <div class="comment-load">
                        <?php
                        foreach ($comment->lists as $v_lists) {
                            /* Params data */
                            $comment->params = array();
                            $comment->params['id_variant'] = $rowDetail['id'];
                            $comment->params['type'] = $rowDetail['type'];
                            $comment->params['lists'] = $v_lists;
                            $comment->params['lists']['photo'] = $comment->photo($v_lists['id']);
                            $comment->params['lists']['video'] = $comment->video($v_lists['id']);
                            $comment->params['lists']['replies'] = $comment->replies($v_lists['id'], $rowDetail['id'], $rowDetail['type']);

                            /* Get template */
                            echo $comment->markdown('customer/lists', $comment->params);
                        }
                        ?>
                    </div>
                    <?php if ($comment->total > $comment->limitParentShow) { ?>
                        <div class="comment-load-more-control text-center mt-4">
                            <input type="hidden" class="limit-from" value="<?= $comment->limitParentShow ?>">
                            <input type="hidden" class="limit-get" value="<?= $comment->limitParentGet ?>">
                            <input type="hidden" class="id-variant" value="<?= $rowDetail['id'] ?>">
                            <input type="hidden" class="type" value="<?= $rowDetail['type'] ?>">
                            <button class="btn btn-sm btn-primary btn-load-more-comment-parent rounded-0 w-100 font-weight-bold py-2 px-3" href="javascript:void(0)" title="Tải thêm bình luận">Tải thêm bình luận</button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>