<?php

class App{

	static function getAuth(){
		return new Auth(Session::getInstance(),['restriction_msg' => 'pas le droit d accès']);
	}

	static function redirect($page){
		header("Location: $page");
		exit();
	}

	static function random($length){
	$alphabet = "012345678azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";

	return substr(str_shuffle(str_repeat($alphabet,$length )),0,$length);
	}
}