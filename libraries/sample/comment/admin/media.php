<div class="carousel carousel-comment-media slide mt-2" id="carousel-comment-media-<?= $params['lists']['id'] ?>" data-ride="carousel" data-touch="true" data-interval="false">
    <ol class="carousel-indicators w-clear">
        <?php if (!empty($params['lists']['video'])) { ?>
            <li class="position-relative float-left transition mr-1" data-target="#carousel-comment-media-<?= $params['lists']['id'] ?>" data-slide-to="0" data-id="video">
                <?= $this->func->getImage(['class' => 'w-100', 'sizes' => '70x70x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $params['lists']['video']['photo'], 'alt' => $params['lists']['title']]) ?>
                <div class="comment-media-play">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="25px" width="25px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                        <path class="comment-media-play-stroke-solid" fill="none" stroke="white" d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
						C97.3,23.7,75.7,2.3,49.9,2.5" />
                        <path class="comment-media-play-stroke-dotted" fill="none" stroke="white" d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
						C97.3,23.7,75.7,2.3,49.9,2.5" />
                        <path class="comment-media-play-icon" fill="white" d="M38,69c-1,0.5-1.8,0-1.8-1.1V32.1c0-1.1,0.8-1.6,1.8-1.1l34,18c1,0.5,1,1.4,0,1.9L38,69z" />
                    </svg>
                </div>
            </li>
        <?php } ?>
        <?php if (!empty($params['lists']['photo'])) {
            foreach ($params['lists']['photo'] as $k_photo => $v_photo) { ?>
                <li class="float-left transition mr-1" data-target="#carousel-comment-media-<?= $params['lists']['id'] ?>" data-slide-to="<?= (!empty($params['lists']['video'])) ? ($k_photo + 1) : $k_photo ?>" data-id="<?= $v_photo['id'] ?>">
                    <?= $this->func->getImage(['class' => 'w-100', 'sizes' => '70x70x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $v_photo['photo'], 'alt' => $params['lists']['title']]) ?>
                </li>
        <?php }
        } ?>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-lists transition">
            <?php if (!empty($params['lists']['video'])) { ?>
                <div class="carousel-item carousel-comment-media-item-video">
                    <video id="file-video" controls>
                        <source src="<?= ASSET . UPLOAD_VIDEO_L . $params['lists']['video']['video'] ?>" type="video/mp4">
                    </video>
                </div>
            <?php } ?>
            <?php if (!empty($params['lists']['photo'])) {
                foreach ($params['lists']['photo'] as $k_photo => $v_photo) { ?>
                    <div class="carousel-item carousel-comment-media-item-<?= $v_photo['id'] ?>">
                        <?= $this->func->getImage(['class' => 'w-100', 'sizes' => '550x490x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $v_photo['photo'], 'alt' => $params['lists']['title']]) ?>
                    </div>
            <?php }
            } ?>
        </div>
        <div class="carousel-control">
            <a class="carousel-control-prev transition" href="#carousel-comment-media-<?= $params['lists']['id'] ?>" role="button" data-slide="prev">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-left" width="40" height="40" viewBox="0 0 24 24" stroke-width="1" stroke="#222222" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 15l-6 -6l-6 6h12" transform="rotate(270 12 12)" />
                    </svg>
                </span>
            </a>
            <a class="carousel-control-next transition" href="#carousel-comment-media-<?= $params['lists']['id'] ?>" role="button" data-slide="next">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-right" width="40" height="40" viewBox="0 0 24 24" stroke-width="1" stroke="#222222" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 15l-6 -6l-6 6h12" transform="rotate(90 12 12)" />
                    </svg>
                </span>
            </a>
        </div>
    </div>
</div>