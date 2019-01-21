<?php

require 'inc/bootstrap.php';
$db = DBFactory::getMysqlConnexionWithPDO();


if(App::getAuth()->confirm($db, $_GET['id'], $_GET['token'], Session::getInstance())){
	
	 
	
	Session::getInstance()->setFlash('success',"compte validé");
	App::redirect('account.php');
	
	}else{
	
	Session::getInstance()->setFlash('danger',"ce token n'est plus valide");
	App::redirect('login.php');
}