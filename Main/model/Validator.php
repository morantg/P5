<?php

class Validator{

	private $data;
	private $errors=[];

	public function __construct($data){
		$this->data = $data;
	}

  /**
   * @param $field string
   * @return string
   */
	private function getField($field){
		if(!isset($this->data[$field])){
			return null;
		}
		return $this->data[$field];
	}

  /**
   * @param $field string
   * @param $errorMsg string
   * @return void
   */
	public function isAlpha($field,$errorMsg){
		if(!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))){
			$this->errors[$field] = $errorMsg;
		}
	}

  /**
   * @param $field string
   * @param $errorMsg string
   * @return void
   */
	public function isEmpty($field,$errorMsg){
		if(empty($this->getField($field))){
			$this->errors[$field] = $errorMsg;
		}
	}

  /**
   * @param $field string
   * @param $db PDO
   * @param $table string
   * @param $errorMsg string
   * @return void
   */
	public function isUniq($field, $db,$table, $errorMsg){
		$record = $db->prepare("SELECT id FROM $table WHERE $field = ?");
		$record->execute([$this->getField($field)]);
		$req = $record->fetch();
		
		if($req){
			$this->errors[$field] = $errorMsg;
		}
	}

  /**
   * @param $field string
   * @param $errorMsg string
   * @return void
   */
	public function isEmail($field,$errorMsg){
		if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)){
			$this->errors[$field] = $errorMsg;
		}
	}

  /**
   * @param $field string
   * @param $errorMsg string
   * @return void
   */
	public function isConfirmed($field,$errorMsg=''){
		$value = $this->getField($field);
		if(empty($value) || $value != $this->getField($field.'_confirm')){
			$this->errors[$field] = $errorMsg;
		}
	}
	
  /**
   * Retourne true si une saisie est valide est inversement
   * @return bool
   */
	public function isValid(){
		return empty($this->errors);
	}

  /**
   * Retourne les erreurs effectuées par l'utilisateur lors de la saisie 
   * @return array
   */
	public function getErrors(){
		return $this->errors;
	}

  /**
   * @param $db PDO
   * @param $user_id in
   * @return bool
   */
	public static function isAdmin($db,$user_id){
		$req = $db->prepare('SELECT permission FROM users WHERE id = ?');
		$req->execute([$user_id]);
		$user= $req->fetch();
		
		if($user->permission == 'admin' || $user->permission == 'superadmin'){
			$auth = App::getAuth();
			return $_SESSION['admin'] = true;
		}else{
			return $_SESSION['admin'] = false;
		}
	}

  /**
   * @param $db PDO
   * @param $user_id in
   * @return bool
   */
	public static function isSuperAdmin($db,$user_id){
		$req = $db->prepare('SELECT permission FROM users WHERE id = ?');
		$req->execute([$user_id]);
		$user= $req->fetch();
		
		if($user->permission == 'superadmin'){
			$auth = App::getAuth();
			return $_SESSION['superadmin'] = true;
		}else{
			return $_SESSION['superadmin'] = false;
		}
	}
}