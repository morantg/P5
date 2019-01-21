<?php 

require 'inc/bootstrap.php';
App::getAuth()->logout();
Session::getInstance()->setFlash('success','vous etes deco');


App::redirect('login.php');
