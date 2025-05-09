<!-- Css Files -->
<?php
$css->set("css/animate.min.css");
$css->set("bootstrap/bootstrap.css");
$css->set("fontawesome611/all.css");
$css->set("confirm/confirm.css");
$css->set("holdon/HoldOn.css");
$css->set("fancybox3/jquery.fancybox.css");
$css->set("fancybox3/jquery.fancybox.style.css");
$css->set("photobox/photobox.css");
$css->set("slick/slick.css");
$css->set("slick/slick-theme.css");
$css->set("slick/slick-style.css");
$css->set("fotorama/fotorama.css");
$css->set("fotorama/fotorama-style.css");
//$css->set("datetimepicker/jquery.datetimepicker.css");
//$css->set("simplenotify/simple-notify.css");
//$css->set("fileuploader/font-fileuploader.css");
//$css->set("fileuploader/jquery.fileuploader.min.css");
//$css->set("fileuploader/jquery.fileuploader-theme-dragdrop.css");
//$css->set("css/cart.css");
if (SHOWCOMMENT) {$css->set("css/comment.css");}
$css->set("css/fonts.css");
$css->set("css/effect.css");
$css->set("css/style.css");
$css->set("css/style-responsive.css");
echo $css->get();
?>
<?php if($source!='index'){?>
	<link href="assets/owlcarousel2/owl.carousel.css" type="text/css" rel="stylesheet" />
	<link href="assets/owlcarousel2/owl.theme.default.css" type="text/css" rel="stylesheet" />
	<link href="assets/magiczoomplus/magiczoomplus.css" type="text/css" rel="stylesheet" />
<?php } ?>
<?php if(CARTSITE==true){ ?> 
    <link href="assets/css/cart.css" type="text/css" rel="stylesheet" />
<?php } ?>
<!-- Main color site -->
<style>
    :root {
        --maincolor: #<?=$optsetting['colorSite']?>;
    }
</style>

<!-- Background -->
<?php /*
<?php
$bgbody = $d->rawQueryOne("select status, options, photo from #_photo where act = ? and type = ? limit 0,1", array('photo_static', 'background'));

if (!empty($bgbody['status']) && strpos($bgbody['status'], 'hienthi') !== false) {
    $bgbodyOptions = json_decode($bgbody['options'], true)['background'];
    if ($bgbodyOptions['type_show']) {
        echo '<style type="text/css">body{background: url(' . UPLOAD_PHOTO_L . $bgbody['photo'] . ') ' . $bgbodyOptions['repeat'] . ' ' . $bgbodyOptions['position'] . ' ' . $bgbodyOptions['attachment'] . ' ;background-size:' . $bgbodyOptions['size'] . '}</style>';
    } else {
        echo ' <style type="text/css">body{background-color:#' . $bgbodyOptions['color'] . '}</style>';
    }
}
?>
*/ ?>
<?= $func->decodeHtmlChars($setting['analytics']) ?>
<?= $func->decodeHtmlChars($setting['headjs']) ?>