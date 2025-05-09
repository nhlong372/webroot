<?php
include "config.php";

$routes = array('limitLists' => ['limitLists', 'GET'], 'limitReplies' => ['limitReplies', 'GET'], 'add' => ['add', 'POST']);
$route = (!empty($_GET['get']) && !empty($routes[$_GET['get']])) ? $_GET['get'] : false;

if (!empty($route)) {
    $comment = new Comments($d, $func);
    $method = $routes[$route][0];
    $requestType = $routes[$route][1];

    if (method_exists($comment, $method) && $_SERVER['REQUEST_METHOD'] == $requestType) {
        print $comment->$method();
    }
}
