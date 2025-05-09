<?php
include "config.php";

$action = (!empty($_POST['action'])) ? htmlspecialchars($_POST['action']) : '';
$result = array();
$tables = array();

if ($action) {
    $tables = $d->rawQuery("SHOW TABLES");

    if (!empty($tables)) {
        $result = $func->databaseMaintenance($action, $tables);
    }
}

echo json_encode($result);
