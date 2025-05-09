<?php
include "config.php";

if (!empty($_POST['id'])) {
    $table = (!empty($_POST['table'])) ? htmlspecialchars($_POST['table']) : '';
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $value = (!empty($_POST['value'])) ? htmlspecialchars($_POST['value']) : 0;

    $data['numb'] = $value;

    $d->where('id', $id);
    $d->update($table, $data);
    $cache->delete();
}
