<?php
/* Background */
// $nametype = "background";
// $config['photo']['photo_static'][$nametype]['title_main'] = "Background";
// $config['photo']['photo_static'][$nametype]['check'] = array("hienthi" => "Hiển thị");
// $config['photo']['photo_static'][$nametype]['images'] = true;
// $config['photo']['photo_static'][$nametype]['background'] = true;
// $config['photo']['photo_static'][$nametype]['width'] = 900;
// $config['photo']['photo_static'][$nametype]['height'] = 300;
// $config['photo']['photo_static'][$nametype]['thumb'] = '900x300x1';
// $config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';

/* Banner */
$nametype = "banner";
$config['photo']['photo_static'][$nametype]['title_main'] = "Banner";
$config['photo']['photo_static'][$nametype]['check'] = array("hienthi" => "Hiển thị");
$config['photo']['photo_static'][$nametype]['images'] = true;
$config['photo']['photo_static'][$nametype]['width'] = 570;
$config['photo']['photo_static'][$nametype]['height'] = 120;
$config['photo']['photo_static'][$nametype]['thumb'] = '266x76x2';
$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';
$config['photo']['photo_static'][$nametype]['css_hinh'] = '';//background:#000;padding:10px;display: inline-block;

/* Logo */
$nametype = "logo";
$config['photo']['photo_static'][$nametype]['title_main'] = "Logo";
$config['photo']['photo_static'][$nametype]['check'] = array("hienthi" => "Hiển thị");
$config['photo']['photo_static'][$nametype]['images'] = true;
$config['photo']['photo_static'][$nametype]['width'] = 120;
$config['photo']['photo_static'][$nametype]['height'] = 120;
$config['photo']['photo_static'][$nametype]['thumb'] = '120x120x2';
$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';
$config['photo']['photo_static'][$nametype]['css_hinh'] = '';//background:#000;padding:10px;display: inline-block;

/* Favicon */
$nametype = "favicon";
$config['photo']['photo_static'][$nametype]['title_main'] = "Favicon";
$config['photo']['photo_static'][$nametype]['check'] = array("hienthi" => "Hiển thị");
$config['photo']['photo_static'][$nametype]['images'] = true;
$config['photo']['photo_static'][$nametype]['width'] = 50;
$config['photo']['photo_static'][$nametype]['height'] = 50;
$config['photo']['photo_static'][$nametype]['thumb'] = '50x50x2';
$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';
$config['photo']['photo_static'][$nametype]['css_hinh'] = '';//background:#000;padding:10px;display: inline-block;

/* Watermark */
if(WATERMARKPRODUCT==true){
    $nametype = "watermark";
    $config['photo']['photo_static'][$nametype]['title_main'] = "Đóng dấu sản phẩm";
    $config['photo']['photo_static'][$nametype]['check'] = array("hienthi" => "Hiển thị");
    $config['photo']['photo_static'][$nametype]['images'] = true;
    $config['photo']['photo_static'][$nametype]['watermark'] = true;
    $config['photo']['photo_static'][$nametype]['watermark-advanced'] = true;
    $config['photo']['photo_static'][$nametype]['width'] = 50;
    $config['photo']['photo_static'][$nametype]['height'] = 50;
    $config['photo']['photo_static'][$nametype]['thumb'] = '50x50x1';
    $config['photo']['photo_static'][$nametype]['img_type'] = '.png|.PNG|.Png';
    $config['photo']['photo_static'][$nametype]['css_hinh'] = '';//background:#000;padding:10px;display: inline-block;
}
/* Watermark bài viết */
if (WATERMARKPOST == true) {
    $nametype = "watermark-news";
    $config['photo']['photo_static'][$nametype]['title_main'] = "Đóng dấu bài viết";
    $config['photo']['photo_static'][$nametype]['check'] = array("hienthi" => "Hiển thị");
    $config['photo']['photo_static'][$nametype]['images'] = true;
    $config['photo']['photo_static'][$nametype]['watermark'] = true;
    $config['photo']['photo_static'][$nametype]['watermark-advanced'] = true;
    $config['photo']['photo_static'][$nametype]['width'] = 50;
    $config['photo']['photo_static'][$nametype]['height'] = 50;
    $config['photo']['photo_static'][$nametype]['thumb'] = '50x50x1';
    $config['photo']['photo_static'][$nametype]['img_type'] = '.png|.PNG|.Png';
    $config['photo']['photo_static'][$nametype]['css_hinh'] = ''; //background:#000;padding:10px;
}

/* Video */
// $nametype = "video";
// $config['photo']['photo_static'][$nametype]['title_main'] = "Video";
// $config['photo']['photo_static'][$nametype]['check'] = array("hienthi" => "Hiển thị");
// $config['photo']['photo_static'][$nametype]['images'] = true;
// $config['photo']['photo_static'][$nametype]['video'] = true;
// $config['photo']['photo_static'][$nametype]['name'] = true;
// $config['photo']['photo_static'][$nametype]['desc'] = true;
// $config['photo']['photo_static'][$nametype]['content'] = true;
// $config['photo']['photo_static'][$nametype]['width'] = 250;
// $config['photo']['photo_static'][$nametype]['height'] = 150;
// $config['photo']['photo_static'][$nametype]['thumb'] = '250x150x1';
// $config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';
// $config['photo']['photo_static'][$nametype]['css_hinh'] = '';//background:#000;padding:10px;display: inline-block;

