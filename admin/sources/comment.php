<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active commnet */
$variant = (!empty($_GET['variant'])) ? htmlspecialchars($_GET['variant']) : '';
$type = (!empty($_GET['type'])) ? htmlspecialchars($_GET['type']) : '';
if (empty($config[$variant][$type]['comment'])) {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

switch ($act) {
    case "man":
        viewMans();
        $template = "comment/man/mans";
        break;

    default:
        $template = "404";
}

function viewMans()
{
    global $d, $func, $cache, $comment, $item, $variant, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (!empty($id)) {
        /* Get data detail */
        $item = $d->rawQueryOne("select * from #_$variant where id = ? and type = ? limit 0,1", array($id, $type));

        /* Check data detail */
        if (!empty($item)) {
            /* Comment */
            $comment = new Comments($d, $func, $item['id'], $item['type'], true);
        } else {
            $func->transfer("Dữ liệu không có thực", "index.php", false);
        }
    } else {
        $func->transfer("Trang không tồn tại", "index.php", false);
    }
}
