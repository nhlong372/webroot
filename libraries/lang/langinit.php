<?php
$columnarr = array(
    "title" => 'TEXT',
    "keywords" => 'TEXT',
    "description" => 'TEXT'
);

$columnLang = array(
    "lang" => "TEXT"
);

function createLangInit()
{
    global $config, $d, $columnarr, $columnLang;

    foreach ($config['website']['lang'] as $klang => $vlang) {
        foreach ($columnLang as $kcol => $vcol) {
            $col = $kcol . $klang;
            $rowcol = $d->rawQueryOne("show columns from #_lang like '$col'");

            if ($rowcol == null) $d->rawQuery("alter table #_lang add $col $vcol character set utf8 collate utf8_unicode_ci ");
        }
    }
    foreach ($config['website']['lang'] as $klang => $vlang) {
        foreach ($columnarr as $kcol => $vcol) {
            $col = $kcol . $klang;
            $rowcol = $d->rawQueryOne("show columns from #_seo like '$col'");

            if ($rowcol == null) $d->rawQuery("alter table #_seo add $col $vcol character set utf8 collate utf8_unicode_ci ");
        }
    }
    foreach ($config['website']['lang'] as $klang => $vlang) {
        foreach ($columnarr as $kcol => $vcol) {
            $col = $kcol . $klang;
            $rowcol = $d->rawQueryOne("show columns from #_seopage like '$col'");

            if ($rowcol == null) $d->rawQuery("alter table #_seopage add $col $vcol character set utf8 collate utf8_unicode_ci ");
        }
    }
    foreach ($config['website']['lang'] as $klang => $vlang) {
        foreach ($columnarr as $kcol => $vcol) {
            $col = $kcol . $klang;
            $rowcol = $d->rawQueryOne("show columns from #_setting like '$col'");

            if ($rowcol == null) $d->rawQuery("alter table #_setting add $col $vcol character set utf8 collate utf8_unicode_ci ");
        }
    }
    die("Thêm cột ngôn ngữ thành công.");
}

function deleteLangInit($lang)
{
    if ($lang != '') {
        global $config, $d, $columnarr, $columnLang;

        foreach ($config['website']['lang'] as $vlang) {
            foreach ($columnLang as $kcol => $vcol) {
                $col = $kcol . $lang;
                $row = $d->rawQueryOne("show columns from #_lang like '$col'");

                if ($row != null) $d->rawQuery("alter table #_lang drop $col");
            }
        }
        foreach ($config['website']['lang'] as $vlang) {
            foreach ($columnarr as $kcol => $vcol) {
                $col = $kcol . $lang;
                $row = $d->rawQueryOne("show columns from #_seo like '$col'");

                if ($row != null) $d->rawQuery("alter table #_seo drop $col");
            }
        }
        foreach ($config['website']['lang'] as $vlang) {
            foreach ($columnarr as $kcol => $vcol) {
                $col = $kcol . $lang;
                $row = $d->rawQueryOne("show columns from #_seopage like '$col'");

                if ($row != null) $d->rawQuery("alter table #_seopage drop $col");
            }
        }
        foreach ($config['website']['lang'] as $vlang) {
            foreach ($columnarr as $kcol => $vcol) {
                $col = $kcol . $lang;
                $row = $d->rawQueryOne("show columns from #_setting like '$col'");

                if ($row != null) $d->rawQuery("alter table #_setting drop $col");
            }
        }
        die("Xóa cột ngôn ngữ thành công.");
    }
}

	// createLangInit();
	// deleteLangInit('cn');
