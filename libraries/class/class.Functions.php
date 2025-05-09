<?php
require LIBRARIES . 'WebpConvert/vendor/autoload.php';

use WebPConvert\WebPConvert;

class Functions
{
    private $d;
    private $hash;
    private $cache;
    function __construct($d, $cache)
    {
        $this->d = $d;
        $this->cache = $cache;
    }
    public function GetWeekdays($ngaytao = 0, $full = 1)
    {
        if ($ngaytao == '' or $ngaytao == 0) return false;
        $str = date('Y-m-d H:i:s', $ngaytao);
        $datetime = new DateTime($str);
        if ($full > 0) {
            $week = array("Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy");
        } else {
            $week = array("CN", "T2", "T3", "T4", "T5", "T6", "T7");
        }
        $w = (int)$datetime->format('w');
        $day_of_week = $week[$w];
        return $day_of_week;
    }
    public function for1($table, $type, $link = '')
    {
        global $d, $lang, $sluglang;
        $sql = "select name$lang, slugvi, slugen, id from #_" . $table . " where find_in_set('hienthi', status) and type='" . $type . "' order by numb, id desc";
        $baiviet = $d->rawQuery($sql);
        $str = '';
        $str .= '<ul>';
        for ($i = 0; $i < count($baiviet); $i++) {
            if ($link == '') {
                $str .= '<li><a href="' . $baiviet[$i][$sluglang] . '">' . htmlspecialchars($baiviet[$i]["name" . $lang]) . '</a>';
            } else {
                $str .= '<li><a href="' . $baiviet[$i]['link'] . '">' . htmlspecialchars($baiviet[$i]["name" . $lang]) . '</a>';
            }
        }
        $str .= '</ul>';
        return $str;
    }
    public function for3cap($table1, $table2, $table3, $type)
    {
        global $d, $lang, $sluglang;
        $sql = "select name$lang, slugvi, slugen, id from #_" . $table1 . " where find_in_set('hienthi', status) and type='" . $type . "' order by numb, id desc";
        $danhmuc_cap1 = $d->rawQuery($sql);
        $str = '';
        $str .= '<ul>';
        for ($i = 0; $i < count($danhmuc_cap1); $i++) {
            $str .= '<li><a href="' . $danhmuc_cap1[$i][$sluglang] . '">' . htmlspecialchars($danhmuc_cap1[$i]["name" . $lang]) . '</a>';
            $sql = "select name$lang, slugvi, slugen, id from #_" . $table2 . " where find_in_set('hienthi', status) and type='" . $type . "' and id_list='" . $danhmuc_cap1[$i]["id"] . "' order by numb, id desc";
            $danhmuc_cap2 = $d->rawQuery($sql);
            if (count($danhmuc_cap2) > 0) {
                $str .= '<ul>';
                for ($j = 0; $j < count($danhmuc_cap2); $j++) {
                    $str .= '<li><a href="' . $danhmuc_cap2[$j][$sluglang] . '">' . htmlspecialchars($danhmuc_cap2[$j]["name" . $lang]) . '</a>';
                    $sql = "select name$lang, slugvi, slugen, id from #_" . $table3 . " where find_in_set('hienthi', status) and type='" . $type . "' and id_cat='" . $danhmuc_cap2[$j]["id"] . "' order by numb, id desc";
                    $danhmuc_cap3 = $d->rawQuery($sql);
                    if (count($danhmuc_cap3) > 0) {
                        $str .= '<ul>';
                        for ($k = 0; $k < count($danhmuc_cap3); $k++) {
                            $str .= '<li><a href="' . $danhmuc_cap3[$k][$sluglang] . '">' . htmlspecialchars($danhmuc_cap3[$k]["name" . $lang]) . '</a>';
                        }
                        $str .= '</ul>';
                    }
                    $str .= '</li>';
                }
                $str .= '</ul>';
            }
            $str .= '</li>';
        }
        $str .= '</ul>';
        return $str;
    }
    public function laymxh($type, $class_css = '', $char_css = '')
    {
        global $config, $lang, $str, $d;
        $social = $d->rawQuery("select name$lang, link, photo, id from #_photo where type = ? and find_in_set('hienthi', status) order by numb, id desc", array($type));
        if (!empty($social)) {
            $str = '<div class="' . $class_css . '">' . $char_css;
            foreach ($social as $key => $value) {
                $str .= '<a href="' . $value['link'] . '"><img src="' . UPLOAD_PHOTO_L . $value['photo'] . '" alt="' . $value['name' . $lang] . '"></a>';
            }
            $str .= '</div>';
        }
        return $str;
    }
    public function humanTiming($time)
    {
        $time = time() - $time;
        $tokens = array(
            31536000 => 'năm',
            2592000 => 'tháng',
            604800 => 'tuần',
            86400 => 'ngày',
            3600 => 'giờ',
            60 => 'phút',
            1 => 'giây'
        );
        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            $text_time = $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? ' trước ' : '');
            return $text_time;
        }
    }
    public function jam_read_num_forvietnamese($num = false)
    {
        $str = '';
        $num  = trim($num);
        $arr = str_split($num);
        $count = count($arr);
        $f = number_format($num);
        if ($count < 7) {
            $str = $num;
        } else {
            $r = explode(',', $f);
            switch (count($r)) {
                case 4:
                    $str = $r[0] . ' tỉ';
                    if ((int) $r[1]) {
                        $str .= ' ' . $r[1] . ' Tr';
                    }
                    break;
                case 3:
                    $str = $r[0] . ' Triệu';
                    if ((int) $r[1]) {
                        $str .= ' ' . $r[1] . 'K';
                    }
                    break;
            }
        }
        return ($str . ' ₫');
    }
    /* Markdown */
    public function markdown($path = '', $params = array())
    {
        $content = '';
        if (!empty($path)) {
            ob_start();
            include dirname(__DIR__) . "/sample/" . $path . ".php";
            $content = ob_get_contents();
            ob_clean();
        }
        return $content;
    }
    /* Check URL */
    public function checkURL($index = false)
    {
        global $configBase;
        $url = '';
        $urls = array('index', 'index.html', 'trang-chu', 'trang-chu.html');
        if (array_key_exists('REDIRECT_URL', $_SERVER)) {
            $url = explode("/", $_SERVER['REDIRECT_URL']);
        } else {
            $url = explode("/", $_SERVER['REQUEST_URI']);
        }
        if (is_array($url)) {
            $url = $url[count($url) - 1];
            if (strpos($url, "?")) {
                $url = explode("?", $url);
                $url = $url[0];
            }
        }
        if ($index) array_push($urls, "index.php");
        else if (array_search('index.php', $urls)) $urls = array_diff($urls, ["index.php"]);
        if (in_array($url, $urls)) $this->redirect($configBase, 301);
    }
    /* Check HTTP */
    public function checkHTTP($http, $arrayDomain, &$configBase, $configUrl)
    {
        if (count($arrayDomain) == 0 && $http == 'https://') {
            $configBase = 'http://' . $configUrl;
        }
    }
    /* Create sitemap */
    public function createSitemap($com = '', $type = '', $field = '', $table = '', $time = '', $changefreq = '', $priority = '', $lang = 'vi', $orderby = '', $menu = true)
    {
        global $configBase;
        $urlSm = '';
        $sitemap = null;
        if (!empty($type) && !in_array($table, ['photo', 'static'])) {
            $where = 'type = ?';
            $where .= ($table != 'static') ? 'order by ' . $orderby . ' desc' : '';
            $sitemap = $this->d->rawQuery("select slug$lang, date_created from #_$table where $where", array($type));
        }
        if ($menu == true && $field == 'id') {
            $urlSm = $configBase . $com;
            echo '<url>';
            echo '<loc>' . $urlSm . '</loc>';
            echo '<lastmod>' . date('c', time()) . '</lastmod>';
            echo '<changefreq>' . $changefreq . '</changefreq>';
            echo '<priority>' . $priority . '</priority>';
            echo '</url>';
        }
        if (!empty($sitemap)) {
            foreach ($sitemap as $value) {
                if (!empty($value['slug' . $lang])) {
                    $urlSm = $configBase . $value['slug' . $lang];
                    echo '<url>';
                    echo '<loc>' . $urlSm . '</loc>';
                    echo '<lastmod>' . date('c', $value['date_created']) . '</lastmod>';
                    echo '<changefreq>' . $changefreq . '</changefreq>';
                    echo '<priority>' . $priority . '</priority>';
                    echo '</url>';
                }
            }
        }
    }
    /* Kiểm tra dữ liệu nhập vào */
    public function cleanInput($input = '', $type = '')
    {
        $output = '';
        if ($input != '') {
            /*
                    // Loại bỏ HTML tags
                    '@<[\/\!]*?[^<>]*?>@si',
                */
            $search = array(
                'script' => '@<script[^>]*?>.*?</script>@si',
                'style' => '@<style[^>]*?>.*?</style>@siU',
                'blank' => '@<![\s\S]*?--[ \t\n\r]*>@',
                'iframe' => '/<iframe(.*?)<\/iframe>/is',
                'title' => '/<title(.*?)<\/title>/is',
                'pre' => '/<pre(.*?)<\/pre>/is',
                'frame' => '/<frame(.*?)<\/frame>/is',
                'frameset' => '/<frameset(.*?)<\/frameset>/is',
                'object' => '/<object(.*?)<\/object>/is',
                'embed' => '/<embed(.*?)<\/embed>/is',
                'applet' => '/<applet(.*?)<\/applet>/is',
                'meta' => '/<meta(.*?)<\/meta>/is',
                'doctype' => '/<!doctype(.*?)>/is',
                'link' => '/<link(.*?)>/is',
                'body' => '/<body(.*?)<\/body>/is',
                'html' => '/<html(.*?)<\/html>/is',
                'head' => '/<head(.*?)<\/head>/is',
                'onclick' => '/onclick="(.*?)"/is',
                'ondbclick' => '/ondbclick="(.*?)"/is',
                'onchange' => '/onchange="(.*?)"/is',
                'onmouseover' => '/onmouseover="(.*?)"/is',
                'onmouseout' => '/onmouseout="(.*?)"/is',
                'onmouseenter' => '/onmouseenter="(.*?)"/is',
                'onmouseleave' => '/onmouseleave="(.*?)"/is',
                'onmousemove' => '/onmousemove="(.*?)"/is',
                'onkeydown' => '/onkeydown="(.*?)"/is',
                'onload' => '/onload="(.*?)"/is',
                'onunload' => '/onunload="(.*?)"/is',
                'onkeyup' => '/onkeyup="(.*?)"/is',
                'onkeypress' => '/onkeypress="(.*?)"/is',
                'onblur' => '/onblur="(.*?)"/is',
                'oncopy' => '/oncopy="(.*?)"/is',
                'oncut' => '/oncut="(.*?)"/is',
                'onpaste' => '/onpaste="(.*?)"/is',
                'php-tag' => '/<(\?|\%)\=?(php)?/',
                'php-short-tag' => '/(\%|\?)>/'
            );
            if (!empty($type)) {
                unset($search[$type]);
            }
            $output = preg_replace($search, '', $input);
        }
        return $output;
    }
    /* Kiểm tra dữ liệu nhập vào */
    public function sanitize($input = '', $type = '')
    {
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = $this->sanitize($val, $type);
            }
        } else {
            $output  = $this->cleanInput($input, $type);
        }
        return $output;
    }
    /* Decode html characters */
    public function decodeHtmlChars($htmlChars)
    {
        return htmlspecialchars_decode($htmlChars ?: '');
    }
    /* Kiểm tra đăng nhập */
    public function checkLoginAdmin()
    {
        global $loginAdmin;
        $token = (!empty($_SESSION[$loginAdmin]['token'])) ? $_SESSION[$loginAdmin]['token'] : '';
        $row = $this->d->rawQuery("select secret_key from #_user where secret_key = ? and find_in_set('hienthi',status)", array($token));
        if (count($row) == 1 && $row[0]['secret_key'] != '') {
            return true;
        } else {
            if (!empty($_SESSION[TOKEN])) unset($_SESSION[TOKEN]);
            unset($_SESSION[$loginAdmin]);
            return false;
        }
    }
    /* Mã hóa mật khẩu admin */
    public function encryptPassword($secret = '', $str = '', $salt = '')
    {
        return md5($secret . $str . $salt);
    }
    /* Kiểm tra phân quyền menu */
    public function checkPermission($com = '', $act = '', $type = '', $array = null, $case = '')
    {
        global $loginAdmin;
        $str = $com;
        if ($act) $str .= '_' . $act;
        if ($case == 'phrase-1') {
            if ($type != '') $str .= '_' . $type;
            if (!in_array($str, $_SESSION[$loginAdmin]['permissions'])) return true;
            else return false;
        } else if ($case == 'phrase-2') {
            $count = 0;
            if ($array) {
                foreach ($array as $key => $value) {
                    if (!empty($value['dropdown'])) {
                        unset($array[$key]);
                    }
                }
                foreach ($array as $key => $value) {
                    if (!in_array($str . "_" . $key, $_SESSION[$loginAdmin]['permissions'])) $count++;
                }
                if ($count == count($array)) return true;
            } else return false;
        }
        return false;
    }
    /* Kiểm tra phân quyền */
    public function checkRole()
    {
        global $config, $loginAdmin;
        if ((!empty($_SESSION[$loginAdmin]['role']) && $_SESSION[$loginAdmin]['role'] == 3) || !empty($config['website']['debug-developer'])) return false;
        else return true;
    }
    /* Lấy tình trạng nhận tin */
    public function getStatusNewsletter($confirm_status = 0, $type = '')
    {
        global $config;
        $loai = '';
        if (!empty($config['newsletter'][$type]['confirm_status'])) {
            foreach ($config['newsletter'][$type]['confirm_status'] as $key => $value) {
                if ($key == $confirm_status) {
                    $loai = $value;
                    break;
                }
            }
        }
        if ($loai == '') $loai = "Đang chờ duyệt...";
        return $loai;
    }
    /* Database maintenance */
    public function databaseMaintenance($action = '', $tables = array())
    {
        $result = array();
        $row = array();
        if (!empty($action) && !empty($tables)) {
            foreach ($tables as $k => $v) {
                foreach ($v as $table) {
                    $result = $this->d->rawQuery("$action TABLE $table");
                    if (!empty($result)) {
                        $row[$k]['table'] = $result[0]['Table'];
                        $row[$k]['action'] = $result[0]['Op'];
                        $row[$k]['type'] = $result[0]['Msg_type'];
                        $row[$k]['text'] = $result[0]['Msg_text'];
                    }
                }
            }
        }
        return $row;
    }
    /* Format money */
    public function formatMoney($price = 0, $unit = 'đ', $html = false)
    {
        $str = '';
        if ($price) {
            $str .= number_format($price, 0, ',', '.');
            if ($unit != '') {
                if ($html) {
                    $str .= '<span>' . $unit . '</span>';
                } else {
                    $str .= $unit;
                }
            }
        }
        return $str;
    }
    /* Is phone */
    public function isPhone($number)
    {
        $number = trim($number);
        if (preg_match_all('/^(0|84)(2(0[3-9]|1[0-6|8|9]|2[0-2|5-9]|3[2-9]|4[0-9]|5[1|2|4-9]|6[0-3|9]|7[0-7]|8[0-9]|9[0-4|6|7|9])|3[2-9]|5[5|6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])([0-9]{7})$/m', $number, $matches, PREG_SET_ORDER, 0)) {
            return true;
        } else {
            return false;
        }
    }
    /* Format phone */
    public function formatPhone($number, $dash = ' ')
    {
        if (preg_match('/^(\d{4})(\d{3})(\d{3})$/', $number, $matches) || preg_match('/^(\d{3})(\d{4})(\d{4})$/', $number, $matches)) {
            return $matches[1] . $dash . $matches[2] . $dash . $matches[3];
        }
    }
    /* Parse phone */
    public function parsePhone($number)
    {
        return (!empty($number)) ? preg_replace('/[^0-9]/', '', $number) : '';
    }
    /* Check letters and nums */
    public function isAlphaNum($str)
    {
        if (preg_match('/^[a-z0-9]+$/', $str)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is email */
    public function isEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is match */
    public function isMatch($value1, $value2)
    {
        if ($value1 == $value2) {
            return true;
        } else {
            return false;
        }
    }
    /* Is decimal */
    public function isDecimal($number)
    {
        if (preg_match('/^\d{1,10}(\.\d{1,4})?$/', $number)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is coordinates */
    public function isCoords($str)
    {
        if (preg_match('/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/', $str)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is url */
    public function isUrl($str)
    {
        if (preg_match('/^(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/', $str)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is url youtube */
    public function isYoutube($str)
    {
        if (preg_match('/https?:\/\/(?:[a-zA_Z]{2,3}.)?(?:youtube\.com\/watch\?)((?:[\w\d\-\_\=]+&amp;(?:amp;)?)*v(?:&lt;[A-Z]+&gt;)?=([0-9a-zA-Z\-\_]+))/i', $str)) {
            return true;
        } else {
            return false;
        }
    }

    /* Is fanpage */
    public function isFanpage($str)
    {
        if (preg_match('/^(https?:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)/', $str)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is date */
    public function isDate($str)
    {
        if (preg_match('/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/', $str)) {
            return true;
        } else {
            return false;
        }
    }
    /* Is date by format */
    public function isDateByFormat($str, $format = 'd/m/Y')
    {
        $dt = DateTime::createFromFormat($format, $str);
        return $dt && $dt->format($format) == $str;
    }
    /* Is number */
    public function isNumber($numbs)
    {
        if (preg_match('/^[0-9]+$/', $numbs)) {
            return true;
        } else {
            return false;
        }
    }
    /* Check account */
    public function checkAccount($data = '', $type = '', $tbl = '', $id = 0)
    {
        $result = false;
        $row = array();
        if (!empty($data) && !empty($type) && !empty($tbl)) {
            $where = (!empty($id)) ? ' and id != ' . $id : '';
            $row = $this->d->rawQueryOne("select id from #_$tbl where $type = ? $where limit 0,1", array($data));
            if (!empty($row)) {
                $result = true;
            }
        }
        return $result;
    }
    /* Check title */
    public function checkTitle($data = array())
    {
        global $config;
        $result = array();
        foreach ($config['website']['lang'] as $k => $v) {
            if (isset($data['name' . $k])) {
                $title = trim($data['name' . $k]);
                if (empty($title)) {
                    $result[] = 'Tiêu đề (' . $v . ') không được trống';
                }
            }
        }
        return $result;
    }
    /* Check slug */
    public function checkSlug($data = array())
    {
        $result = 'valid';
        if (isset($data['slug'])) {
            $slug = trim($data['slug']);
            if (!empty($slug)) {
                $table = array(
                    "#_product_list",
                    "#_product_cat",
                    "#_product_item",
                    "#_product_sub",
                    "#_product_brand",
                    "#_product",
                    "#_news_list",
                    "#_news_cat",
                    "#_news_item",
                    "#_news_sub",
                    "#_news",
                    "#_tags"
                );
                $where = (!empty($data['id']) && empty($data['copy'])) ? "id != " . $data['id'] . " and " : "";
                foreach ($table as $v) {
                    $check = $this->d->rawQueryOne("select id from $v where $where (slugvi = ? or slugen = ?) limit 0,1", array($data['slug'], $data['slug']));
                    if (!empty($check['id'])) {
                        $result = 'exist';
                        break;
                    }
                }
            } else {
                $result = 'empty';
            }
        }
        return $result;
    }
    /* Check recaptcha */
    public function checkRecaptcha($response = '')
    {
        global $config;
        $result = null;
        $active = $config['googleAPI']['recaptcha']['active'];
        if ($active == true && $response != '') {
            $recaptcha = file_get_contents($config['googleAPI']['recaptcha']['urlapi'] . '?secret=' . $config['googleAPI']['recaptcha']['secretkey'] . '&response=' . $response);
            $recaptcha = json_decode($recaptcha);
            $result['score'] = $recaptcha->score;
            $result['action'] = $recaptcha->action;
        } else if (!$active) {
            $result['test'] = true;
        }
        return $result;
    }
    /* Login */
    public function checkLoginMember()
    {
        global $configBase, $loginMember;
        if (!empty($_SESSION[$loginMember]) || !empty($_COOKIE['login_member_id'])) {
            $flag = true;
            $iduser = (!empty($_COOKIE['login_member_id'])) ? $_COOKIE['login_member_id'] : $_SESSION[$loginMember]['id'];
            if ($iduser) {
                $row = $this->d->rawQueryOne("select login_session, id, username, phone, address, email, fullname from #_member where id = ? and find_in_set('hienthi',status)", array($iduser));
                if (!empty($row['id'])) {
                    $login_session = (!empty($_COOKIE['login_member_session'])) ? $_COOKIE['login_member_session'] : $_SESSION[$loginMember]['login_session'];
                    if ($login_session == $row['login_session']) {
                        $_SESSION[$loginMember]['active'] = true;
                        $_SESSION[$loginMember]['id'] = $row['id'];
                        $_SESSION[$loginMember]['username'] = $row['username'];
                        $_SESSION[$loginMember]['phone'] = $row['phone'];
                        $_SESSION[$loginMember]['address'] = $row['address'];
                        $_SESSION[$loginMember]['email'] = $row['email'];
                        $_SESSION[$loginMember]['fullname'] = $row['fullname'];
                    } else $flag = false;
                } else $flag = false;
                if (!$flag) {
                    unset($_SESSION[$loginMember]);
                    setcookie('login_member_id', "", -1, '/');
                    setcookie('login_member_session', "", -1, '/');
                    $this->transfer("Tài khoản của bạn đã hết hạn đăng nhập hoặc đã đăng nhập trên thiết bị khác", $configBase, false);
                }
            }
        }
    }
    /* Lấy youtube */
    public function getYoutube($url = '')
    {
        if ($url != '') {
            $parts = parse_url($url);
            if (isset($parts['query'])) {
                parse_str($parts['query'], $qs);
                if (isset($qs['v'])) return $qs['v'];
                else if ($qs['vi']) return $qs['vi'];
            }
            if (isset($parts['path'])) {
                $path = explode('/', trim($parts['path'], '/'));
                return $path[count($path) - 1];
            }
        }
        return false;
    }
    /* Get image */
    public function getImage($data = array())
    {
        global $config;
        /* Defaults */
        $defaults = [
            'class' => '', //lazy
            'id' => '',
            'isLazy' => true,
            'thumbs' => THUMBS,
            'isWatermark' => false,
            'watermark' => (defined('WATERMARK')) ? WATERMARK : '',
            'prefix' => '',
            'size-error' => '',
            'size-src' => '',
            'sizes' => '',
            'url' => '',
            'upload' => '',
            'image' => '',
            'upload-error' => 'assets/images/',
            'image-error' => 'noimage.png',
            'alt' => '',
            'style' => ''
        ];
        /* Data */
        $info = array_merge($defaults, $data);
        /* Upload - Image */
        if (empty($info['upload']) || empty($info['image'])) {
            $info['upload'] = $info['upload-error'];
            $info['image'] = $info['image-error'];
        }
        /* Size */
        if (!empty($info['sizes'])) {
            $info['size-error'] = $info['size-src'] = $info['sizes'];
        }
        /* Path origin */
        $info['pathOrigin'] = $info['upload'] . $info['image'];
        /* Path src */
        if (!empty($info['url'])) {
            $info['pathSrc'] = $info['url'];
        } else {
            if (!empty($info['size-src'])) {
                $info['pathSize'] = $info['size-src'] . "/" . $info['upload'] . $info['image'];
                $info['pathSrc'] = (!empty($info['isWatermark']) && !empty($info['prefix'])) ? ASSET . $info['watermark'] . "/" . $info['prefix'] . "/" . $info['pathSize'] : ASSET . $info['thumbs'] . "/" . $info['pathSize'];
            } else {
                $info['pathSrc'] = ASSET . $info['pathOrigin'];
            }
        }
        /* Path error */
        $info['pathError'] = ASSET . $info['thumbs'] . "/" . $info['size-error'] . "/" . $info['upload-error'] . $info['image-error'];
        /* Class */
        $info['class'] = (empty($info['isLazy'])) ? str_replace('lazy', '', $info['class']) : $info['class'];
        $info['class'] = (!empty($info['class'])) ? "class='" . $info['class'] . "'" : "";
        /* Id */
        $info['id'] = (!empty($info['id'])) ? "id='" . $info['id'] . "'" : "";
        /* Check to convert Webp */
        $info['hasURL'] = false;
        if (filter_var(str_replace(ASSET, "", $info['pathSrc']), FILTER_VALIDATE_URL)) {
            $info['hasURL'] = true;
        }
        // if ($config['website']['image']['hasWebp']) {
        //     if (!$info['sizes']) {
        //         if (!$info['hasURL']) {
        //             $this->converWebp($info['pathSrc']);
        //         }
        //     }
        //     if (!$info['hasURL']) {
        //         $info['pathSrc'] .= '.webp';
        //     }
        // }
        /* Src */
        $info['src'] = (!empty($info['isLazy']) && strpos($info['class'], 'lazy') !== false) ? "data-src='" . $info['pathSrc'] . "'" : "src='" . $info['pathSrc'] . "'";
        /* Image */
        $result = "<img " . $info['class'] . " " . $info['id'] . " onerror=\"this.src='" . $info['pathError'] . "';\" " . $info['src'] . " alt='" . $info['alt'] . "' style='" . $info['style'] . "'/>";
        return $result;
    }
    /* Get list gallery */
    public function listsGallery($file = '')
    {
        $result = array();
        if (!empty($file) && !empty($_POST['fileuploader-list-' . $file])) {
            $fileLists = '';
            $fileLists = str_replace('"', '', $_POST['fileuploader-list-' . $file]);
            $fileLists = str_replace('[', '', $fileLists);
            $fileLists = str_replace(']', '', $fileLists);
            $fileLists = str_replace('{', '', $fileLists);
            $fileLists = str_replace('}', '', $fileLists);
            $fileLists = str_replace('0:/', '', $fileLists);
            $fileLists = str_replace('file:', '', $fileLists);
            $result = explode(',', $fileLists);
        }
        return $result;
    }
    /* Template gallery */
    public function galleryFiler($numb = 1, $id = 0, $photo = '', $name = '', $folder = '', $col = '')
    {
        /* Params */
        $params = array();
        $params['numb'] = $numb;
        $params['id'] = $id;
        $params['photo'] = $photo;
        $params['name'] = $name;
        $params['folder'] = $folder;
        $params['col'] = $col;
        /* Get markdown */
        $str = $this->markdown('gallery/admin', $params);
        return $str;
    }
    /* Delete gallery */
    public function deleteGallery()
    {
        $row = $this->d->rawQuery("select id, com, photo from #_gallery where hash != '' and date_created < " . (time() - 3 * 3600));
        $array = array("product" => UPLOAD_PRODUCT, "news" => UPLOAD_NEWS);
        if ($row) {
            foreach ($row as $item) {
                @unlink($array[$item['com']] . $item['photo']);
                $this->d->rawQuery("delete from #_gallery where id = " . $item['id']);
            }
        }
    }
    /* Generate hash */
    public function generateHash()
    {
        if (!$this->hash) {
            $this->hash = $this->stringRandom(10);
        }
        return $this->hash;
    }
    /* Lấy date */
    public function makeDate($time = 0, $dot = '.', $lang = 'vi', $f = false)
    {
        $str = ($lang == 'vi') ? date("d{$dot}m{$dot}Y", $time) : date("m{$dot}d{$dot}Y", $time);
        if ($f == true) {
            $thu['vi'] = array('Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy');
            $thu['en'] = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
            $str = $thu[$lang][date('w', $time)] . ', ' . $str;
        }
        return $str;
    }
    /* Alert */
    public function alert($notify = '')
    {
        echo '<script language="javascript">alert("' . $notify . '")</script>';
    }
    /* Delete file */
    public function deleteFile($file = '')
    {
        return @unlink($file);
    }
    /* Transfer */
    public function transfer($msg = '', $page = '', $numb = true)
    {
        global $configBase;
        $basehref = $configBase;
        $showtext = $msg;
        $page_transfer = $page;
        $numb = $numb;
        include("./templates/layout/transfer.php");
        exit();
    }
    /* Redirect */
    public function redirect($url = '', $response = null)
    {
        header("location:$url", true, $response);
        exit();
    }
    /* Dump */
    public function dump($value = '', $exit = false)
    {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
        if ($exit) exit();
    }
    /* Pagination */
    public function pagination($totalq = 0, $perPage = 10, $page = 1, $url = '?')
    {
        $urlpos = strpos($url, "?");
        $url = ($urlpos) ? $url . "&" : $url . "?";
        $total = $totalq;
        $adjacents = "2";
        $firstlabel = "First";
        $prevlabel = "Prev";
        $nextlabel = "Next";
        $lastlabel = "Last";
        $page = ($page == 0 ? 1 : $page);
        $start = ($page - 1) * $perPage;
        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil($total / $perPage);
        $lpm1 = $lastpage - 1;
        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination flex-wrap justify-content-center mb-0'>";
            $pagination .= "<li class='page-item'><a class='page-link'>Page {$page} / {$lastpage}</a></li>";
            if ($page > 1) {
                $pagination .= "<li class='page-item'><a class='page-link' href='{$this->getCurrentPageURL()}'>{$firstlabel}</a></li>";
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p={$prev}'>{$prevlabel}</a></li>";
            }
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                    else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p={$counter}'>{$counter}</a></li>";
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p={$counter}'>{$counter}</a></li>";
                    }
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p=1'>...</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p={$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p={$lastpage}'>{$lastpage}</a></li>";
                } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p=1'>1</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p=2'>2</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p=1'>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p={$counter}'>{$counter}</a></li>";
                    }
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p=1'>...</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p={$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p={$lastpage}'>{$lastpage}</a></li>";
                } else {
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p=1'>1</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p=2'>2</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p=1'>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p={$counter}'>{$counter}</a></li>";
                    }
                }
            }
            if ($page < $counter - 1) {
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p={$next}'>{$nextlabel}</a></li>";
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}p=$lastpage'>{$lastlabel}</a></li>";
            }
            $pagination .= "</ul>";
        }
        return $pagination;
    }
    /* UTF8 convert */
    public function utf8Convert($str = '')
    {
        if ($str != '') {
            $utf8 = array(
                'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
                'd' => 'đ|Đ',
                'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
                'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
                'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
                'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
                'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
                '' => '`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\“|\”|\:|\;|_',
            );
            foreach ($utf8 as $ascii => $uni) {
                $str = preg_replace("/($uni)/i", $ascii, $str);
            }
        }
        return $str;
    }
    /* Change title */
    public function changeTitle($text = '')
    {
        if ($text != '') {
            $text = strtolower($this->utf8Convert($text));
            $text = preg_replace("/[^a-z0-9-\s]/", "", $text);
            $text = preg_replace('/([\s]+)/', '-', $text);
            $text = str_replace(array('%20', ' '), '-', $text);
            $text = preg_replace("/\-\-\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-/", "-", $text);
            $text = '@' . $text . '@';
            $text = preg_replace('/\@\-|\-\@|\@/', '', $text);
        }
        return $text;
    }
    /* Lấy IP */
    public function getRealIPAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    /* Lấy getPageURL */
    public function getPageURL()
    {
        $pageURL = 'http';
        if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") $pageURL .= "s";
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        return $pageURL;
    }
    /* Lấy getCurrentPageURL */
    public function getCurrentPageURL()
    {
        $pageURL = 'http';
        if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") $pageURL .= "s";
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        $urlpos = strpos($pageURL, "?p");
        $pageURL = ($urlpos) ? explode("?p=", $pageURL) : explode("&p=", $pageURL);
        return $pageURL[0];
    }
    /* Lấy getCurrentPageURL Cano */
    public function getCurrentPageURL_CANO()
    {
        $pageURL = 'http';
        if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") $pageURL .= "s";
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        $pageURL = str_replace("amp/", "", $pageURL);
        $urlpos = strpos($pageURL, "?p");
        $pageURL = ($urlpos) ? explode("?p=", $pageURL) : explode("&p=", $pageURL);
        $pageURL = explode("?", $pageURL[0]);
        $pageURL = explode("#", $pageURL[0]);
        $pageURL = explode("index", $pageURL[0]);
        return $pageURL[0];
    }
    /* Has file */
    public function hasFile($file)
    {
        if (isset($_FILES[$file])) {
            if ($_FILES[$file]['error'] == 4) {
                return false;
            } else if ($_FILES[$file]['error'] == 0) {
                return true;
            }
        } else {
            return false;
        }
    }
    /* Size file */
    public function sizeFile($file)
    {
        if ($this->hasFile($file)) {
            if ($_FILES[$file]['error'] == 0) {
                return $_FILES[$file]['size'];
            }
        } else {
            return 0;
        }
    }
    function isAjaxRequest()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            return true;
        return false;
    }
    public function check($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    /* Check file */
    public function checkFile($file)
    {
        global $config;
        $result = true;
        if ($this->hasFile($file)) {
            if ($this->sizeFile($file) > $config['website']['video']['max-size']) {
                $result = false;
            }
        }
        return $result;
    }
    /* Check extension file */
    public function checkExtFile($file)
    {
        global $config;
        $result = true;
        if ($this->hasFile($file)) {
            $ext = $this->infoPath($_FILES[$file]["name"], 'extension');
            if (!in_array($ext, $config['website']['video']['extension'])) {
                $result = false;
            }
        }
        return $result;
    }
    /* Info path */
    public function infoPath($filename = '', $type = '')
    {
        $result = '';
        if (!empty($filename) && !empty($type)) {
            if ($type == 'extension') {
                $result = pathinfo($filename, PATHINFO_EXTENSION);
            } else if ($type == 'filename') {
                $result = pathinfo($filename, PATHINFO_FILENAME);
            }
        }
        return $result;
    }
    /* Format bytes */
    public function formatBytes($size, $precision = 2)
    {
        $result = array();
        $base = log($size, 1024);
        $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');
        $result['numb'] = round(pow(1024, $base - floor($base)), $precision);
        $result['ext'] = $suffixes[floor($base)];
        return $result;
    }
    /* Copy image */
    public function copyImg($photo = '', $constant = '')
    {
        $str = '';
        if ($photo != '' && $constant != '') {
            $rand = rand(1000, 9999);
            $name = pathinfo($photo, PATHINFO_FILENAME);
            $ext = pathinfo($photo, PATHINFO_EXTENSION);
            $photo_new = $name . '-' . $rand . '.' . $ext;
            $oldpath = '../../upload/' . $constant . '/' . $photo;
            $newpath = '../../upload/' . $constant . '/' . $photo_new;
            if (file_exists($oldpath)) {
                if (copy($oldpath, $newpath)) {
                    $str = $photo_new;
                }
            }
        }
        return $str;
    }
    /* Get Img size */
    public function getImgSize($photo = '', $patch = '')
    {
        $array = array();
        if ($photo != '') {
            $x = (file_exists($patch)) ? getimagesize($patch) : null;
            $array = (!empty($x)) ? array("p" => $photo, "w" => $x[0], "h" => $x[1], "m" => $x['mime']) : null;
        }
        return $array;
    }
    /* Upload name */
    public function uploadName($name = '')
    {
        $result = '';
        if ($name != '') {
            $rand = rand(1000, 9999);
            $ten_anh = pathinfo($name, PATHINFO_FILENAME);
            $result = $this->changeTitle($ten_anh) . "-" . $rand;
        }
        return $result;
    }
    /* Resize images */
    public function smartResizeImage($file = '', $string = null, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false, $quality = 100, $grayscale = false)
    {
        if ($height <= 0 && $width <= 0) return false;
        if ($file === null && $string === null) return false;
        $info = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
        $image = '';
        $final_width = 0;
        $final_height = 0;
        list($width_old, $height_old) = $info;
        $cropHeight = $cropWidth = 0;
        if ($proportional) {
            if ($width == 0) $factor = $height / $height_old;
            elseif ($height == 0) $factor = $width / $width_old;
            else $factor = min($width / $width_old, $height / $height_old);
            $final_width = round($width_old * $factor);
            $final_height = round($height_old * $factor);
        } else {
            $final_width = ($width <= 0) ? $width_old : $width;
            $final_height = ($height <= 0) ? $height_old : $height;
            $widthX = $width_old / $width;
            $heightX = $height_old / $height;
            $x = min($widthX, $heightX);
            $cropWidth = ($width_old - $width * $x) / 2;
            $cropHeight = ($height_old - $height * $x) / 2;
        }
        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);
                break;
            case IMAGETYPE_GIF:
                $file !== null ? $image = imagecreatefromgif($file) : $image = imagecreatefromstring($string);
                break;
            case IMAGETYPE_PNG:
                $file !== null ? $image = imagecreatefrompng($file) : $image = imagecreatefromstring($string);
                break;
            default:
                return false;
        }
        if ($grayscale) {
            imagefilter($image, IMG_FILTER_GRAYSCALE);
        }
        $image_resized = imagecreatetruecolor($final_width, $final_height);
        if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
            $transparency = imagecolortransparent($image);
            $palletsize = imagecolorstotal($image);
            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparent_color = imagecolorsforindex($image, $transparency);
                $transparency = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            } elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }
        imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
        if ($delete_original) {
            if ($use_linux_commands) exec('rm ' . $file);
            else @unlink($file);
        }
        switch (strtolower($output)) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = $file;
                break;
            case 'return':
                return $image_resized;
                break;
            default:
                break;
        }
        switch ($info[2]) {
            case IMAGETYPE_GIF:
                imagegif($image_resized, $output);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($image_resized, $output, $quality);
                break;
            case IMAGETYPE_PNG:
                $quality = 9 - (int)((0.9 * $quality) / 10.0);
                imagepng($image_resized, $output, $quality);
                break;
            default:
                return false;
        }
        return true;
    }
    /* Correct images orientation */
    public function correctImageOrientation($filename)
    {
        ini_set('memory_limit', '1024M');
        if (function_exists('exif_read_data')) {
            $exif = @exif_read_data($filename);
            if ($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                if ($orientation != 1) {
                    $img = imagecreatefromjpeg($filename);
                    $deg = 0;
                    switch ($orientation) {
                        case 3:
                            $image = imagerotate($img, 180, 0);
                            break;
                        case 6:
                            $image = imagerotate($img, -90, 0);
                            break;
                        case 8:
                            $image = imagerotate($img, 90, 0);
                            break;
                    }
                    imagejpeg($image, $filename, 90);
                }
            }
        }
    }
    /* Upload images */
    public function uploadImage($file = '', $extension = '', $folder = '', $newname = '')
    {
        global $config;
        if (isset($_FILES[$file]) && !$_FILES[$file]['error']) {
            $postMaxSize = ini_get('post_max_size');
            $MaxSize = explode('M', $postMaxSize);
            $MaxSize = $MaxSize[0];
            if ($_FILES[$file]['size'] > $MaxSize * 1048576) {
                $this->alert('Dung lượng file không được vượt quá ' . $postMaxSize);
                return false;
            }
            $ext = explode('.', $_FILES[$file]['name']);
            $ext = strtolower($ext[count($ext) - 1]);
            $name = basename($_FILES[$file]['name'], '.' . $ext);
            if (strpos($extension, $ext) === false) {
                $this->alert('Chỉ hỗ trợ upload file dạng ' . $extension);
                return false;
            }
            if ($newname == '' && file_exists($folder . $_FILES[$file]['name']))
                for ($i = 0; $i < 100; $i++) {
                    if (!file_exists($folder . $name . $i . '.' . $ext)) {
                        $_FILES[$file]['name'] = $name . $i . '.' . $ext;
                        break;
                    }
                }
            else {
                $_FILES[$file]['name'] = $newname . '.' . $ext;
            }
            if (!copy($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                if (!move_uploaded_file($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                    return false;
                }
            }
            /* Fix correct Image Orientation */
            $this->correctImageOrientation($folder . $_FILES[$file]['name']);
            /* Resize image if width origin > config max width */
            $array = getimagesize($folder . $_FILES[$file]['name']);
            list($image_w, $image_h) = $array;
            $maxWidth = $config['website']['upload']['max-width'];
            $maxHeight = $config['website']['upload']['max-height'];
            if ($image_w > $maxWidth) $this->smartResizeImage($folder . $_FILES[$file]['name'], null, $maxWidth, $maxHeight, true);
            return $_FILES[$file]['name'];
        }
        return false;
    }
    /* Delete folder */
    public function removeDir($dirname = '')
    {
        if (is_dir($dirname)) $dir_handle = opendir($dirname);
        if (!isset($dir_handle) || $dir_handle == false) return false;
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file)) unlink($dirname . "/" . $file);
                else $this->removeDir($dirname . '/' . $file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }
    /* Remove Sub folder */
    public function RemoveEmptySubFolders($path = '')
    {
        $empty = true;
        foreach (glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
            if (is_dir($file)) {
                if (!$this->RemoveEmptySubFolders($file)) $empty = false;
            } else {
                $empty = false;
            }
        }
        if ($empty) {
            if (is_dir($path)) {
                rmdir($path);
            }
        }
        return $empty;
    }
    /* Remove files from dir in x seconds */
    public function RemoveFilesFromDirInXSeconds($dir = '', $seconds = 3600)
    {
        $files = glob(rtrim($dir, '/') . "/*");
        $now = time();
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    if ($now - filemtime($file) >= $seconds) {
                        unlink($file);
                    }
                } else {
                    $this->RemoveFilesFromDirInXSeconds($file, $seconds);
                }
            }
        }
    }
    /* Remove zero bytes */
    public function removeZeroByte($dir)
    {
        $files = glob(rtrim($dir, '/') . "/*");
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    if (!filesize($file)) {
                        unlink($file);
                    }
                } else {
                    $this->removeZeroByte($file);
                }
            }
        }
    }
    /* Filter opacity */
    public function filterOpacity($img = '', $opacity = 80)
    {
        return true;
        /*
            if(!isset($opacity) || $img == '') return false;
            $opacity /= 100;
            $w = imagesx($img);
            $h = imagesy($img);
            imagealphablending($img, false);
            $minalpha = 127;
            for($x = 0; $x < $w; $x++)
            {
                for($y = 0; $y < $h; $y++)
                {
                    $alpha = (imagecolorat($img, $x, $y) >> 24) & 0xFF;
                    if($alpha < $minalpha) $minalpha = $alpha;
                }
            }
            for($x = 0; $x < $w; $x++)
            {
                for($y = 0; $y < $h; $y++)
                {
                    $colorxy = imagecolorat($img, $x, $y);
                    $alpha = ($colorxy >> 24) & 0xFF;
                    if($minalpha !== 127) $alpha = 127 + 127 * $opacity * ($alpha - 127) / (127 - $minalpha);
                    else $alpha += 127 * $opacity;
                    $alphacolorxy = imagecolorallocatealpha($img, ($colorxy >> 16) & 0xFF, ($colorxy >> 8) & 0xFF, $colorxy & 0xFF, $alpha);
                    if(!imagesetpixel($img, $x, $y, $alphacolorxy)) return false;
                }
            }
            return true;
            */
    }
    /* Convert Webp */
    /*public function converWebp($in)
    {
        global $config;
        $in = $_SERVER['DOCUMENT_ROOT'] . $config['database']['url'] . str_replace(ASSET, "", $in);
        if (!extension_loaded('imagick')) {
            ob_start();
            WebPConvert::serveConverted($in, $in . ".webp", [
                'fail' => 'original',
                //'show-report' => true,
                'serve-image' => [
                    'headers' => [
                        'cache-control' => true,
                        'vary-accept' => true,
                    ],
                    'cache-control-header' => 'max-age=2',
                ],
                'convert' => [
                    "quality" => 100
                ]
            ]);
            file_put_contents($in . ".webp", ob_get_contents());
            ob_end_clean();
        } else {
            WebPConvert::convert($in, $in . ".webp", [
                'fail' => 'original',
                'convert' => [
                    'quality' => 100,
                    'max-quality' => 100,
                ]
            ]);
        }
    }*/
    /* Create thumb */
    public function createThumb($width_thumb = 0, $height_thumb = 0, $zoom_crop = '1', $src = '', $watermark = null, $path = THUMBS, $preview = false, $args = array(), $quality = 100)
    {
        global $config;
        $webp = false;
        $t = 3600 * 24 * 30;
        if (strpos($src, ".webp") !== false) {
            $webp = true;
            $src = str_replace(".webp", "", $src);
        }
        $this->RemoveFilesFromDirInXSeconds(UPLOAD_TEMP_L, 1);
        if ($watermark != null) {
            $this->RemoveFilesFromDirInXSeconds(WATERMARK . '/' . $path . "/", $t);
            $this->RemoveEmptySubFolders(WATERMARK . '/' . $path . "/");
        } else {
            $this->RemoveFilesFromDirInXSeconds($path . "/", $t);
            $this->RemoveEmptySubFolders($path . "/");
        }
        $src = str_replace("%20", " ", $src);
        if (!file_exists($src)) die("NO IMAGE $src");
        $image_url = $src;
        $origin_x = 0;
        $origin_y = 0;
        $new_width = $width_thumb;
        $new_height = $height_thumb;
        if ($new_width < 10 && $new_height < 10) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            die("Width and height larger than 10px");
        }
        if ($new_width > 2000 || $new_height > 2000) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            die("Width and height less than 2000px");
        }
        $array = getimagesize($image_url);
        if ($array) list($image_w, $image_h) = $array;
        else die("NO IMAGE $image_url");
        $width = $image_w;
        $height = $image_h;
        if ($new_height && !$new_width) $new_width = $width * ($new_height / $height);
        else if ($new_width && !$new_height) $new_height = $height * ($new_width / $width);
        $image_ext = explode('.', $image_url);
        $image_ext = trim(strtolower(end($image_ext)));
        $image_name = explode('/', $image_url);
        $image_name = trim(basename($image_url), "/");
        switch ($array['mime']) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($image_url);
                $func = 'imagejpeg';
                $mime_type = 'jpeg';
                break;
            case 'image/x-ms-bmp':
            case 'image/png':
                $image = @imagecreatefrompng($image_url);
                $func = 'imagepng';
                $mime_type = 'png';
                break;
            case 'image/gif':
                $image = imagecreatefromgif($image_url);
                $func = 'imagegif';
                $mime_type = 'png';
                break;
            default:
                die("UNKNOWN IMAGE TYPE: $image_url");
        }
        $_new_width = $new_width;
        $_new_height = $new_height;
        if ($zoom_crop == 3) {
            $final_height = $height * ($new_width / $width);
            if ($final_height > $new_height) $new_width = $width * ($new_height / $height);
            else $new_height = $final_height;
        }
        $canvas = imagecreatetruecolor(intval($new_width), intval($new_height));
        imagealphablending($canvas, false);
        $color = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
        imagefill($canvas, 0, 0, $color);
        if ($zoom_crop == 2) {
            $final_height = $height * ($new_width / $width);
            if ($final_height > $new_height) {
                $origin_x = $new_width / 2;
                $new_width = $width * ($new_height / $height);
                $origin_x = round($origin_x - ($new_width / 2));
            } else {
                $origin_y = $new_height / 2;
                $new_height = $final_height;
                $origin_y = round($origin_y - ($new_height / 2));
            }
        }
        imagesavealpha($canvas, true);
        if ($zoom_crop > 0) {
            $align = '';
            $src_x = $src_y = 0;
            $src_w = $width;
            $src_h = $height;
            $cmp_x = $width / $new_width;
            $cmp_y = $height / $new_height;
            if ($cmp_x > $cmp_y) {
                $src_w = round($width / $cmp_x * $cmp_y);
                $src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
            } else if ($cmp_y > $cmp_x) {
                $src_h = round($height / $cmp_y * $cmp_x);
                $src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
            }
            if ($align) {
                if (strpos($align, 't') !== false) {
                    $src_y = 0;
                }
                if (strpos($align, 'b') !== false) {
                    $src_y = $height - $src_h;
                }
                if (strpos($align, 'l') !== false) {
                    $src_x = 0;
                }
                if (strpos($align, 'r') !== false) {
                    $src_x = $width - $src_w;
                }
            }
            imagecopyresampled($canvas, $image, intval($origin_x), intval($origin_y), intval($src_x), intval($src_y), intval($new_width), intval($new_height), intval($src_w), intval($src_h));
        } else {
            imagecopyresampled($canvas, $image, 0, 0, 0, 0, intval($new_width), intval($new_height), intval($width), intval($height));
        }
        if ($preview) {
            $watermark = array();
            $watermark['status'] = 'hienthi';
            $options = $args;
            $overlay_url = $args['watermark'];
        }
        $upload_dir = '';
        $folder_old = dirname($image_url) . '/';
        if (!empty($watermark['status']) && strpos('hienthi', $watermark['status']) !== false) {
            $upload_dir = WATERMARK . '/' . $path . '/' . $width_thumb . 'x' . $height_thumb . 'x' . $zoom_crop . '/' . $folder_old;
        } else {
            if ($watermark != null) $upload_dir = WATERMARK . '/' . $path . '/' . $width_thumb . 'x' . $height_thumb . 'x' . $zoom_crop . '/' . $folder_old;
            else $upload_dir = $path . '/' . $width_thumb . 'x' . $height_thumb . 'x' . $zoom_crop . '/' . $folder_old;
        }
        if (!file_exists($upload_dir)) if (!mkdir($upload_dir, 0777, true)) die('Failed to create folders...');
        if (!empty($watermark['status']) && strpos('hienthi', $watermark['status']) !== false) {
            $options = (isset($options)) ? $options : json_decode($watermark['options'], true)['watermark'];
            $per_scale = $options['per'];
            $per_small_scale = $options['small_per'];
            $max_width_w = $options['max'];
            $min_width_w = $options['min'];
            $opacity = @$options['opacity'];
            $overlay_url = (isset($overlay_url)) ? $overlay_url : UPLOAD_PHOTO_L . $watermark['photo'];
            $overlay_ext = explode('.', $overlay_url);
            $overlay_ext = trim(strtolower(end($overlay_ext)));
            switch (strtoupper($overlay_ext)) {
                case 'JPG':
                case 'JPEG':
                    $overlay_image = imagecreatefromjpeg($overlay_url);
                    break;
                case 'PNG':
                    $overlay_image = imagecreatefrompng($overlay_url);
                    break;
                case 'GIF':
                    $overlay_image = imagecreatefromgif($overlay_url);
                    break;
                default:
                    die("UNKNOWN IMAGE TYPE: $overlay_url");
            }
            $this->filterOpacity($overlay_image, $opacity);
            $overlay_width = imagesx($overlay_image);
            $overlay_height = imagesy($overlay_image);
            $overlay_padding = 5;
            imagealphablending($canvas, true);
            if (min($_new_width, $_new_height) <= 300) $per_scale = $per_small_scale;
            $oz = max($overlay_width, $overlay_height);
            if ($overlay_width > $overlay_height) {
                $scale = $_new_width / $oz;
            } else {
                $scale = $_new_height / $oz;
            }
            if ($_new_height > $_new_width) {
                $scale = $_new_height / $oz;
            }
            $new_overlay_width = (floor($overlay_width * $scale) - $overlay_padding * 2) / $per_scale;
            $new_overlay_height = (floor($overlay_height * $scale) - $overlay_padding * 2) / $per_scale;
            $scale_w = $new_overlay_height > 0 ? $new_overlay_width / $new_overlay_height : 0;
            $scale_h = $new_overlay_width > 0 ? $new_overlay_height / $new_overlay_width : 0;
            $new_overlay_height = $scale_w > 0 ? $new_overlay_width / $scale_w : 0;
            if ($new_overlay_height > $_new_height) {
                $new_overlay_height = $_new_height / $per_scale;
                $new_overlay_width = $new_overlay_height * $scale_w;
            }
            if ($new_overlay_width > $_new_width) {
                $new_overlay_width = $_new_width / $per_scale;
                $new_overlay_height = $new_overlay_width * $scale_h;
            }
            if ($new_overlay_width > 0 && ($_new_width / $new_overlay_width) < $per_scale) {
                $new_overlay_width = $_new_width / $per_scale;
                $new_overlay_height = $new_overlay_width * $scale_h;
            }
            if ($_new_height < $_new_width && ($new_overlay_height > 0 && ($_new_height / $new_overlay_height) < $per_scale)) {
                $new_overlay_height = $_new_height / $per_scale;
                $new_overlay_width = $new_overlay_height / $scale_h;
            }
            if ($new_overlay_width > $max_width_w && $new_overlay_width) {
                $new_overlay_width = $max_width_w;
                $new_overlay_height = $new_overlay_width * $scale_h;
            }
            if ($new_overlay_width < $min_width_w && $_new_width <= $min_width_w * 3) {
                $new_overlay_width = $min_width_w;
                $new_overlay_height = $new_overlay_width * $scale_h;
            }
            $new_overlay_width = round($new_overlay_width);
            $new_overlay_height = round($new_overlay_height);
            switch ($options['position']) {
                case 1:
                    $khoancachx = $overlay_padding;
                    $khoancachy = $overlay_padding;
                    break;
                case 2:
                    $khoancachx = abs($_new_width - $new_overlay_width) / 2;
                    $khoancachy = $overlay_padding;
                    break;
                case 3:
                    $khoancachx = abs($_new_width - $new_overlay_width) - $overlay_padding;
                    $khoancachy = $overlay_padding;
                    break;
                case 4:
                    $khoancachx = abs($_new_width - $new_overlay_width) - $overlay_padding;
                    $khoancachy = abs($_new_height - $new_overlay_height) / 2;
                    break;
                case 5:
                    $khoancachx = abs($_new_width - $new_overlay_width) - $overlay_padding;
                    $khoancachy = abs($_new_height - $new_overlay_height) - $overlay_padding;
                    break;
                case 6:
                    $khoancachx = abs($_new_width - $new_overlay_width) / 2;
                    $khoancachy = abs($_new_height - $new_overlay_height) - $overlay_padding;
                    break;
                case 7:
                    $khoancachx = $overlay_padding;
                    $khoancachy = abs($_new_height - $new_overlay_height) - $overlay_padding;
                    break;
                case 8:
                    $khoancachx = $overlay_padding;
                    $khoancachy = abs($_new_height - $new_overlay_height) / 2;
                    break;
                case 9:
                    $khoancachx = abs($_new_width - $new_overlay_width) / 2;
                    $khoancachy = abs($_new_height - $new_overlay_height) / 2;
                    break;
                default:
                    $khoancachx = $overlay_padding;
                    $khoancachy = $overlay_padding;
                    break;
            }
            $new_overlay_width = $new_overlay_width > 0 ? $new_overlay_width : 1;
            $new_overlay_height = $new_overlay_height > 0 ? $new_overlay_height : 1;
            $overlay_new_image = imagecreatetruecolor($new_overlay_width, $new_overlay_height);
            imagealphablending($overlay_new_image, false);
            imagesavealpha($overlay_new_image, true);
            imagecopyresampled($overlay_new_image, $overlay_image, 0, 0, 0, 0, $new_overlay_width, $new_overlay_height, $overlay_width, $overlay_height);
            imagecopy($canvas, $overlay_new_image, $khoancachx, $khoancachy, 0, 0, $new_overlay_width, $new_overlay_height);
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
        }
        if ($preview) {
            $upload_dir = '';
            $this->RemoveEmptySubFolders(WATERMARK . '/' . $path . "/");
        }
        if ($upload_dir) {
            if (!isset($_GET['preview'])) {
                if ($func == 'imagejpeg') $func($canvas, $upload_dir . $image_name, 100);
                else $func($canvas, $upload_dir . $image_name, floor($quality * 0.09));
            }
            $this->removeZeroByte($path);
        }
        header('Content-Type: image/' . $mime_type);
        if ($func == 'imagejpeg') $func($canvas, NULL, 100);
        else $func($canvas, NULL, floor($quality * 0.09));
        imagedestroy($canvas);
        // if ($config['website']['image']['hasWebp'] && ($webp || !$preview)) {
        //     $this->converWebp($upload_dir . $image_name);
        // }
        exit;
    }
    /* String random */
    public function stringRandom($sokytu = 10)
    {
        $str = '';
        if ($sokytu > 0) {
            $chuoi = 'ABCDEFGHIJKLMNOPQRSTUVWXYZWabcdefghijklmnopqrstuvwxyzw0123456789';
            for ($i = 0; $i < $sokytu; $i++) {
                $vitri = mt_rand(0, strlen($chuoi));
                $str = $str . substr($chuoi, $vitri, 1);
            }
        }
        return $str;
    }
    /* Digital random */
    public function digitalRandom($min = 1, $max = 10, $num = 10)
    {
        $result = '';
        if ($num > 0) {
            for ($i = 0; $i < $num; $i++) {
                $result .= rand($min, $max);
            }
        }
        return $result;
    }
    /* Get permission */
    public function getPermission($id_permission = 0)
    {
        $row = $this->cache->get("select * from #_permission_group where find_in_set('hienthi',status) order by numb,id desc", null, "result", 7200);
        $str = '<select id="id_permission" name="data[id_permission]" class="form-control select2"><option value="0">Nhóm quyền</option>';
        foreach ($row as $v) {
            if ($v["id"] == (int)@$id_permission) $selected = "selected";
            else $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Get status order */
    public function orderStatus($status = 0)
    {
        $row = $this->cache->get("select * from #_order_status order by id", null, "result", 7200);
        $str = '<select id="order_status" name="data[order_status]" class="form-control custom-select text-sm"><option value="0">Chọn tình trạng</option>';
        foreach ($row as $v) {
            if (isset($_REQUEST['order_status']) && ($v["id"] == (int)$_REQUEST['order_status']) || ($v["id"] == $status)) $selected = "selected";
            else $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["namevi"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Lấy thông tin chi tiết */
    public function getInfoDetail($cols = '', $table = '', $id = 0)
    {
        $row = array();
        if (!empty($cols) && !empty($table) && !empty($id)) {
            $row = $this->cache->get("select $cols from #_$table where id = ? limit 0,1", array($id), "fetch", 7200);
        }
        return $row;
    }
    /* Join column */
    public function joinCols($array = null, $column = null)
    {
        $str = '';
        $arrayTemp = array();
        if ($array && $column) {
            foreach ($array as $k => $v) {
                if (!empty($v[$column])) {
                    $arrayTemp[] = $v[$column];
                }
            }
            if (!empty($arrayTemp)) {
                $arrayTemp = array_unique($arrayTemp);
                $str = implode(",", $arrayTemp);
            }
        }
        return $str;
    }
    /* Get payments order */
    function orderPayments()
    {
        $row = $this->cache->get("select * from #_news where type='hinh-thuc-thanh-toan' order by numb,id desc", null, "result", 7200);
        $str = '<select id="order_payment" name="order_payment" class="form-control custom-select text-sm"><option value="0">Chọn hình thức thanh toán</option>';
        foreach ($row as $v) {
            if (isset($_REQUEST['order_payment']) && ($v["id"] == (int)$_REQUEST['order_payment'])) $selected = "selected";
            else $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["namevi"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Get color */
    public function getColor($id = 0)
    {
        global $type;
        if ($id) {
            $temps = $this->d->rawQuery("select id_color from #_product_sale where id_parent = ?", array($id));
            $temps = (!empty($temps)) ? $this->joinCols($temps, 'id_color') : array();
            $temps = (!empty($temps)) ? explode(",", $temps) : array();
        }
        $row_color = $this->d->rawQuery("select namevi, id from #_color where type = ? order by numb,id desc", array($type));
        $str = '<select id="dataColor" name="dataColor[]" class="select multiselect" multiple="multiple" >';
        for ($i = 0; $i < count($row_color); $i++) {
            if (!empty($temps)) {
                if (in_array($row_color[$i]['id'], $temps)) $selected = 'selected="selected"';
                else $selected = '';
            } else {
                $selected = '';
            }
            $str .= '<option value="' . $row_color[$i]["id"] . '" ' . $selected . ' /> ' . $row_color[$i]["namevi"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Get size */
    public function getSize($id = 0)
    {
        global $type;
        if ($id) {
            $temps = $this->d->rawQuery("select id_size from #_product_sale where id_parent = ?", array($id));
            $temps = (!empty($temps)) ? $this->joinCols($temps, 'id_size') : array();
            $temps = (!empty($temps)) ? explode(",", $temps) : array();
        }
        $row_size = $this->d->rawQuery("select namevi, id from #_size where type = ? order by numb,id desc", array($type));
        $str = '<select id="dataSize" name="dataSize[]" class="select multiselect" multiple="multiple" >';
        for ($i = 0; $i < count($row_size); $i++) {
            if (!empty($temps)) {
                if (in_array($row_size[$i]['id'], $temps)) $selected = 'selected="selected"';
                else $selected = '';
            } else {
                $selected = '';
            }
            $str .= '<option value="' . $row_size[$i]["id"] . '" ' . $selected . ' /> ' . $row_size[$i]["namevi"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    public function getColorSale($id = 0)
    {
        global $type;

        if ($id) {
            $temps = $this->d->rawQuery("select id_color from #_product_sale_color where id_parent = ?", array($id));
            $temps = (!empty($temps)) ? $this->joinCols($temps, 'id_color') : array();
            $temps = (!empty($temps)) ? explode(",", $temps) : array();
        }

        $row_color = $this->d->rawQuery("select namevi, id from #_color where type = ? order by numb,id desc", array($type));

        $str = '<select id="dataColor" name="dataColor[]" class="select multiselect" multiple="multiple" >';
        for ($i = 0; $i < count($row_color); $i++) {
            if (!empty($temps)) {
                if (in_array($row_color[$i]['id'], $temps)) $selected = 'selected="selected"';
                else $selected = '';
            } else {
                $selected = '';
            }
            $str .= '<option value="' . $row_color[$i]["id"] . '" ' . $selected . ' /> ' . $row_color[$i]["namevi"] . '</option>';
        }
        $str .= '</select>';

        return $str;
    }

    /* Get size */
    public function getSizeSale($id = 0)
    {
        global $type;

        if ($id) {
            $temps = $this->d->rawQuery("select id_size from #_product_sale_size where id_parent = ?", array($id));
            $temps = (!empty($temps)) ? $this->joinCols($temps, 'id_size') : array();
            $temps = (!empty($temps)) ? explode(",", $temps) : array();
        }

        $row_size = $this->d->rawQuery("select namevi, id from #_size where type = ? order by numb,id desc", array($type));

        $str = '<select id="dataSize" name="dataSize[]" class="select multiselect" multiple="multiple" >';
        for ($i = 0; $i < count($row_size); $i++) {
            if (!empty($temps)) {
                if (in_array($row_size[$i]['id'], $temps)) $selected = 'selected="selected"';
                else $selected = '';
            } else {
                $selected = '';
            }
            $str .= '<option value="' . $row_size[$i]["id"] . '" ' . $selected . ' /> ' . $row_size[$i]["namevi"] . '</option>';
        }
        $str .= '</select>';

        return $str;
    }
    /* Get tags */
    public function getTags($id = 0, $element = '', $table = '', $type = '')
    {
        if ($id) {
            $temps = $this->d->rawQuery("select id_tags from #_" . $table . " where id_parent = ?", array($id));
            $temps = (!empty($temps)) ? $this->joinCols($temps, 'id_tags') : array();
            $temps = (!empty($temps)) ? explode(",", $temps) : array();
        }
        $row_tags = $this->cache->get("select namevi, id from #_tags where type = ? order by numb,id desc", array($type), "result", 7200);
        $str = '<select id="' . $element . '" name="' . $element . '[]" class="select multiselect" multiple="multiple" >';
        for ($i = 0; $i < count($row_tags); $i++) {
            if (!empty($temps)) {
                if (in_array($row_tags[$i]['id'], $temps)) $selected = 'selected="selected"';
                else $selected = '';
            } else {
                $selected = '';
            }
            $str .= '<option value="' . $row_tags[$i]["id"] . '" ' . $selected . ' /> ' . $row_tags[$i]["namevi"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Get category by ajax */
    public function getAjaxCategory($table = '', $level = '', $type = '', $title_select = 'Chọn danh mục', $class_select = 'select-category')
    {
        $where = '';
        $params = array($type);
        $id_parent = 'id_' . $level;
        $data_level = '';
        $data_type = 'data-type="' . $type . '"';
        $data_table = '';
        $data_child = '';
        if ($level == 'list') {
            $data_level = 'data-level="0"';
            $data_table = 'data-table="#_' . $table . '_cat"';
            $data_child = 'data-child="id_cat"';
        } else if ($level == 'cat') {
            $data_level = 'data-level="1"';
            $data_table = 'data-table="#_' . $table . '_item"';
            $data_child = 'data-child="id_item"';
            $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            $where .= ' and id_list = ?';
            array_push($params, $idlist);
        } else if ($level == 'item') {
            $data_level = 'data-level="2"';
            $data_table = 'data-table="#_' . $table . '_sub"';
            $data_child = 'data-child="id_sub"';
            $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            $where .= ' and id_list = ?';
            array_push($params, $idlist);
            $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
            $where .= ' and id_cat = ?';
            array_push($params, $idcat);
        } else if ($level == 'sub') {
            $data_level = '';
            $data_type = '';
            $class_select = '';
            $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            $where .= ' and id_list = ?';
            array_push($params, $idlist);
            $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
            $where .= ' and id_cat = ?';
            array_push($params, $idcat);
            $iditem = (isset($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;
            $where .= ' and id_item = ?';
            array_push($params, $iditem);
        } else if ($level == 'brand') {
            $data_level = '';
            $data_type = '';
            $class_select = '';
        }
        $rows = $this->cache->get("select namevi, id from #_" . $table . "_" . $level . " where type = ? " . $where . " order by numb,id desc", $params, "result", 7200);
        $str = '<select id="' . $id_parent . '" name="data[' . $id_parent . ']" ' . $data_level . ' ' . $data_type . ' ' . $data_table . ' ' . $data_child . ' class="form-control select2 ' . $class_select . '"><option value="0">' . $title_select . '</option>';
        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int)$_REQUEST[$id_parent])) $selected = "selected";
            else $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["namevi"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Get category by link */
    public function getLinkCategory($table = '', $level = '', $type = '', $title_select = 'Chọn danh mục')
    {
        $where = '';
        $params = array($type);
        $id_parent = 'id_' . $level;
        if ($level == 'cat') {
            $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            $where .= ' and id_list = ?';
            array_push($params, $idlist);
        } else if ($level == 'item') {
            $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            $where .= ' and id_list = ?';
            array_push($params, $idlist);
            $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
            $where .= ' and id_cat = ?';
            array_push($params, $idcat);
        } else if ($level == 'sub') {
            $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            $where .= ' and id_list = ?';
            array_push($params, $idlist);
            $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
            $where .= ' and id_cat = ?';
            array_push($params, $idcat);
            $iditem = (isset($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;
            $where .= ' and id_item = ?';
            array_push($params, $iditem);
        }
        $rows = $this->cache->get("select namevi, id from #_" . $table . "_" . $level . " where type = ? " . $where . " order by numb,id desc", $params, "result", 7200);
        $str = '<select id="' . $id_parent . '" name="' . $id_parent . '" onchange="onchangeCategory($(this))" class="form-control filter-category select2"><option value="0">' . $title_select . '</option>';
        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int)$_REQUEST[$id_parent])) $selected = "selected";
            else $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["namevi"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Get place by ajax */
    public function getAjaxPlace($table = '', $title_select = 'Chọn danh mục')
    {
        $where = '';
        $params = array('0');
        $id_parent = 'id_' . $table;
        $data_level = '';
        $data_table = '';
        $data_child = '';
        if ($table == 'city') {
            $data_level = 'data-level="0"';
            $data_table = 'data-table="#_district"';
            $data_child = 'data-child="id_district"';
        } else if ($table == 'district') {
            $data_level = 'data-level="1"';
            $data_table = 'data-table="#_ward"';
            $data_child = 'data-child="id_ward"';
            $idcity = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
            $where .= ' and id_city = ?';
            array_push($params, $idcity);
        } else if ($table == 'ward') {
            $data_level = '';
            $data_table = '';
            $data_child = '';
            $idcity = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
            $where .= ' and id_city = ?';
            array_push($params, $idcity);
            $iddistrict = (isset($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;
            $where .= ' and id_district = ?';
            array_push($params, $iddistrict);
        }
        $rows = $this->cache->get("select name, id from #_" . $table . " where id <> ? " . $where . " order by id asc", $params, "result", 7200);
        $str = '<select id="' . $id_parent . '" name="data[' . $id_parent . ']" ' . $data_level . ' ' . $data_table . ' ' . $data_child . ' class="form-control select2 select-place"><option value="0">' . $title_select . '</option>';
        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int)$_REQUEST[$id_parent])) $selected = "selected";
            else $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Get place by link */
    public function getLinkPlace($table = '', $title_select = 'Chọn danh mục')
    {
        $where = '';
        $params = array('0');
        $id_parent = 'id_' . $table;
        if ($table == 'district') {
            $idcity = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
            $where .= ' and id_city = ?';
            array_push($params, $idcity);
        } else if ($table == 'ward') {
            $idcity = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
            $where .= ' and id_city = ?';
            array_push($params, $idcity);
            $iddistrict = (isset($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;
            $where .= ' and id_district = ?';
            array_push($params, $iddistrict);
        }
        $rows = $this->cache->get("select name, id from #_" . $table . " where id <> ? " . $where . " order by id asc", $params, "result", 7200);
        $str = '<select id="' . $id_parent . '" name="' . $id_parent . '" onchange="onchangeCategory($(this))" class="form-control filter-category select2"><option value="0">' . $title_select . '</option>';
        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int)$_REQUEST[$id_parent])) $selected = "selected";
            else $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';
        return $str;
    }
    /* Build Schema */
    public function buildSchemaProduct($id_pro, $name, $image, $description, $code_pro, $name_brand, $name_author, $url, $price = 0)
    {
        $str = '{';
        $str .= '"@context": "https://schema.org/",';
        $str .= '"@type": "Product",';
        $str .= '"name": "' . $name . '",';
        $str .= '"image":';
        $str .= '[';
        foreach ($image as $k => $v) {
            $str .= '{';
            $str .= '"@context": "https://schema.org/",';
            $str .= '"@type": "ImageObject",';
            $str .= '"contentUrl": "' . $v . '",';
            $str .= '"url": "' . $v . '",';
            $str .= '"license": "' . $url . '",';
            $str .= '"acquireLicensePage": "' . $url . '",';
            $str .= '"creditText": "' . $name . '",';
            $str .= '"copyrightNotice": "' . $name_author . '",';
            $str .= '"creator":';
            $str .= '{';
            $str .= '"@type": "Organization",';
            $str .= '"name": "' . $name_author . '"';
            $str .= '}';
            $str .= '}' . (($k < count($image) - 1) ? ',' : '') . '';
        }
        $str .= '],';
        $str .= '"description": "' . $description . '",';
        $str .= '"sku":"SP0' . $id_pro . '",';
        $str .= '"mpn": "' . $code_pro . '",';
        $str .= '"brand":';
        $str .= '{';
        $str .= '"@type": "Brand",';
        $str .= '"name": "' . $name_brand . '"';
        $str .= '},';
        $str .= '"review":';
        $str .= '{';
        $str .= '"@type": "Review",';
        $str .= '"reviewRating":';
        $str .= '{';
        $str .= '"@type": "Rating",';
        $str .= '"ratingValue": "5",';
        $str .= '"bestRating": "5"';
        $str .= '},';
        $str .= '"author":';
        $str .= '{';
        $str .= '"@type": "Person",';
        $str .= '"name": "' . $name_author . '"';
        $str .= '}';
        $str .= '},';
        $str .= '"aggregateRating":';
        $str .= '{';
        $str .= '"@type": "AggregateRating",';
        $str .= '"ratingValue": "4.4",';
        $str .= '"reviewCount": "89"';
        $str .= '},';
        $str .= '"offers":';
        $str .= '{';
        $str .= '"@type": "Offer",';
        $str .= '"url": "' . $url . '",';
        $str .= '"priceCurrency": "VND",';
        $str .= '"priceValidUntil": "2099-11-20",';
        $str .= '"price": "' . $price . '",';
        $str .= '"itemCondition": "https://schema.org/NewCondition",';
        $str .= '"availability": "https://schema.org/InStock"';
        $str .= '}';
        $str .= '}';

        $str = json_encode(json_decode($str), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return $str;
    }
    /* Build Schema */
    public function buildSchemaArticle($id_news = 0, $name = '', $image = '', $ngaytao = '', $ngaysua = '', $name_author = '', $url = '', $logo = '', $url_author = '')
    {
        $str = '{';
        $str .= '"@context": "https://schema.org",';
        $str .= '"@type": "NewsArticle",';
        $str .= '"mainEntityOfPage": ';
        $str .= '{';
        $str .= '"@type": "WebPage",';
        $str .= '"@id": "' . $url . '"';
        $str .= '},';
        $str .= '"headline": "' . $name . '",';
        $str .= '"image":"' . $image . '",';
        $str .= '"datePublished": "' . date('c', $ngaytao) . '",';
        $str .= '"dateModified": "' . date('c', $ngaysua) . '",';
        $str .= '"author":';
        $str .= '{';
        $str .= '"@type": "Person",';
        $str .= '"name": "' . $name_author . '",';
        $str .= '"url": "' . $url_author . '"';
        $str .= '},';
        $str .= '"publisher": ';
        $str .= '{';
        $str .= '"@type": "Organization",';
        $str .= '"name": "' . $name_author . '",';
        $str .= '"logo": ';
        $str .= '{';
        $str .= '"@type": "ImageObject",';
        $str .= '"url": "' . $logo . '"';
        $str .= '}';
        $str .= '}';
        $str .= '}';
        $str = json_encode(json_decode($str), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $str;
    }

    //**************************************** function them --------------------------------*/
    /*check err*/
    function err()
    {
        global $d;
        echo '<pre>';
        print_r($d->getLastError());
        echo '<pre>';
        exit();
    }
    /* menu */
    public function formenu($table, $type, $showh2 = 1)
    {
        global $config_base, $lang, $sluglang;
        $sqlc1 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_list WHERE find_in_set('hienthi',status) AND type ='" . $type . "' ORDER BY numb,id DESC";
        $arr_sqlc1 = array();
        $danhmuc_cap1 = $this->d->rawQuery($sqlc1, $arr_sqlc1);

        if ($showh2 == 1) {
            $start_h2 = '';
            $end_h2 = '';
        } else {
            $start_h2 = '';
            $end_h2 = '';
        }

        $str = '';
        $str .= '<ul>';
        for ($i = 0; $i < count($danhmuc_cap1); $i++) {
            $str .= '<li><a class="has-child transition" href="' . $danhmuc_cap1[$i][$sluglang] . '">' . $start_h2 . $danhmuc_cap1[$i]["ten"] . $end_h2 . '</a>';

            $sqlc2 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_cat WHERE find_in_set('hienthi',status) AND type ='" . $type . "' and id_list = " . $danhmuc_cap1[$i]["id"] . " ORDER BY numb,id DESC";
            $arr_sqlc2 = array();
            $danhmuc_cap2 = $this->d->rawQuery($sqlc2, $arr_sqlc2);

            if (count($danhmuc_cap2) > 0) {
                $str .= '<ul>';
                for ($j = 0; $j < count($danhmuc_cap2); $j++) {
                    $str .= '<li><a class="has-child transition" href="' . $danhmuc_cap2[$j][$sluglang] . '">' . $start_h2 . $danhmuc_cap2[$j]["ten"] . $end_h2 . '</a>';

                    $sqlc3 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_item WHERE find_in_set('hienthi',status) AND type ='" . $type . "' and id_cat = " . $danhmuc_cap2[$j]["id"] . " ORDER BY numb,id DESC";
                    $arr_sqlc3 = array();
                    $danhmuc_cap3 = $this->d->rawQuery($sqlc3, $arr_sqlc3);

                    if (count($danhmuc_cap3) > 0) {
                        $str .= '<ul>';
                        for ($k = 0; $k < count($danhmuc_cap3); $k++) {

                            $sqlc4 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_sub WHERE find_in_set('hienthi',status) AND type ='" . $type . "' and id_item = " . $danhmuc_cap3[$k]["id"] . " ORDER BY numb,id DESC";
                            $arr_sqlc4 = array();
                            $danhmuc_cap4 = $this->d->rawQuery($sqlc4, $arr_sqlc4);

                            $str .= '<li><a class="has-child transition" href="' . $danhmuc_cap3[$k][$sluglang] . '">' . $start_h2 . $danhmuc_cap3[$k]["ten"] . $end_h2 . '</a>';
                            if (count($danhmuc_cap4) > 0) {
                                $str .= '<ul>';
                                for ($h = 0; $h < count($danhmuc_cap4); $h++) {

                                    $str .= '<li><a class="has-child transition" href="' . $danhmuc_cap4[$h][$sluglang] . '">' . $start_h2 . $danhmuc_cap4[$h]["ten"] . $end_h2 . '</a>';
                                }
                                $str .= '</ul>';
                            }
                        }
                        $str .= '</ul>';
                    }
                    $str .= '</li>';
                }
                $str .= '</ul>';
            }
            $str .= '</li>';
        }
        $str .= '</ul>';
        return $str;
    }
    /* menu */
    public function formenu_left($table, $type)
    {
        global $config_base, $lang, $sluglang, $id_cap1, $id_cap2;
        $sqlc1 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_list WHERE find_in_set('hienthi',status) AND type ='" . $type . "' ORDER BY numb,id DESC";
        $arr_sqlc1 = array();
        $danhmuc_cap1 = $this->d->rawQuery($sqlc1, $arr_sqlc1);

        $str = '';
        $str .= '<ul>';
        for ($i = 0; $i < count($danhmuc_cap1); $i++) {

            $sqlc2 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_cat WHERE find_in_set('hienthi',status) AND type ='" . $type . "' and id_list = " . $danhmuc_cap1[$i]["id"] . " ORDER BY numb,id DESC";
            $arr_sqlc2 = array();
            $danhmuc_cap2 = $this->d->rawQuery($sqlc2, $arr_sqlc2);
            if (count($danhmuc_cap2) > 0) $showsp1 = '<span></span>';
            else $showsp1 = '';

            if ($danhmuc_cap1[$i]["id"] == $id_cap1) {

                $actsp1 = 'active';
                $showsp1 = '<span class="active"></span>';
                $showulc2 = 'show-ul-c2';
            } else {
                $actsp1 = '';
                $showulc2 = '';
            }

            $str .= '<li>' . $showsp1 . '<a href="' . $danhmuc_cap1[$i][$sluglang] . '" class="' . $actsp1 . '">' . $danhmuc_cap1[$i]["ten"] . '</a>';

            if (count($danhmuc_cap2) > 0) {
                $str .= '<ul class="' . $showulc2 . '">';
                for ($j = 0; $j < count($danhmuc_cap2); $j++) {

                    $sqlc3 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_item WHERE find_in_set('hienthi',status) AND type ='" . $type . "' and id_cat = " . $danhmuc_cap2[$j]["id"] . " ORDER BY numb,id DESC";
                    $arr_sqlc3 = array();
                    $danhmuc_cap3 = $this->d->rawQuery($sqlc3, $arr_sqlc3);

                    if (count($danhmuc_cap3) > 0) $showsp2 = '<span></span>';
                    else $showsp2 = '';

                    if ($danhmuc_cap2[$j]["id"] == $id_cap2) {

                        $actsp2 = 'active';
                    } else {
                        $actsp2 = '';
                    }

                    $str .= '<li>' . $showsp2 . '<a href="' . $danhmuc_cap2[$j][$sluglang] . '" class="' . $actsp2 . '">' . $danhmuc_cap2[$j]["ten"] . '</a>';

                    if (count($danhmuc_cap3) > 0) {
                        $str .= '<ul>';
                        for ($k = 0; $k < count($danhmuc_cap3); $k++) {

                            $sqlc4 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_sub WHERE find_in_set('hienthi',status) AND type ='" . $type . "' and id_item = " . $danhmuc_cap3[$k]["id"] . " ORDER BY numb,id DESC";
                            $arr_sqlc4 = array();
                            $danhmuc_cap4 = $this->d->rawQuery($sqlc4, $arr_sqlc4);

                            if (count($danhmuc_cap4) > 0) $showsp3 = '<span></span>';
                            else $showsp3 = '';
                            $str .= '<li>' . $showsp3 . '<a href="' . $danhmuc_cap3[$k][$sluglang] . '">' . $danhmuc_cap3[$k]["ten"] . '</a>';
                            if (count($danhmuc_cap4) > 0) {
                                $str .= '<ul>';
                                for ($h = 0; $h < count($danhmuc_cap4); $h++) {

                                    $str .= '<li><span></span><a href="' . $danhmuc_cap4[$h][$sluglang] . '">' . $danhmuc_cap4[$h]["ten"] . '</a>';
                                }
                                $str .= '</ul>';
                            }
                        }
                        $str .= '</ul>';
                    }
                    $str .= '</li>';
                }
                $str .= '</ul>';
            }
            $str .= '</li>';
        }
        $str .= '</ul>';
        return $str;
    }
    public function formenubv($table, $type)
    {
        global $config_base, $lang, $sluglang;
        $sqlc1 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . " WHERE find_in_set('hienthi',status) AND type ='" . $type . "' ORDER BY numb,id DESC";
        $arr_sqlc1 = array();
        $danhmuc_cap1 = $this->d->rawQuery($sqlc1, $arr_sqlc1);

        $str = '';
        $str .= '<ul>';
        for ($i = 0; $i < count($danhmuc_cap1); $i++) {
            $str .= '<li><span></span><a href="' . $danhmuc_cap1[$i][$sluglang] . '">' . $danhmuc_cap1[$i]["ten"] . '</a></li>';
        }
        $str .= '</ul>';
        return $str;
    }

    public function formenu_lv1($table, $type, $showh2 = 1)

    {

        global $lang, $sluglang, $active_lv1;

        $sqlc1 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_list WHERE find_in_set('hienthi',status) and find_in_set('dieuhuong',status) and type ='" . $type . "' ORDER BY numb,id DESC limit 0,2";

        $arr_sqlc1 = array();

        $danhmuc_cap1 = $this->d->rawQuery($sqlc1, $arr_sqlc1);



        if ($showh2 == 1) {

            $start_h2 = '';

            $end_h2 = '';
        } else {

            $start_h2 = '';

            $end_h2 = '';
        }



        $str = '';

        // $str.='<ul>';

        for ($i = 0; $i < count($danhmuc_cap1); $i++) {

            //has-child

            $str .= '<li><span></span><a class="';

            if ($danhmuc_cap1[$i]["id"] == $active_lv1) {

                $str .= 'active';
            }

            $str .= ' has-child transition" href="' . $danhmuc_cap1[$i][$sluglang] . '">' . $start_h2 . $danhmuc_cap1[$i]["ten"] . $end_h2 . '</a>';



            $sqlc2 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_cat WHERE find_in_set('hienthi',status) AND type ='" . $type . "' and id_list = " . $danhmuc_cap1[$i]["id"] . " ORDER BY numb,id DESC";

            $arr_sqlc2 = array();

            $danhmuc_cap2 = $this->d->rawQuery($sqlc2, $arr_sqlc2);



            if (count($danhmuc_cap2) > 0) {

                $str .= '<ul>';

                for ($j = 0; $j < count($danhmuc_cap2); $j++) {

                    $str .= '<li><span></span><a class="has-child transition" href="' . $danhmuc_cap2[$j][$sluglang] . '">' . $start_h2 . $danhmuc_cap2[$j]["ten"] . $end_h2 . '</a>';



                    $sqlc3 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_item WHERE find_in_set('hienthi',status) AND type ='" . $type . "' and id_cat = " . $danhmuc_cap2[$j]["id"] . " ORDER BY numb,id DESC";

                    $arr_sqlc3 = array();

                    $danhmuc_cap3 = $this->d->rawQuery($sqlc3, $arr_sqlc3);



                    if (count($danhmuc_cap3) > 0) {

                        $str .= '<ul>';

                        for ($k = 0; $k < count($danhmuc_cap3); $k++) {



                            $sqlc4 = "SELECT name$lang as ten, slugvi, slugen, id FROM table_" . $table . "_sub WHERE find_in_set('hienthi',status) AND type ='" . $type . "' and id_item = " . $danhmuc_cap3[$k]["id"] . " ORDER BY numb,id DESC";

                            $arr_sqlc4 = array();

                            $danhmuc_cap4 = $this->d->rawQuery($sqlc4, $arr_sqlc4);



                            $str .= '<li><span></span><a class="has-child transition" href="' . $danhmuc_cap3[$k][$sluglang] . '">' . $start_h2 . $danhmuc_cap3[$k]["ten"] . $end_h2 . '</a>';

                            if (count($danhmuc_cap4) > 0) {

                                $str .= '<ul>';

                                for ($h = 0; $h < count($danhmuc_cap4); $h++) {



                                    $str .= '<li><span></span><a class="has-child transition" href="' . $danhmuc_cap4[$h][$sluglang] . '">' . $start_h2 . $danhmuc_cap4[$h]["ten"] . $end_h2 . '</a>';
                                }

                                $str .= '</ul>';
                            }
                        }

                        $str .= '</ul>';
                    }

                    $str .= '</li>';
                }

                $str .= '</ul>';
            }

            $str .= '</li>';
        }

        // $str.='</ul>';       

        return $str;
    }

    /*--- Lấy baiviet ----*/
    function lay_cap1($truyvan, $cssitem, $thumb)
    {
        global $lang, $sluglang;
        foreach ($truyvan as $k => $v) { ?>
            <a class="<?= $cssitem ?> text-decoration-none w-clear" href="<?= $v[$sluglang] ?>" title="<?= $v['name' . $lang] ?>">
                <p class="pic-news scale-img"><img onerror="this.src='<?= $thumb ?>assets/images/noimage.png';" src="<?= $thumb ?><?= UPLOAD_PRODUCT_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>"></p>
                <div class="info-news">
                    <h3 class="name-news"><?= $v['name' . $lang] ?></h3>
                </div>
            </a>
        <?php }
    }
    /* Get Product Item */
    public function GetProducts($arr = array(), $class = '', $isLazy = true, $thumbsp = '')
    {
        global $lang, $sluglang, $optsetting;
        $sqlbrand = "SELECT id, name$lang, slugvi, slugen FROM  table_product_brand WHERE find_in_set('hienthi',status) AND type ='san-pham' AND id = ?";

        $strpro = '';
        if ($class != '') {
            $strpro .= '<div class="' . $class . '">';
        }
        foreach ($arr as $k => $v) {
            $arr_id_brand = array($v['id_brand']);
            $namebrand = $this->d->rawQueryOne($sqlbrand, $arr_id_brand);

            $strpro .= '<div class="product">';
            if (FAVORITEPRODUCT == true) {
                $strpro .= '<a class="save-listing" data-id="' . $v['id'] . '"><i class="far fa-heart"></i></a>';
            }
            $strpro .= '<div class="box-product"><a class="text-decoration-none" href="' . $v[$sluglang] . '" title="' . $v['name' . $lang] . '">
                        <div class="pic-product">';
                            if(!empty($v['photo2'])){
                                $strpro .= '<p class="mb-0 display-2img">
                                    <span class="w-100 first-img scale-img">
                                        ' . $this->getImage(['sizes' =>  $thumbsp, 'isWatermark' => WATERMARKPRODUCT, 'prefix' => 'product', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang], 'isLazy' => $isLazy]) . '
                                    </span>
                                    <span class="w-100 second-img scale-img">
                                    '. $this->getImage(['sizes' =>  $thumbsp, 'isWatermark' => WATERMARKPRODUCT, 'prefix' => 'product', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo2'], 'alt' => $v['name' . $lang], 'isLazy' => $isLazy]) .'
                                    </span>';
                                $strpro .= '</p>';
                            } else {
                                $strpro .= '<p class="mb-0 scale-img">
                                ' . $this->getImage(['sizes' =>  $thumbsp, 'isWatermark' => WATERMARKPRODUCT, 'prefix' => 'product', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang], 'isLazy' => $isLazy]) . '
                                </p>';
                            }    
            $strpro .='</div>
            </a>';
            if (SHOWBRAND == true) {
                $strpro .= '<a href="' . $namebrand[$sluglang] . '" class="text-decoration-none info-brand"><span>' . $namebrand['name' . $lang] . '</span></a>';
            }
            $strpro .= '<a class="text-decoration-none" href="' . $v[$sluglang] . '" title="' . $v['name' . $lang] . '">
                    <div class = "info-product">
                    <h3 class="name-product text-split">' . $v['name' . $lang] . '</h3>';
            if (OPENDESC == true) $strpro .= '<div class="desc-product text-split">' . $v['desc' . $lang] . '</div>';
            $strpro .= ' <p class="price-product">
                            <span class="price-title">'. gia .': </span>';
            if ($v['sale_price'] > 0 && $v['regular_price'] > 0) {
                $strpro .= '<span class="price-new">' . $this->formatMoney($v['sale_price']) . '</span>
                            <span class="price-old">' . $this->formatMoney($v['regular_price']) . '</span>
                            <span class="price-per">' . '-' . round(100 - ($v['sale_price'] / $v['regular_price'] * 100)) . '%' . '</span>';
            } else {
                if ($v['regular_price'] > 0) $giapro = $this->formatMoney($v['regular_price']);
                else $giapro = lienhe; //'<b>'.lienhe.'</b>: '.$optsetting['hotline']
                $strpro .= '<span class="price-new">' . $giapro . '</span>';
            }
            $strpro .= '</p></div>
                </a></div>';
            if (CARTSITE == true) {
                $strpro .= '<div class="cart-product w-clear">
                    <span class="btn btn-sm btn-success cart-add addcart mr-2" data-id="' . $v['id'] . '" data-action="addnow"><i class="fa-sharp fa-regular fa-cart-plus mr-1"></i>Thêm vào giỏ hàng</span>
                    <span class="btn btn-sm btn-danger cart-buy addcart" data-id="' . $v['id'] . '" data-action="buynow"><i class="fa-sharp fa-regular fa-cash-register mr-1"></i>Mua ngay</span>
                </div>';
                /*$strpro .= '<div class="cart-product w-clear">';
                if ($v['regular_price'] > 0) {
                    $strpro .= '<span class="btn btn-sm btn-success cart-add addcart" data-id="' . $v['id'] . '" data-action="addnow"><i class="fa-sharp fa-regular fa-cart-plus mr-1"></i>Thêm vào giỏ hàng</span>';
                    $strpro .= '<span class="btn btn-sm btn-danger cart-buy addcart" data-id="' . $v['id'] . '" data-action="buynow"><i class="fa-sharp fa-regular fa-cash-register mr-1"></i>Mua ngay</span>';
                } else {
                    $strpro .= '<span class="btn btn-sm btn-success btn-alert"><i class="fa-sharp fa-regular fa-cart-plus mr-1"></i>Thêm vào giỏ hàng</span>';
                    $strpro .= '<span class="btn btn-sm btn-danger btn-alert2"><i class="fa-sharp fa-regular fa-cash-register mr-1"></i>Mua ngay</span>';
                }
                $strpro .= '</div>';*/
            }
            $strpro .= '</div>';
        }
        if ($class != '') {
            $strpro .= '</div>';
        }
        return $strpro;
    }
    public function GetProducts2($arr = array(), $class = '', $isLazy = true, $thumbsp = '')
    {
        global $lang, $sluglang, $optsetting;

        $sqlbrand = "SELECT id, name$lang, slugvi, slugen FROM  table_product_brand WHERE find_in_set('hienthi',status) AND type ='san-pham' AND id = ?";

        $strpro = '';

        if ($class != '') {
            $strpro .= '<div class="' . $class . '">';
        }
        foreach ($arr as $k => $v) {
            $arr_id_brand = array($v['id_brand']);
            $namebrand = $this->d->rawQueryOne($sqlbrand, $arr_id_brand);

            $strpro .= '<div class="product">';
            if (FAVORITEPRODUCT == true) {
                $strpro .= '<a href="#" class="save-listing" data-id="' . $v['id'] . '"><i class="far fa-heart"></i></a>';
            }
            $strpro .= ' <a class="ico-eye xemnhanh" data-id="' . $v['id'] . '"><i class="fas fa-eye"></i></a>';
            $strpro .= '<div class="box-product"><a class="text-decoration-none" href="' . $v[$sluglang] . '" title="' . $v['name' . $lang] . '">
            <p class="pic-product scale-img">
                ' . $this->getImage(['sizes' =>  $thumbsp, 'isWatermark' => WATERMARKPRODUCT, 'prefix' => 'product', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang], 'isLazy' => $isLazy]) . '
            </p>
            </a>';
            if (SHOWBRAND == true) {
                $strpro .= '<a href="' . $namebrand[$sluglang] . '" class="text-decoration-none info-brand"><span>' . $namebrand['name' . $lang] . '</span></a>';
            }
            $strpro .= '<a class="text-decoration-none" href="' . $v[$sluglang] . '" title="' . $v['name' . $lang] . '">
        <div class = "info-product">
        <h3 class="name-product text-split">' . $v['name' . $lang] . '</h3>';
            if (OPENDESC == true) $strpro .= '<div class="desc-product text-split">' . $v['desc' . $lang] . '</div>';
            $strpro .= ' <p class="price-product">';
            if ($v['sale_price'] != 0 && $v['regular_price'] != 0) {
                $strpro .= '<span class="price-new">' . $this->formatMoney($v['sale_price']) . '</span>
                <span class="price-old">' . $this->formatMoney($v['regular_price']) . '</span>
                <span class="price-per">' . '-' . round(100 - ($v['sale_price'] / $v['regular_price'] * 100)) . '%' . '</span>';
            } else {
                if ($v['regular_price'] != 0) $giapro = '<b>' . gia . '</b>: ' . $this->formatMoney($v['regular_price']);
                else $giapro = lienhe; //'<b>'.lienhe.'</b>: '.$optsetting['hotline']
                $strpro .= '<span class="price-new">' . $giapro . '</span>';
            }
            $strpro .= '</p></div></a></div>';
            if (CARTSITE == true) {
                $strpro .= '<div class="cart-product w-clear">
                    <span class="btn btn-sm btn-success cart-add addcart mr-2" data-id="' . $v['id'] . '" data-action="addnow"><i class="fa-sharp fa-regular fa-cart-plus mr-1"></i>Thêm vào giỏ hàng</span>
                    <span class="btn btn-sm btn-danger cart-buy addcart" data-id="' . $v['id'] . '" data-action="buynow"><i class="fa-sharp fa-regular fa-cash-register mr-1"></i>Mua ngay</span>
                </div>';
                // $strpro .= '<div class="cart-product w-clear">';
                // if ($v['regular_price'] > 0) {
                //     $strpro .= '<span class="btn btn-sm btn-success cart-add addcart" data-id="' . $v['id'] . '" data-action="addnow"><i class="fa-sharp fa-regular fa-cart-plus mr-1"></i>Thêm vào giỏ hàng</span>';
                //     $strpro .= '<span class="btn btn-sm btn-danger cart-buy addcart" data-id="' . $v['id'] . '" data-action="buynow"><i class="fa-sharp fa-regular fa-cash-register mr-1"></i>Mua ngay</span>';
                // } else {
                //     $strpro .= '<span class="btn btn-sm btn-success btn-alert"><i class="fa-sharp fa-regular fa-cart-plus mr-1"></i>Thêm vào giỏ hàng</span>';
                //     $strpro .= '<span class="btn btn-sm btn-danger btn-alert2"><i class="fa-sharp fa-regular fa-cash-register mr-1"></i>Mua ngay</span>';
                // }
                // $strpro .= '</div>';
            }
            $strpro .= '</div>';
        }
        if ($class != '') {
            $strpro .= '</div>';
        }
        return $strpro;
    }

    /*--- Lấy baiviet ----*/
    function lay_baiviet($truyvan, $cssitem, $thumb, $lazyload = 'lazy')
    {
        global $lang, $sluglang;
        $str = '';
        foreach ($truyvan as $k => $v) {
            $str .= '<a class="' . $cssitem . ' text-decoration-none w-clear" href="' . $v[$sluglang] . '" title="' . $v['name' . $lang] . '">
                        <p class="pic-news scale-img">' . $this->getImage(['class' => 'w-100', 'sizes' => $thumb, 'isWatermark' => WATERMARKPOST, 'prefix' => 'news', 'upload' => UPLOAD_NEWS_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) . '</p>

                        <div class="info-news">
                            <h3 class="name-news">' . $v['name' . $lang] . '</h3>
                            <p class="time-news">' . ngaydang . ': ' . date("d/m/Y h:i A", $v['date_created']) . '</p>
                            <div class="desc-news text-split">' . $v['desc' . $lang] . '</div>
                            <span class="view-news">Xem chi tiết <i class="fa-regular fa-right-long"></i></span>
                        </div>
                    </a>';
        }
        return $str;
    }
    function lay_tintuc($truyvan, $cssitem, $thumb)
    {
        global $lang, $sluglang;
        $str = '';
        foreach ($truyvan as $k => $v) {
            $str .= '<a class="' . $cssitem . ' text-decoration-none" href="' . $v[$sluglang] . '" title="' . $v['name' . $lang] . '">
                        <div class="pic-news scale-img hover_sang2">' . $this->getImage(['class' => 'w-100', 'sizes' => $thumb, 'isWatermark' => WATERMARKPOST, 'prefix' => 'news', 'upload' => UPLOAD_NEWS_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) . '</div>

                        <div class="info-news">
                            <h3 class="name-news text-split">' . $v['name' . $lang] . '</h3>
                            <div class="desc-news text-split">' . $v['desc' . $lang] . '</div>
                            <div class="operation-news">
                                <p class="time-news">' . date("d/m/Y", $v['date_created']) . '</p>
                                <p class="view-news"><span></span></p>
                            </div>
                        </div>
                    </a>';
        }
        return $str;
    }
    function lay_tieuchi($truyvan, $cssitem, $thumb)
    {
        global $lang, $sluglang;
        foreach ($truyvan as $k => $v) { ?>
            <a class="<?= $cssitem ?> text-decoration-none w-clear" title="<?= $v['name' . $lang] ?>">
                <p class="pic-news scale-img"><img onerror="this.src='<?= $thumb ?>assets/images/noimage.png';" src="<?= $thumb ?><?= UPLOAD_NEWS_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" width="95" height="95"></p>
                <div class="info-news">
                    <h3 class="name-news"><?= $v['name' . $lang] ?></h3>
                    <div class="desc-news text-split"><?= $v['desc' . $lang] ?></div>
                </div>
            </a>
            <?php   }
    }
    /*--- Lấy baiviet ----*/

    /*--- Lấy thuvien  ----*/
    function lay_thuvien($truyvan, $popup = 0, $thumb)
    {
        global $lang, $sluglang;

        if ($popup == 1) {

            foreach ($truyvan as $k => $v) {

                $sql = "select photo from #_gallery where find_in_set('hienthi',status) and id_parent =" . $v['id'] . "  and com='product' and type = '" . $v['type'] . "' and kind='man' and val = '" . $v['type'] . "' order by numb,id desc";
                $arr_cap = array();
                $hinhanhsp = $this->d->rawQuery($sql, $arr_cap);

            ?>
                <div class="album">
                    <a class=" text-decoration-none" data-fancybox="gallery<?= $v['id'] ?>" href="<?= UPLOAD_PRODUCT_L . $v['photo'] ?>" data-caption="<?= $v['name' . $lang] ?>">
                        <p class="pic-album hover_sang2"><img onerror="this.src='<?=THUMBS?>/<?= $thumb ?>/assets/images/noimage.png';" src="<?=THUMBS?>/<?= $thumb ?>/<?= UPLOAD_PRODUCT_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" width="350" height="350" /></p>
                        <h3 class="name-album text-split"><span><?= $v['name' . $lang] ?></span></h3>
                    </a>

                    <?php foreach ($hinhanhsp as $k2 => $v2) { ?>

                        <a class=" text-decoration-none none" data-fancybox="gallery<?= $v['id'] ?>" href="<?= UPLOAD_PRODUCT_L . $v2['photo'] ?>" data-caption="<?= $v['name' . $lang] ?>">
                            <p class="pic-album hover_sang2"><img onerror="this.src='<?=THUMBS?>/<?= $thumb ?>/assets/images/noimage.png';" src="<?=THUMBS?>/<?= $thumb ?>/<?= UPLOAD_PRODUCT_L . $v2['photo'] ?>" alt="<?= $v2['name' . $lang] ?>" width="350" height="350" /></p>
                        </a>
                    <?php } ?>
                </div>
            <?php  }
        } else {

            foreach ($truyvan as $k => $v) { ?>
                <a class="album text-decoration-none" href="<?= $v[$sluglang] ?>" title="<?= $v['name' . $lang] ?>">
                    <p class="pic-album hover_sang2"><img onerror="this.src='<?=THUMBS?>/<?= $thumb ?>/assets/images/noimage.png';" src="<?=THUMBS?>/<?= $thumb ?>/<?= UPLOAD_PRODUCT_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" width="350" height="350" /></p>
                    <h3 class="name-album text-split"><?= $v['name' . $lang] ?></h3>
                </a>
            <?php }
        }
    }
    /*--- Lấy thuvien  ----*/

    /*--- Lấy thuvien  photo----*/
    function lay_thuvienphoto($truyvan, $popup = 0, $thumb)
    {
        global $lang, $sluglang;

        foreach ($truyvan as $k => $v) {

            ?>
            <div class="album">
                <a class=" text-decoration-none" data-fancybox="gallery<?= $v['id'] ?>" href="<?= UPLOAD_PHOTO_L . $v['photo'] ?>" data-caption="<?= $v['name' . $lang] ?>">
                    <p class="pic-album scale-img"><img onerror="this.src='<?=THUMBS?>/<?= $thumb ?>/assets/images/noimage.png';" src="<?=THUMBS?>/<?= $thumb ?>/<?= UPLOAD_PHOTO_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" width="350" height="350" /></p>
                    <h3 class="name-album text-split"><span><?= $v['name' . $lang] ?></span></h3>
                </a>
            </div>
        <?php  }
    }
    /*--- Lấy thuvien photo ----*/

    /*--- Lấy video ----*/
    function lay_video($truyvan, $thumb)
    {
        global $lang, $sluglang;

        foreach ($truyvan as $k => $v) { ?>
            <a class="video text-decoration-none" data-fancybox="video" data-src="<?= $v['link_video'] ?>" title="<?= $v['name' . $lang] ?>">
                <p class="pic-video scale-img"><img onerror="this.src='<?= $thumb ?>assets/images/noimage.png';" src="https://img.youtube.com/vi/<?= $this->getYoutube($v['link_video']); ?>/0.jpg" alt="<?= $v['name' . $lang] ?>" /></p>
                <h3 class="name-video text-split"><?= $v['name' . $lang] ?></h3>
            </a>
        <?php }
    }

    function lay_video2($truyvan, $thumb)
    {
        global $lang, $sluglang;

        foreach ($truyvan as $k => $v) { ?>
            <a class="video text-decoration-none" data-fancybox data-src="<?= $v['link_video'] ?>" title="<?= $v['name' . $lang] ?>">
                <p class="pic-video scale-img"><img onerror="this.src='<?= THUMBS ?>/<?= $thumb ?>/assets/images/noimage.png';" src="<?= THUMBS ?>/<?= $thumb ?>/<?= UPLOAD_PHOTO_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" /></p>
                <h3 class="name-video text-split"><?= $v['name' . $lang] ?></h3>
            </a>
        <?php }
    }
    /*--- Lấy video ----*/

    /*--- Lấy sản phẩm yêu thích ----*/
    function lay_sanpham_yeuthich($v)
    {
        global $lang, $sluglang, $config;
        $str = "";
        $nametype = 'san-pham';
        $dongdau = THUMBS . '/390x390x2/';
        //$dongdau = WATERMARK.'/product/360x390x1/';

        $str .= '<div class="product">
                        <a class="box-product text-decoration-none" href="' . $v[$sluglang] . '" title="' . $v['name' . $lang] . '">
                            <p class="pic-product scale-img"><img onerror="this.src=\'' . $dongdau . 'assets/images/noimage.png\'" src="' . $dongdau . UPLOAD_PRODUCT_L . $v['photo'] . '" alt="' . $v['name' . $lang] . '" width="350" height="350"/></p>
                            <h3 class="name-product text-split">' . $v['name' . $lang] . '</h3>
                            <p class="price-product">';
        if ($v['sale_price'] != 0 && $v['regular_price'] != 0) {
            $str .= '<span class="price-new">' . number_format($v['sale_price'], 0, ',', '.') . 'đ</span>
                                    <span class="price-old">' . number_format($v['regular_price'], 0, ',', '.') . 'đ</span>
                                    <span class="price-per">-' . round(100 - ($v['sale_price'] / $v['regular_price'] * 100)) . '%</span>';
            //<span class="price-per">-'.$v['giakm'].'%</span>
        } else {

            if ($v['regular_price'] != 0) $s_gia = number_format($v['regular_price'], 0, ',', '.') . 'đ';
            else $s_gia = lienhe;
            $str .= '<span class="price-new"><b>Giá Niêm Yết :</b> ' . $s_gia . '</span>';
        }
        $str .= '</p>
                        </a>';

        if (in_array($v['id'], $_SESSION['sanphamyeuthich']) == true) {
            $act_love = 'act-love';
        } else {
            $act_love = '';
        }

        $str .= '<p class="option-product transition w-clear">
                                <span class="transition yeuthich ' . $act_love . '" data-id="' . $v['id'] . '"><i class="far fa-heart"></i></span>
                                <span class="transition xemnhanh" data-id="' . $v['id'] . '"><i class="far fa-eye"></i></span>
                        </p>';

        /*$str .='<p class="cart-product w-clear">
                                <span class="cart-add addcart transition" data-id="'.$v['id'].'" data-action="addnow">Thêm vào giỏ hàng</span>
                                <span class="cart-buy addcart transition" data-id="'.$v['id'].'" data-action="buynow">Mua ngay</span>
                            </p>';*/

        $str .= '</div>';
        return $str;
    }
    /*lấy cấp list, cat, item, sub*/
    function get_cap($dieukien, $typesp, $loaitable, $gioihan)
    {
        global $lang;
        $sql = "select name$lang, slugvi, slugen, id, desc$lang, photo,type from #_" . $loaitable . " where type='" . $typesp . "' and find_in_set('hienthi',status) and find_in_set('" . $dieukien . "',status) order by numb asc limit 0," . $gioihan;
        $arr_sqlc_num = array();
        return $truyvan = $this->d->rawQuery($sql, $arr_sqlc_num);
    }

        /*lấy cấp sản phẩm theo id_list, cat, item, sub*/
        function get_product_id($dieukien, $typesp, $loaiid, $iddanhmuc, $gioihan)
        {
            global $lang;
            $sql = "select type, id, name$lang, slugvi, slugen, desc$lang, content$lang, code, view, id_brand,  id_list, id_cat, id_item, id_sub,  photo, options,  sale_price, regular_price from #_product where type='" . $typesp . "' and " . $loaiid . "=" . $iddanhmuc . " and find_in_set('hienthi',status) and find_in_set('" . $dieukien . "',status)  order by numb asc limit 0," . $gioihan;
            $arr_cap = array();
            return $truyvan = $this->d->rawQuery($sql, $arr_cap);
        }

    /*lấy sản phẩm theo loại noibat, banchay */
    function get_product($dieukien, $typesp, $gioihan)
    {
        global $lang;
        $sql = "select type, id, name$lang, slugvi, slugen, desc$lang, content$lang, code,    view, id_brand,  id_list, id_cat, id_item, id_sub,  photo, options,  sale_price, regular_price from #_product where type='" . $typesp . "'  and find_in_set('hienthi',status) and  find_in_set('" . $dieukien . "',status) order by numb asc limit 0," . $gioihan;
        $arr_cap = array();
        return $truyvan = $this->d->rawQuery($sql, $arr_cap);
    }

    /*lấy bài viết theo loại noibat */
    function get_baiviet($dieukien, $typesp, $gioihan)
    {
        global $lang;
        $sql = "select type, id, name$lang, slugvi, slugen, desc$lang, content$lang,  view,  photo, date_created from #_news where type='" . $typesp . "' and find_in_set('hienthi',status) and  find_in_set('" . $dieukien . "',status) order by numb asc limit 0," . $gioihan;
        $arr_cap = array();
        return $truyvan = $this->d->rawQuery($sql, $arr_cap);
    }
    function isGoogleSpeed()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') === false) {

            return false;
        }
        return true;
    }
    
    public function get_youtube_shorts($str)
    {
        $char = 'shorts/';
        $pos = strpos($str, $char);
        if ($pos != false) {
            $str = "https://www.youtube.com/watch?v=" . end(explode($char, $str));
        }
        return $str;
    }
}
