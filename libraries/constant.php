<?php
if (!defined('LIBRARIES')) die("Error");

/* Array folders */
$upload_const = 'upload';
$array_const = array('file', 'filemanager', 'sync', 'excel', 'seopage', 'photo', 'video', 'temp', 'user', 'product', 'color', 'news', 'tags');

/* Define - Create folders upload */
if (!file_exists(ROOT . $upload_const)) {
    mkdir(ROOT . $upload_const, 0777, true);
    chmod(ROOT . $upload_const, 0777);
}

/* Define - Create folders childs */
if (file_exists(ROOT . $upload_const) && $array_const) {
    /* Create htaccess file */
    $path_htaccess = ROOT . $upload_const . '/.htaccess';
    if (!file_exists($path_htaccess)) {
        $content_htaccess = '';
        $content_htaccess .= '<Files ~ "\.(inc|sql|php|cgi|pl|php4|php5|asp|aspx|jsp|txt|kid|cbg|nok|shtml|php[1234567890]*)$">' . PHP_EOL;
        $content_htaccess .= 'order allow,deny' . PHP_EOL;
        $content_htaccess .= 'deny from all' . PHP_EOL;
        $content_htaccess .= '</Files>';

        $file_htaccess = fopen($path_htaccess, "w") or die("Unable to open file");
        fwrite($file_htaccess, $content_htaccess);
        fclose($file_htaccess);
    }

    /* Create constants */
    $define_constants = [];
    foreach ($array_const as $vconst) {
        $define_upper_upload = strtoupper($upload_const);
        $define_upper_const = strtoupper($vconst);
        $define_lower_const = $vconst;
        $define_in = '../' . $upload_const . '/' . $define_lower_const . '/';
        $define_out = $upload_const . '/' . $define_lower_const . '/';
        if (!defined($define_upper_upload . '_' . $define_upper_const) && !defined($define_upper_upload . '_' . $define_upper_const . '_L')) {
            $define_constants[$define_upper_upload . '_' . $define_upper_const] = $define_in;
            $define_constants[$define_upper_upload . '_' . $define_upper_const . '_L'] = $define_out;

            if (!file_exists(ROOT . $upload_const . '/' . $define_lower_const)) {
                mkdir(ROOT . $upload_const . '/' . $define_lower_const, 0777, true);
                chmod(ROOT . $upload_const . '/' . $define_lower_const, 0777);
            }
        }
    }

    /* Generate constants */
    if (!empty($define_constants)) {
        $path_upload = ROOT . basename(__DIR__) . '/upload.php';
        if (!file_exists($path_upload)) {
            $define_constants_file = fopen($path_upload, "w") or die("Unable to open file");

            $define_constants_string = '<?php';
            foreach ($define_constants as $k => $v) {
                $define_constants_string .= PHP_EOL . 'define("' . $k . '", "' . $v . '");';
            }
            $define_constants_string .= PHP_EOL;

            fwrite($define_constants_file, $define_constants_string);
            fclose($define_constants_file);
        }
    }
}

/* Array folders */
$upload_const = array('thumbs'); // folder cần thêm htaccess
if (WATERMARKPOST == true || WATERMARKPRODUCT == true) {
    array_push($upload_const, 'watermark');
    if (WATERMARKPOST == true) { array_push($upload_const, 'watermark/news'); }
    if (WATERMARKPRODUCT == true) { array_push($upload_const, 'watermark/product'); }
}

/* Define - Create folders upload */
if (count($upload_const)>0) { foreach ($upload_const as $key => $value) {
    if (!file_exists(ROOT . $value)) {
        mkdir(ROOT . $value, 0777, true);
        chmod(ROOT . $value, 0777);
    }
    /* Define - Create folders childs */
    if (file_exists(ROOT . $value)) {
        /* Create htaccess file */
        $path_htaccess = ROOT . $value . '/.htaccess';
        if (!file_exists($path_htaccess)) {
            $content_htaccess = '';
            $content_htaccess .= '<Files ~ "\.(inc|sql|php|cgi|pl|php4|php5|asp|aspx|jsp|txt|kid|cbg|nok|shtml|php[1234567890]*)$">' . PHP_EOL;
            $content_htaccess .= 'order allow,deny' . PHP_EOL;
            $content_htaccess .= 'deny from all' . PHP_EOL;
            $content_htaccess .= '</Files>';

            $file_htaccess = fopen($path_htaccess, "w") or die("Unable to open file");
            fwrite($file_htaccess, $content_htaccess);
            fclose($file_htaccess);
        }

    }
} }

/* Define - Include defined constants */
include LIBRARIES . "upload.php";
