<?php

class Auth{

	private $options = ['restriction_msg'=>"Vous n'avez pas le droit d'accéder à cette page" ];
	private $session;

	public function __construct($session,$options = []){
		$this->options = array_merge($this->options,$options);
		$this->session = $session;
	}

	public function hashPassword($password){
		return password_hash($password, PASSWORD_BCRYPT);
	}

	public function register($db,$username,$password,$email){
		$password = $this->hashPassword($password);
		$token = App::random(60);
			
		$req = $db->prepare("INSERT INTO users SET username = ?,password = ?,email = ?, confirmation_token = ?");
		$req->execute([$username,$password, $email,$token]);
		$user_id = $db->lastInsertId();

		mail($email, "confirmation compte","afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/p5_test/Comptes/index.php?action=confirm&id=$user_id&token=$token");
	}

	public function confirm($db,$user_id,$token){
		$req = $db->prepare('SELECT * FROM users WHERE id = ?');
		$req->execute([$user_id]);
		$user= $req->fetch();

		if($user && $user->confirmation_token == $token){
			$req = $db->prepare('UPDATE users SET confirmation_token = NULL,confirmed_at = NOW() WHERE id = ?');
			$req->execute([$user_id]);
			$this->session->write('auth',$user);
			return true;
		}
		return false;
	}

	public function restrict(){
		if (!$this->session->read('auth')){
			$this->session->setFlash('danger',$this->options['restriction_msg']);
			App::redirect('index.php?action=login');
		}
	}

	public function restrict_admin($db){
		
		$admin = Validator::isAdmin($db,$_SESSION['auth']->id);
		if (!$admin){
			$this->session->setFlash('danger',$this->options['restriction_msg']);
			App::redirect('index.php?action=listPosts');
		}
	}


	public function user(){
		if (!$this->session->read('auth')){
			return false;
		}
		return $this->session->read('auth');
	}

	public function connect ($user){
		$this->session->write('auth',$user);
	}

	public function connectFromCookie($db){
		if (isset($_COOKIE['remember']) && !$this->user()) {
			$remember_token = $_COOKIE['remember'];
			$parts = explode('==', $remember_token);
			$user_id = $parts[0];
	
			$req = $db->prepare('SELECT * FROM users WHERE id = ?');
			$req->execute([$user_id]);
			$user = $req->fetch();
	
			if ($user) {
				$expected =$user_id. '=='. $user->remember_token .sha1($user_id .'testsha');
				if($expected == $remember_token){
					$this->connect($user);
					$_SESSION['auth'] = $user;
					setcookie('remember', $remember_token,time() + 60*60*24*7);
				}else{
					setcookie('remember', null, -1);
				}
			}else{
			setcookie('remember', null, -1);
			}
		}
	}

	public function login($db,$username,$password,$remember = false){
		$req = $db->prepare('SELECT * FROM users WHERE (username = :username OR email = :username AND confirmed_at IS NOT NULL)');
		$req->execute(['username' => $username]);
		$user = $req->fetch();

		if(password_verify($password, $user->password)){
			$this->connect($user);
			if($remember){
				$this->remember($db,$user->id);
			}
			return $req;
			
		}else{
			return false; 
		}
	}

	public function remember($db,$user_id){
		$remember_token = App::random(250);
		$req = $db->prepare('UPDATE  users SET remember_token = ? WHERE id = ?');
		$req->execute([$remember_token, $user_id]);
		setcookie('remember', $user_id. '=='. $remember_token.sha1($user_id .'testsha'),time() + 60*60*24*7);
	}

	public function logout(){
		setcookie('remember',NULL,-1);
		$this->session->delete('auth');
	}

	public function resetPassword($db,$email){
		$req = $db->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
		$req->execute([$email]);
		$user = $req->fetch();
		if($user){
			$reset_token = App::random(60);
			$req = $db->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?');
			$req->execute([$reset_token,$user->id]);
						
			mail($_POST['email'], "réinitialisation de votre mot de passe ","afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://localhost/p5_test/Comptes/index.php?action=reset_password&id={$user->id}&token=$reset_token");
			return $user;
		}
		return false;
	}
	
	public function checkResetToken($db,$user_id,$token){
		$req = $db->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(),INTERVAL 30 MINUTE)');
		$req->execute([$user_id, $token]);
		$ret = $req->fecth();
		return $ret;
	}
}