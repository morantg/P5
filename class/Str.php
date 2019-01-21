<?php

class Str{

	static function random($length){
	$alphabet = "012345678azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";

	return substr(str_shuffle(str_repeat($alphabet,$length )),0,$length);
	}

}