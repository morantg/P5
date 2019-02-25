<?php
class DBFactory{
  
  public static function getMysqlConnexionWithPDO(){
  	$config = Config::getInstance('config.php');
	$db = new PDO("mysql:host=" . $config->get('db_host') . ";dbname=" . $config->get('db_name') , $config->get('db_user') , $config->get('db_pass'));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('set names utf8');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    
    return $db;
  }
}

