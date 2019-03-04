<?php

spl_autoload_register('app_autoload');

function app_autoload($class){

	if(file_exists('model/' . $class . '.php' )){
		include_once('model/' . $class . '.php');
	}else if(file_exists('controller/' . $class . '.php' )){
		include_once('controller/' . $class . '.php');
	}

}



