<?php

class App{

	private static $title_about = 'About Me';

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

	static function get_twig(){
		$loader = new Twig_Loader_Filesystem('view');
		$twig = new Twig_Environment($loader,[
    		'cache' => false,//__DIR__ . '/tmp'
	]);
		return $twig;
	}

	public static function getTitleAbout(){
		return self::$title_about;
	}

}