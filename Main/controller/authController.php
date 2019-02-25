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
		if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
		$user = $this->auth->login($this->db,$_POST['username'],$_POST['password'],isset($_POST['remember']));
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
	    $admin = $validator->isAdmin($this->db,$_SESSION['auth']->id);
		
		if(!empty($_POST)){
			if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
				$_SESSION['flash']['danger'] = "les mots de passe ne corresponde pas";
		}else{
			$user_id = $_SESSION['auth']->id;
			$password= password_hash($_POST['password'],PASSWORD_BCRYPT);
			$this->auth->passwordUpdate($password, $this->db, $user_id );
			$_SESSION['flash']['success'] = "mot de passe mis a jour";
			App::redirect('MonCompte');
	    	}
		}
		$this->render('accountView.php',array(
			'session' => $_SESSION,
			'session_instance' => $this->session,
			'admin' => $admin 
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
		if($this->auth->confirm($this->db, $_GET['id'], $_GET['token'], $this->session)){
			$this->session->setFlash('success',"compte validé");
			App::redirect('MonCompte');
		}else{
			$this->session->setFlash('danger',"ce token n'est plus valide");
			App::redirect('Connection');
		}	
	}

	public function forget(){
		if(!empty($_POST) && !empty($_POST['email'])){
			if($this->auth->resetPassword($this->db,$_POST['email'])){
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
		if(isset($_GET['id']) && isset($_GET['token'])){
		$user = $this->auth->checkResetToken($this->db,$_GET['id'],$_GET['token']);
			if($user){
				if(!empty($_POST)){
					$validator = new Validator($_POST);
					$validator->isConfirmed('password');
					if($validator->isValid()){
						$password = $this->auth->hashPassword($_POST['password']);
						$this->auth->confirmReset($password,$_GET['id'],$this->db);
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