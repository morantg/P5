<?php
require 'vendor/autoload.php';
require 'model/Autoloader.php';
require 'controller/Autoloader.php';

model\Autoloader::register();
controller\Autoloader::register();

if (isset($_GET['action'])) {
    $page = $_GET['action'];
} else {
    $page = 'post.list';
}

$page = explode('.', $page);

$controller = '\controller\\' . ucfirst($page[0]) . 'Controller';
$action = $page[1];

if ($controller === '\controller\AuthController') {
    $controller = new $controller(
        model\DBFactory::getMysqlConnexionWithPDO(),
        model\App::getAuth(),
        model\Session::getInstance()
    );
    $controller->$action();
} elseif ($controller === '\controller\PostController') {
    $mysql_db = model\DBFactory::getMysqlConnexionWithPDO();
    $postManager = new model\NewsManager($mysql_db);
    $commentManager = new model\CommentManager($mysql_db);
    $controller = new $controller(
        $mysql_db,
        $postManager,
        $commentManager,
        model\App::getAuth(),
        model\Session::getInstance()
    );
    $controller->$action();
} elseif ($controller === '\controller\PageController') {
    $controller = new $controller(model\DBFactory::getMysqlConnexionWithPDO(), model\Session::getInstance());
    $controller->$action();
}
