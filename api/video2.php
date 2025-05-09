<?php
	include "config.php";
	
	$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
	$video = $d->rawQueryOne("select link_video, photo from #_photo where id = ? limit 0,1",array($id));
?>
<?php if(!empty($video['link_video'])) { ?>
	<div class="youtube-player" data-video-id="<?= $func->getYoutube($video['link_video']) ?>">
		<img class="btn-player" src="assets/images/icon-video.png" alt="Play">
		<img class="swiper-lazy" onerror="this.src='<?=THUMBS?>/504x282x1/assets/images/noimage.png';" src="<?=THUMBS?>/504x282x1/<?= UPLOAD_PHOTO_L . $video['photo'] ?>"  alt="<?=$video['name'.$lang]?>" title="<?=$video['name'.$lang]?>" />
	</div>
<?php } ?>