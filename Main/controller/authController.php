<?php

class authController extends Controller{




	public function login(){
		
		$auth = App::getAuth();
		$db = DBFactory::getMysqlConnexionWithPDO();
		$auth->connectFromCookie($db);
		$session = Session::getInstance();
	
		if($auth->user()){
		App::redirect('index.php?action=auth.account');
		}

		if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
		$user = $auth->login($db,$_POST['username'],$_POST['password'],isset($_POST['remember']));
			if ($user){
			$session->setFlash('success','Vous êtes maintenant connecté');
			App::redirect('index.php?action=auth.account');
			}else{
			$session->setFlash('danger','Identifiant ou mot de passe incorrecte');
			}
		}
		
		$this->render('login_view.php',array(
			'session_instance' => $session
		));
	}


	public function account(){

		$db = DBFactory::getMysqlConnexionWithPDO();
		$auth = App::getAuth();
		$auth->restrict();
		$validator = new validator($_POST);
		$admin = $validator->isAdmin($db,$_SESSION['auth']->id);
		$session_instance = Session::getInstance();
		if(!empty($_POST)){
			if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
				$_SESSION['flash']['danger'] = "les mdp ne corresponde pas";
		}else{
			$user_id = $_SESSION['auth']->id;
			$password= password_hash($_POST['password'],PASSWORD_BCRYPT);
			$db = DBFactory::getMysqlConnexionWithPDO();
			$auth->passwordUpdate($password, $db, $user_id );
			$_SESSION['flash']['success'] = "mdp mis a jour";
			App::redirect('index.php?action=auth.account');
	    	}
		}
		
		$this->render('account_view.php',array(
			'session' => $_SESSION,
			'session_instance' => $session_instance,
			'admin' => $admin 
		));
	}

	public function logout(){
		
		App::getAuth()->logout();
		Session::getInstance()->setFlash('success','vous etes deco');
		App::redirect('index.php?action=auth.login');
	}

	public function register(){

		$auth = App::getAuth();
		$errors = array();
		$db = DBFactory::getMysqlConnexionWithPDO();
		$user = $auth->users($db);
		if(!empty($_POST)){
			$validator = new validator($_POST);
			$validator->isAlpha('username',"Votre pseudo n'est pas valide (alphanumérique)");
			
			if($validator->isValid()){
				$validator->isUniq('username', $db,'users','Ce pseudo est pris');
			}
			$validator->isEmail('email',"email non valide");
			
			if($validator->isValid()){
				$validator->isUniq('email', $db,'users','Ce mail est déjà pris');
			}
			$validator->isConfirmed('password','vous devez rentrer un mdp valide');
			
			if($validator->isValid()){
				App::getAuth()->register($db,$_POST['username'],$_POST['password'],$_POST['email']);
				Session::getInstance()->setFlash('success','email de confirmation envoyé');
				App::redirect('index.php?action=auth.login');
			}else{
				$errors = $validator->getErrors(); 
			}
		}
		$this->render('register_view.php',array(
			'errors' => $errors
		));
	}


	public function confirm(){

		$db = DBFactory::getMysqlConnexionWithPDO();
		if(App::getAuth()->confirm($db, $_GET['id'], $_GET['token'], Session::getInstance())){
			Session::getInstance()->setFlash('success',"compte validé");
			App::redirect('index.php?action=auth.account');
		}else{
			Session::getInstance()->setFlash('danger',"ce token n'est plus valide");
			App::redirect('index.php?action=auth.login');
		}	
	}


	public function forget(){

		$session = Session::getInstance();
		if(!empty($_POST) && !empty($_POST['email'])){
		$db = DBFactory::getMysqlConnexionWithPDO();	
		$auth = App::getAuth();
			if($auth->resetPassword($db,$_POST['email'])){
				$session->setFlash('success','les instructions du rappel de mot de passe vous ont été envoyées par emails');
				App::redirect('index.php?action=auth.login');
			}else{
				$session->setFlash('danger','pas de correspondance');
				App::redirect('index.php?action=auth.forget');
			}
		}
		$this->render('forget_view.php',array(
				'session_instance' => $session
		)); 
	}

	public function reset_password(){

		if(isset($_GET['id']) && isset($_GET['token'])){
		$auth = App::getAuth();
		$db = DBFactory::getMysqlConnexionWithPDO();
		$user = $auth->checkResetToken($db,$_GET['id'],$_GET['token']);
			if($user){
				if(!empty($_POST)){
					$validator = new Validator($_POST);
					$validator->isConfirmed('password');
					if($validator->isValid()){
						$password = $auth->hashPassword($_POST['password']);
						$auth->confirmReset($password,$_GET['id'],$db);
						$auth->connect($user);
						Session::getInstance()->setFlash('success',"Votre mot de passe a bien été modifié");
						App::redirect('index.php?action=auth.account');
					}
				}
			}else{
					Session::getInstance()->setFlash('danger',"ce token n'est plus valide");
					App::redirect('index.php?action=auth.login');
				}
		}else{
				App::redirect('index.php?action=auth.login');
			}
		
		$this->render('reset_view.php');
	}





}