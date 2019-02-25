<?php

require('../vendor/autoload.php');
require 'model/autoload.php';


if(isset($_GET['action'])){
    $page = $_GET['action'];
}else{
    $page = 'post.list';
}

$page = explode('.', $page);

$controller = $page[0] . 'Controller';
$action = $page[1];

$controller = new $controller();
$controller->$action();












