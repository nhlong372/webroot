<?php
include "config.php";

if (!empty($_POST["id"])) {
    $level = (!empty($_POST["level"])) ? htmlspecialchars($_POST["level"]) : 0;
    $table = (!empty($_POST["table"])) ? htmlspecialchars($_POST["table"]) : '';
    $id = (!empty($_POST["id"])) ? htmlspecialchars($_POST["id"]) : 0;
    $type = (!empty($_POST["type"])) ? htmlspecialchars($_POST["type"]) : '';
    $row = null;

    switch ($level) {
        case '0':
            $id_temp = "id_list";
            break;

        case '1':
            $id_temp = "id_cat";
            break;

        case '2':
            $id_temp = "id_item";
            break;

        default:
            echo 'error ajax';
            exit();
            break;
    }

    if ($id) {
        $row = $d->rawQuery("select namevi, id from $table where $id_temp = ? and type = ? order by numb,id desc", array($id, $type));
    }

    $str = '<option value="0">Chọn danh mục</option>';
    if (!empty($row)) {
        foreach ($row as $v) {
            $str .= '<option value=' . $v["id"] . '>' . $v["namevi"] . '</option>';
        }
    }
} else {
    $str = '<option value="0">Chọn danh mục</option>';
}

echo $str;
