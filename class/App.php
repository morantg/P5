<?php

class App{


	
	static function getAuth(){
		return new Auth(Session::getInstance(),['restriction_msg' => 'pas le droit d accès']);

	}


	
	static function redirect($page){
		header("Location: $page");
		exit();

	}



}