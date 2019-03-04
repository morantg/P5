<?php
class DBFactory{
  
  public static function getMysqlConnexionWithPDO(){
  	$config = Config::getInstance('config.php');
	$mysql_db = new PDO("mysql:host=" . $config->get('db_host') . ";dbname=" . $config->get('db_name') , $config->get('db_user') , $config->get('db_pass'));
    $mysql_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mysql_db->exec('set names utf8');
    $mysql_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    
    return $mysql_db;
  }
}

