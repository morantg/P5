<?php
class Session{

	static $instance;

	static function getInstance(){
		if(!self::$instance){
		self::$instance = new Session();
		}
		return self::$instance;
	}

	public function __construct(){
		session_start();
	}
	
  /**
   * @param $key string
   * @param $message string
   * @return void
   */
	public function setFlash($key,$message){
		$_SESSION['flash'][$key] = $message;
	}

  /**
   * @return bool
   */
	public function hasFlashes(){
		return isset($_SESSION['flash']);
	}

  /**
   * @return array
   */
	public function getFlashes(){
		$flash = $_SESSION['flash'];
		unset($_SESSION['flash']);
		return $flash;
	}

  /**
   * @param $key string
   * @param $value string
   * @return void
   */
	public function write($key,$value){
		$_SESSION[$key] = $value;
	}

  /**
   * @param $key string
   * @return array
   */
	public function read($key){
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

  /**
   * @param $key string
   */
	public function delete ($key){
		unset($_SESSION[$key]);
	}
}