<?php
require 'vendor/autoload.php';
require 'model/autoload.php';

if(isset($_GET['action'])){
    $page = $_GET['action'];
}else{
    $page = 'post.list';
}

$page = explode('.', $page);

$controller = $page[0] . 'Controller';
$action = $page[1];

if($controller === 'authController'){
	$controller = new $controller(DBFactory::getMysqlConnexionWithPDO(), App::getAuth(), Session::getInstance());
	$controller->$action();
}elseif($controller === 'postController'){
	$mysql_db = DBFactory::getMysqlConnexionWithPDO();
	$postManager = new NewsManager($mysql_db);
	$commentManager = new CommentManager($mysql_db);
	$controller = new $controller($mysql_db, $postManager, $commentManager, App::getAuth(), Session::getInstance());
	$controller->$action();
}elseif($controller === 'pageController'){
	$controller = new $controller(DBFactory::getMysqlConnexionWithPDO(), Session::getInstance());
	$controller->$action();
}
		






