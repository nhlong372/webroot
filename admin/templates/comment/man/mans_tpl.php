<?php
$linkMan = "index.php?com=" . $variant . "&act=man&type=" . $type;
?>

<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý bình luận - <strong class="text-uppercase"><?= $item['namevi'] ?></strong></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-danger mr-1" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        <a class="btn btn-sm bg-gradient-primary mr-1" href="<?= $configBase . $item['slugvi'] ?>" target="_blank" title="<?= $item['namevi'] ?>"><i class="far fa-eye mr-1"></i>Xem chi tiết</a>
    </div>

    <div class="row">
        <div class="col-xl-3">
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Đánh Giá Trung Bình</h3>
                </div>
                <div class="card-body">
                    <div class="comment-avg-point mb-4">
                        <div class="text-center">
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
                    <div class="comment-progress-percent">
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
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Danh sách bình luận</h3>
                </div>
                <div class="card-body comment-manager">
                    <?php if (!empty($comment->lists)) { ?>
                        <div class="comment-lists">
                            <div class="comment-load">
                                <?php
                                foreach ($comment->lists as $v_lists) {
                                    /* Params data */
                                    $comment->params = array();
                                    $comment->params['id_variant'] = $item['id'];
                                    $comment->params['type'] = $item['type'];
                                    $comment->params['is_admin'] = true;
                                    $comment->params['lists'] = $v_lists;
                                    $comment->params['lists']['photo'] = $comment->photo($v_lists['id']);
                                    $comment->params['lists']['video'] = $comment->video($v_lists['id']);
                                    $comment->params['lists']['replies'] = $comment->replies($v_lists['id'], $item['id'], $item['type'], true);

                                    /* Get template */
                                    echo $comment->markdown('admin/lists', $comment->params);
                                }
                                ?>
                            </div>
                            <?php if ($comment->total > $comment->limitParentShow) { ?>
                                <div class="comment-load-more-control text-center mt-4">
                                    <input type="hidden" class="limit-from" value="<?= $comment->limitParentShow ?>">
                                    <input type="hidden" class="limit-get" value="<?= $comment->limitParentGet ?>">
                                    <input type="hidden" class="id-variant" value="<?= $item['id'] ?>">
                                    <input type="hidden" class="type" value="<?= $item['type'] ?>">
                                    <button class="btn btn-sm btn-primary btn-load-more-comment-parent rounded-0 w-100 font-weight-bold py-2 px-3" href="javascript:void(0)" title="Tải thêm bình luận">Tải thêm bình luận</button>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer text-sm">
        <a class="btn btn-sm bg-gradient-danger mr-1" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        <a class="btn btn-sm bg-gradient-primary mr-1" href="<?= $configBase . $item['slugvi'] ?>" target="_blank" title="<?= $item['namevi'] ?>"><i class="far fa-eye mr-1"></i>Xem chi tiết</a>
    </div>
</section>