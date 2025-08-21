<?php
if (!defined('LIBRARIES')) die("Error");

/* Timezone */
date_default_timezone_set('Asia/Ho_Chi_Minh');

/* Cấu hình coder */
define('NN_CONTRACT', 'MSHD');
define('NN_AUTHOR', 'NINA_DEVELOPER');

/* Cấu hình bản quyền cho phép copy */
define('COPYSITE', true);

/* Cấu hình giỏ hàng */
define('CARTSITE', false); // MỞ GIỎ HÀNG
define('CARTSITEADVANCE', false);// GIỎ HÀNG  NÂNG CAO
define('WATERMARKPRODUCT', false); // ĐÓNG DẤU SẢN PHẨM
define('SEARCHPRODUCT', false); // TÌM KIẾM NÂNG CAO CỘT TRÁI SẢN PHẨM
define('FAVORITEPRODUCT', false); // SẢN PHẨM YÊU THÍCH
define('OPENDESC', false); // MỞ MÔ TẢ SẢN PHẨM
define('COLORSIZE', false); //MỞ MÀU - KÍCH THƯỚC CƠ BẢN
define('SHOWBRAND', false); //MỞ THƯƠNG HIỆU
define('SHOWCOMMENT', false); //MỞ ĐÁNH GIÁ SAO

/* Cấu hình đóng dấu bài viết */
define('WATERMARKPOST',false); // ĐÓNG DẤU BÀI VIẾT

/* Cấu hình popup lên màn hình */
define("QUICKVIEW",false); // MỞ XEM NHANH
define("POPUP",false); //MỞ POPUP

/* Cấu hình các nút tiện ích góc phải dưới */
define('OPENPHONECOMBO',true);

/* Cấu hình chung */
$config = array(
    'author' => array(
        'name' => 'N/A',
        'email' => 'N/A',
        'timefinish' => '07/05/2025'
    ),
    'arrayDomainSSL' => array(),
    'database' => array(
        'server-name' => $_SERVER["SERVER_NAME"],
        'url' => '/webroot/',
        'type' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'webroot',
        'username' => 'root',
        'password' => '',
        'port' => 3306,
        'prefix' => 'table_',
        'charset' => 'utf8mb4'
    ),
    'website' => array(
        'error-reporting' => false,
        'secret' => '$nina@',
        'salt' => 'swKJjeS!t',
        'debug-developer' => true,
        'debug-css' => true,
        'debug-js' => true,
        'index' => false,
        'image' => array(
            //'hasWebp' => false,
        ),
        'video' => array(
            'extension' => array('mp4', 'mkv'),
            'poster' => array(
                'width' => 700,
                'height' => 610,
                'extension' => '.jpg|.png|.jpeg'
            ),
            'allow-size' => '100Mb',
            'max-size' => 100 * 1024 * 1024
        ),
        'upload' => array(
            'max-width' => 1600,
            'max-height' => 1600
        ),
        'lang' => array(
            'vi' => 'Tiếng Việt',
            //'en' => 'Tiếng Anh'
        ),
        'lang-doc' => 'vi|en',
        'slug' => array(
            'vi' => 'Tiếng Việt',
            // 'en' => 'Tiếng Anh'
        ),
        'seo' => array(
            'vi' => 'Tiếng Việt',
            // 'en' => 'Tiếng Anh'
        ),
        'comlang' => array(
            "gioi-thieu" => array("vi" => "gioi-thieu", "en" => "about-us"),
            "san-pham" => array("vi" => "san-pham", "en" => "product"),
            "tin-tuc" => array("vi" => "tin-tuc", "en" => "news"),
            "tuyen-dung" => array("vi" => "tuyen-dung", "en" => "recruitment"),
            "thu-vien-anh" => array("vi" => "thu-vien-anh", "en" => "gallery"),
            "video" => array("vi" => "video", "en" => "video"),
            "lien-he" => array("vi" => "lien-he", "en" => "contact")
        )
    ),
    'order' => array(
        'ship' => false
    ),
    'login' => array(
        'admin' => 'LoginAdmin' . NN_CONTRACT,
        'member' => 'LoginMember' . NN_CONTRACT,
        'attempt' => 5,
        'delay' => 15
    ),
    'googleAPI' => array(
        'recaptcha' => array(
            'active' => false,
            'urlapi' => 'https://www.google.com/recaptcha/api/siteverify',
            'sitekey' => '6Lf9GxIiAAAAACasudVQMe_jtWPrsEpjmo2qFdGI',
            'secretkey' => '6Lf9GxIiAAAAAPAFT33rYas-bczKVXEA2UT69Ydj'
        )
    ),
    'oneSignal' => array(
        'active' => false,
        'id' => 'af12ae0e-cfb7-41d0-91d8-8997fca889f8',
        'restId' => 'MWFmZGVhMzYtY2U0Zi00MjA0LTg0ODEtZWFkZTZlNmM1MDg4'
    ),
    'license' => array(
        'version' => "8.0.0",
        'powered' => "NINA"
    )
);

/* Error reporting */
error_reporting(($config['website']['error-reporting']) ? E_ALL : 0);

/* Cấu hình http */
$http = 'http://';
if ($_SERVER["HTTPS"] == "on") {$http = 'https://';}


/* Redirect http/https */
if (!count($config['arrayDomainSSL']) && $http == 'https://') {
    $host = $_SERVER['HTTP_HOST'];
    $request_uri = $_SERVER['REQUEST_URI'];
    $good_url = "http://" . $host . $request_uri;
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $good_url");
    exit;
}

/* Cấu hình base */
$configUrl = $config['database']['server-name'] . $config['database']['url'];
$configBase = $http . $configUrl;

/* Token */
define('TOKEN', md5(NN_CONTRACT . $config['database']['url']));

/* Path */
define('ROOT', str_replace(basename(__DIR__), '', __DIR__));
define('ASSET', $http . $configUrl);
define('ADMIN', 'admin');

/* Cấu hình login */
$loginAdmin = $config['login']['admin'];
$loginMember = $config['login']['member'];

/* Cấu hình upload */
require_once LIBRARIES . "constant.php";
