<?php
include "config.php";
include LIBRARIES . "type/config-type-product.php";
include LIBRARIES . "type/config-type-news.php";

if (!empty($_POST['id'])) {
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $table = (!empty($_POST['table'])) ? htmlspecialchars($_POST['table']) : '';
    $copyimg = (!empty($_POST['copyimg'])) ? htmlspecialchars($_POST['copyimg']) : false;

    if ($id) {
        $item = $d->rawQueryOne("select * from #_$table where id = ? limit 0,1", array($id));
    }

    function createCopy($titleCopy = '', $titleSlug = '', $table = '')
    {
        global $d, $cache, $func, $config, $item, $copyimg;

        $check = $d->rawQueryOne("select id from #_$table where slugvi = ? or slugen = ? limit 0,1", array($titleSlug, $titleSlug));

        if (!empty($check['id'])) {
            $titleCopy .= " (1)";
            $titleSlug = $func->changeTitle($titleCopy);
            createCopy($titleCopy, $titleSlug, $table);
        } else {
            foreach ($config['website']['lang'] as $key => $value) {
                $dataCopy['desc' . $key] = $item['desc' . $key];
                $dataCopy['content' . $key] = $item['content' . $key];
            }
            if ($copyimg) {
                $dataCopy['photo'] = $func->copyImg($item['photo'], $table);
            }
            $dataCopy['namevi'] = $titleCopy;
            $dataCopy['slugvi'] = !empty($config[$table][$item['type']]['slug']) ? $func->changeTitle($dataCopy['namevi']) : '';
            $dataCopy['id_list'] = $item['id_list'];
            $dataCopy['id_cat'] = $item['id_cat'];
            $dataCopy['id_item'] = $item['id_item'];
            $dataCopy['id_sub'] = $item['id_sub'];

            if ($table == 'product') {
                $dataCopy['id_brand'] = $item['id_brand'];
                $dataCopy['code'] = $item['code'];
                $dataCopy['regular_price'] = $item['regular_price'];
                $dataCopy['discount'] = $item['discount'];
                $dataCopy['sale_price'] = $item['sale_price'];
            }

            $dataCopy['numb'] = 0;
            $dataCopy['status'] = '';
            $dataCopy['type'] = $item['type'];
            $dataCopy['date_created'] = time();
            $d->insert($table, $dataCopy);
            $cache->delete();
        }
    }

    if (!empty($item['id'])) {
        $title = $item['namevi'];
        $titleSlug = $item['slugvi'];
        createCopy($title, $titleSlug, $table);
    }
}
