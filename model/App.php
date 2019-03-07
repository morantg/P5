<?php

class App{

  /**
   * Méthode permettant d'instancier la classe Auth'
   * @return Auth 
   */
	static function getAuth(){
		return new Auth(Session::getInstance());
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
}