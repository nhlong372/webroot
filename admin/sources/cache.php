<?php
if (!defined('SOURCES')) die("Error");

switch ($act) {
    case "delete":
        delete();
        break;

    default:
        $template = "404";
}

/* Delete cache */
function delete()
{
    global $func, $cache;

    if ($cache->delete()) $func->transfer("Xóa cache thành công", "index.php");
    else $func->transfer("Xóa cache thất bại", "index.php", false);
}
