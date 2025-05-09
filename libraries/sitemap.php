<?php
header("Content-Type: text/xml; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
echo '<url><loc>' . $configBase . '</loc><lastmod>' . date('c', time()) . '</lastmod><changefreq>daily</changefreq><priority>1.00</priority></url>';
if (!empty($requick)) {
    foreach ($requick as $value) {
        $func->createSitemap($value['com'], $value['type'], $value['field'], $value['tbl'], "c", "daily", $value['priority'], "vi", "numb,id", @$value['menu']);
    }
}
echo '</urlset>';
