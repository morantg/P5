<?php 

session_start();
unset($_SESSION['auth']);

$_SESSION['flash']['success'] = 'vous etes deco';

header('Location: login.php');