/* Popup */
/*$nametype = "popup";
$config['photo']['photo_static'][$nametype]['title_main'] = "Popup";
$config['photo']['photo_static'][$nametype]['check'] = array("hienthi" => "Hiển thị");
$config['photo']['photo_static'][$nametype]['images'] = true;
$config['photo']['photo_static'][$nametype]['name'] = true;
$config['photo']['photo_static'][$nametype]['link'] = true;
$config['photo']['photo_static'][$nametype]['width'] = 800;
$config['photo']['photo_static'][$nametype]['height'] = 600;
$config['photo']['photo_static'][$nametype]['thumb'] = '100x100x2';
$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';
$config['photo']['photo_static'][$nametype]['css_hinh'] = '';//background:#000;padding:10px;display: inline-block;*/

/* Slideshow */
$nametype = "slide";
$config['photo']['man_photo'][$nametype]['title_main_photo'] = "Slideshow";
$config['photo']['man_photo'][$nametype]['check_photo'] = array("hienthi" => "Hiển thị");
$config['photo']['man_photo'][$nametype]['number_photo'] = 1;
$config['photo']['man_photo'][$nametype]['images_photo'] = true;
$config['photo']['man_photo'][$nametype]['avatar_photo'] = true;
$config['photo']['man_photo'][$nametype]['link_photo'] = true;
$config['photo']['man_photo'][$nametype]['name_photo'] = true;
$config['photo']['man_photo'][$nametype]['width_photo'] = 1920;
$config['photo']['man_photo'][$nametype]['height_photo'] = 560;
$config['photo']['man_photo'][$nametype]['thumb_photo'] = '200x100x1';
$config['photo']['man_photo'][$nametype]['notadd'] = '';//khongthemxoa
$config['photo']['man_photo'][$nametype]['file_photo'] = false;
$config['photo']['man_photo'][$nametype]['img_type_photo'] = '.jpg|.gif|.png|.jpeg|.gif';
$config['photo']['man_photo'][$nametype]['file_type_photo'] = '.doc|.docx|.pdf|.rar|.zip|.ppt|.pptx|.xls|.xlsx';
$config['photo']['man_photo'][$nametype]['css_hinh'] = '';//background:#000;padding:10px;display: inline-block;

/* Slideshow product */
// $nametype = "slide-product";
// $config['photo']['man_photo'][$nametype]['title_main_photo'] = "Slideshow sản phẩm";
// $config['photo']['man_photo'][$nametype]['check_photo'] = array("hienthi" => "Hiển thị");
// $config['photo']['man_photo'][$nametype]['number_photo'] = 2;
// $config['photo']['man_photo'][$nametype]['images_photo'] = true;
// $config['photo']['man_photo'][$nametype]['avatar_photo'] = true;
// $config['photo']['man_photo'][$nametype]['link_photo'] = true;
// $config['photo']['man_photo'][$nametype]['name_photo'] = true;
// $config['photo']['man_photo'][$nametype]['width_photo'] = 1366;
// $config['photo']['man_photo'][$nametype]['height_photo'] = 600;
// $config['photo']['man_photo'][$nametype]['thumb_photo'] = '200x100x1';
// $config['photo']['man_photo'][$nametype]['notadd'] = '';//khongthemxoa
// $config['photo']['man_photo'][$nametype]['img_type_photo'] = '.jpg|.gif|.png|.jpeg|.gif';
// $config['photo']['man_photo'][$nametype]['css_hinh'] = '';//background:#000;padding:10px;display: inline-block;

/* Các mạng xã hội */
$nametype = "social";
$config['photo']['man_photo'][$nametype]['title_main_photo'] = "Các mạng xã hội";
$config['photo']['man_photo'][$nametype]['check_photo'] = array("hienthi" => "Hiển thị");
$config['photo']['man_photo'][$nametype]['number_photo'] = 1;
$config['photo']['man_photo'][$nametype]['images_photo'] = true;
$config['photo']['man_photo'][$nametype]['avatar_photo'] = true;
$config['photo']['man_photo'][$nametype]['link_photo'] = true;
$config['photo']['man_photo'][$nametype]['name_photo'] = true;
$config['photo']['man_photo'][$nametype]['width_photo'] = 40;
$config['photo']['man_photo'][$nametype]['height_photo'] = 40;
$config['photo']['man_photo'][$nametype]['thumb_photo'] = '40x40x2';
$config['photo']['man_photo'][$nametype]['notadd'] = '';//khongthemxoa
$config['photo']['man_photo'][$nametype]['img_type_photo'] = '.jpg|.gif|.png|.jpeg|.gif';
$config['photo']['man_photo'][$nametype]['css_hinh'] = '';//background:#000;display: inline-block;

