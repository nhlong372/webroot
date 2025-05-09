<?php if (count($slider)) { ?>    
    <div class="slideshow">
        <div class="chay-slider run-slick">
            <?php foreach ($slider as $v) { ?>
                <div class="slideshow-item">
                    <a class="slideshow-image" href="<?= $v['link'] ?>" target="_blank" title="<?= $v['name' . $lang] ?>">
                        <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '1920x560x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>