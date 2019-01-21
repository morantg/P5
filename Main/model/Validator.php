<?php

class Validator{

	private $data;
	private $errors=[];

	public function __construct($data){
		$this->data = $data;
	}

	private function getField($field){
		if(!isset($this->data[$field])){
			return null;
		}
		return $this->data[$field];
	}

	public function isAlpha($field,$errorMsg){
		if(!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))){
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isUniq($field, $db,$table, $errorMsg){
		$record = $db->prepare("SELECT id FROM $table WHERE $field = ?");
		$record->execute([$this->getField($field)]);
		$req = $record->fetch();
		
		if($req){
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isEmail($field,$errorMsg){
		if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)){
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isConfirmed($field,$errorMsg=''){
		$value = $this->getField($field);
		if(empty($value) || $value != $this->getField($field.'_confirm')){
			$this->errors[$field] = $errorMsg;
		}
	}
	
	public function isValid(){
		return empty($this->errors);
	}

	public function getErrors(){
		return $this->errors;
	}

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