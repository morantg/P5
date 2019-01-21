<?php 

session_start();
setcookie('remember', NULL,-1);
unset($_SESSION['auth']);

$_SESSION['flash']['success'] = 'vous etes deco';

header('Location: login.php');