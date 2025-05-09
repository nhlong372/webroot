<?php
include "config.php";

if (!empty($_POST["id"])) {
    $level = (!empty($_POST["level"])) ? htmlspecialchars($_POST["level"]) : 0;
    $table = (!empty($_POST["table"])) ? htmlspecialchars($_POST["table"]) : '';
    $id = (!empty($_POST["id"])) ? htmlspecialchars($_POST["id"]) : 0;
    $row = null;

    switch ($level) {
        case '0':
            $id_temp = "id_city";
            break;

        case '1':
            $id_temp = "id_district";
            break;

        default:
            echo 'error ajax';
            exit();
            break;
    }

    if ($id) {
        $row = $d->rawQuery("select name, id from $table where $id_temp = ? order by id asc", array($id));
    }

    $str = '<option value="0">Chọn danh mục</option>';
    if (!empty($row)) {
        foreach ($row as $v) {
            $str .= '<option value=' . $v["id"] . '>' . $v["name"] . '</option>';
        }
    }
} else {
    $str = '<option value="0">Chọn danh mục</option>';
}

echo $str;