/* Liên kết */
/*$nametype = "lien-ket";
$config['photo']['man_photo'][$nametype]['title_main_photo'] = "Liên kết";
$config['photo']['man_photo'][$nametype]['check_photo'] = array("hienthi" => "Hiển thị");
$config['photo']['man_photo'][$nametype]['number_photo'] = 5;
$config['photo']['man_photo'][$nametype]['images_photo'] = false;
$config['photo']['man_photo'][$nametype]['notphoto'] = true;
$config['photo']['man_photo'][$nametype]['avatar_photo'] = false;
$config['photo']['man_photo'][$nametype]['link_photo'] = true;
$config['photo']['man_photo'][$nametype]['name_photo'] = true;
$config['photo']['man_photo'][$nametype]['width_photo'] = 1366;
$config['photo']['man_photo'][$nametype]['height_photo'] = 275;
$config['photo']['man_photo'][$nametype]['thumb_photo'] = '200x100x1';
$config['photo']['man_photo'][$nametype]['notadd'] = '';//khongthemxoa
$config['photo']['man_photo'][$nametype]['img_type_photo'] = '.jpg|.gif|.png|.jpeg|.gif';
$config['photo']['man_photo'][$nametype]['css_hinh'] = '';//background:#000;padding:10px;display: inline-block;*/

/* Video */
$nametype = "video";
$config['photo']['man_photo'][$nametype]['title_main_photo'] = "Video";
$config['photo']['man_photo'][$nametype]['check_photo'] = array("noibat" => "Nổi bật", "hienthi" => "Hiển thị");
$config['photo']['man_photo'][$nametype]['number_photo'] = 1;
$config['photo']['man_photo'][$nametype]['video_photo'] = true;
$config['photo']['man_photo'][$nametype]['name_photo'] = true;
$config['photo']['man_photo'][$nametype]['images_photo'] = true;
$config['photo']['man_photo'][$nametype]['avatar_photo'] = true;
$config['photo']['man_photo'][$nametype]['width_photo'] = 504;
$config['photo']['man_photo'][$nametype]['height_photo'] = 282;
$config['photo']['man_photo'][$nametype]['thumb_photo'] = '100x100x1';
$config['photo']['man_photo'][$nametype]['notadd'] = '';//khongthemxoa
$config['photo']['man_photo'][$nametype]['img_type_photo'] = '.jpg|.gif|.png|.jpeg|.gif';
$config['photo']['man_photo'][$nametype]['css_hinh'] = '';//background:#000

/* Đối tác */
/*$nametype = "doitac";
$config['photo']['man_photo'][$nametype]['title_main_photo'] = "Đối tác";
$config['photo']['man_photo'][$nametype]['check_photo'] = array("hienthi" => "Hiển thị");
$config['photo']['man_photo'][$nametype]['number_photo'] = 1;
$config['photo']['man_photo'][$nametype]['images_photo'] = true;
$config['photo']['man_photo'][$nametype]['avatar_photo'] = true;
$config['photo']['man_photo'][$nametype]['link_photo'] = true;
$config['photo']['man_photo'][$nametype]['name_photo'] = true;
$config['photo']['man_photo'][$nametype]['width_photo'] = 175;
$config['photo']['man_photo'][$nametype]['height_photo'] = 95;
$config['photo']['man_photo'][$nametype]['thumb_photo'] = '175x95x2';
$config['photo']['man_photo'][$nametype]['notadd'] = '';//khongthemxoa
$config['photo']['man_photo'][$nametype]['img_type_photo'] = '.jpg|.gif|.png|.jpeg|.gif';
$config['photo']['man_photo'][$nametype]['css_hinh'] = '';//background:#000
*/

/*$nametype = "nhacnen";
$config['photo']['photo_static'][$nametype]['title_main'] = "Nhạc nền";
$config['photo']['photo_static'][$nametype]['nhac'] = true;
$config['photo']['photo_static'][$nametype]['img_type'] = '.mp3|.MP3';*/

/*$nametype = "videomp4";
$config['photo']['photo_static'][$nametype]['title_main'] = "Video mp4";
$config['photo']['photo_static'][$nametype]['videomp4'] = true;   
$config['photo']['photo_static'][$nametype]['mp4_type'] = '.mp4|.MP4';
$config['photo']['photo_static'][$nametype]['check'] = array("hienthi" => "Hiển thị");
$config['photo']['photo_static'][$nametype]['images'] = true;
$config['photo']['photo_static'][$nametype]['width'] = 700;
$config['photo']['photo_static'][$nametype]['height'] = 500;
$config['photo']['photo_static'][$nametype]['thumb'] = '120x90x1';
$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';
$config['photo']['photo_static'][$nametype]['css_hinh'] = '';//background:#000;padding:10px;display: inline-block;*/