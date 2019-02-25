<?php

class App{

  /**
   * Méthode permettant d'instancier la classe Auth'
   * @return Auth 
   */
	static function getAuth(){
		return new Auth(Session::getInstance(),['restriction_msg' => 'pas le droit d accès']);
	}
  
  /**
   * @param $page string 
   * @return void
   */
	static function redirect($page){
		header("Location: $page");
		exit();
	}
	
  /**
   * Méthode permettant de générer une chaine de caractère aléatoire(token)
   * @param $length int Nombre de caractère demandé
   * @return string
   */
	static function random($length){
		$alphabet = "012345678azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
		return substr(str_shuffle(str_repeat($alphabet,$length )),0,$length);
	}

  /**
   * Méthode pour utiliser le moteur de templates twig
   * @return Twig_Environment
   */
	static function get_twig(){
		$loader = new Twig_Loader_Filesystem('view');
		$twig = new Twig_Environment($loader,[
    		'cache' => false,//__DIR__ . '/tmp'
	]);
		return $twig;
	}
}