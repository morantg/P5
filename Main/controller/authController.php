<?php
class authController extends Controller{

	public function __construct(){
		$this->db = DBFactory::getMysqlConnexionWithPDO();
		$this->auth = App::getAuth();
		$this->session = Session::getInstance();
	}

	public function login(){
		$this->auth->connectFromCookie($this->db);
		
		if($this->auth->user()){
			App::redirect('MonCompte');
		}
		$username = filter_input(INPUT_POST, 'username');
		$password = filter_input(INPUT_POST, 'password');
		$remember = filter_input(INPUT_POST, 'remember');
		
		if(!empty($_POST) && $username && $password){
		$user = $this->auth->login($this->db, $username, $password,isset($remember));
		    
			$test = $this->session->readWithParam('auth','permission');
		    if ($user){
			$this->session->setFlash('success','Vous êtes maintenant connecté');
			App::redirect('MonCompte');
			}else{
			$this->session->setFlash('danger','Identifiant ou mot de passe incorrecte');
			}
		}
		$this->render('loginView.php',array(
			'session_instance' => $this->session
		));
	}

	public function account(){
		$this->auth->restrict();
		$validator = new validator($_POST);
		$password = filter_input(INPUT_POST, 'password');
		$password_confirm = filter_input(INPUT_POST, 'password_confirm');
	    
		if(!empty($_POST)){
			if(empty($password) || $password != $password_confirm){
				$_SESSION['flash']['danger'] = "les mots de passe ne corresponde pas";
		}else{
			$user_id = $_SESSION['auth']->id;
			$password_hash= password_hash($password,PASSWORD_BCRYPT);
			$this->auth->passwordUpdate($password_hash, $this->db, $user_id );
			$_SESSION['flash']['success'] = "mot de passe mis a jour";
			App::redirect('MonCompte');
	    	}
		}
		$this->render('accountView.php',array(
			'session' => $_SESSION,
			'session_instance' => $this->session
			
		));
	}

	public function logout(){
		$this->auth->logout();
		$this->session->setFlash('success','vous êtes déconnecté');
		App::redirect('Connection');
	}

	public function register(){
		$errors = array();
		$user = $this->auth->users($this->db);
		if(!empty($_POST)){
			$validator = new validator($_POST);
			$validator->isAlpha('username',"Votre pseudo n'est pas valide (alphanumérique)");
			
			if($validator->isValid()){
				$validator->isUniq('username', $this->db,'users','Ce pseudo est déja pris');
			}
			$validator->isEmail('email',"email non valide");
			
			if($validator->isValid()){
				$validator->isUniq('email', $this->db,'users','Ce mail est déjà pris');
			}
			$validator->isConfirmed('password','vous devez rentrer un mot de passe valide');
			
			if($validator->isValid()){
				$this->auth->register($this->db,$_POST['username'],$_POST['password'],$_POST['email']);
				$this->session->setFlash('success','email de confirmation envoyé');
				App::redirect('Connection');
			}else{
				$errors = $validator->getErrors(); 
			}
		}
		$this->render('registerView.php',array('errors' => $errors));
	}

	public function confirm(){
		$id = filter_input(INPUT_GET, 'id');
		$token = filter_input(INPUT_GET, 'token');
		if($this->auth->confirm($this->db, $id, $token, $this->session)){
			$this->session->setFlash('success',"compte validé");
			App::redirect('MonCompte');
		}else{
			$this->session->setFlash('danger',"ce token n'est plus valide");
			App::redirect('Connection');
		}	
	}

	public function forget(){
		$email = filter_input(INPUT_POST, 'email');
		if($email){
			if($this->auth->resetPassword($this->db,$email)){
				$this->session->setFlash('success','les instructions du rappel de mot de passe vous ont été envoyées par emails');
				App::redirect('Connection');
			}else{
				$this->session->setFlash('danger','pas de correspondance');
				App::redirect('Forget');
			}
		}
		$this->render('forgetView.php',array('session_instance' => $this->session)); 
	}

	public function reset_password(){
		$id = filter_input(INPUT_GET, 'id');
		$token = filter_input(INPUT_GET, 'token');
		if($id && $token){
		$user = $this->auth->checkResetToken($this->db, $id, $token);
			if($user){
				if(!empty($_POST)){
					$validator = new Validator($_POST);
					$validator->isConfirmed('password');
					if($validator->isValid()){
						$password = $this->auth->hashPassword($_POST['password']);
						$this->auth->confirmReset($password, $id, $this->db);
						$this->auth->connect($user);
						$this->session->setFlash('success',"Votre mot de passe a bien été modifié");
						App::redirect('MonCompte');
					}
				}
			}else{
					$this->session->setFlash('danger',"ce token n'est plus valide");
					App::redirect('Connection');
				}
		}else{
				App::redirect('Connection');
			}
		$this->render('resetView.php');
	}
}