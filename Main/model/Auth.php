<?php

class Auth{

	private $options = ['restriction_msg'=>"Vous n'avez pas le droit d'accéder à cette page" ];
	private $session;

	public function __construct($session,$options = []){
		$this->options = array_merge($this->options,$options);
		$this->session = $session;
	}

  /**
   * Crée une clé de hachage pour un mot de passe
   * @param $password string
   * @return string 
   */
	public function hashPassword($password){
		return password_hash($password, PASSWORD_BCRYPT);
	}

  /**
   * @param $password string
   * @param $bd PDO
   * @param $id int 
   */
	public function passwordUpdate($password, $db, $id){
		$req = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
		$req->execute([$password, $id]);
	}

  /**
   * Méthode permettant d'enregister un utilisateur et de lui envoyer un mail de confirmation
   * @param $db PDO 
   * @param $username string 
   * @param $password string 
   * @param $email string
   */
	public function register($db,$username,$password,$email){
		$password = $this->hashPassword($password);
		$token = App::random(60);
			
		$req = $db->prepare("INSERT INTO users SET username = ?,password = ?,email = ?, confirmation_token = ?");
		$req->execute([$username,$password, $email,$token]);
		$user_id = $db->lastInsertId();

		mail($email, "confirmation compte","afin de valider votre compte merci de cliquer sur ce lien\n\nlocalhost/Openclassrooms/Projet/P5/Main/index.php?action=auth.confirm&id=$user_id&token=$token");
	}

  /**
   * Permet de valider le compte d'un utilisateur
   * @param $db PDO
   * @param $user_id int
   * @param $token string
   * @return bool
   */
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

  /**
   * Bloque la page si l'utilisateur n'est pas authentifié 
   */
	public function restrict(){
		if (!$this->session->read('auth')){
			$this->session->setFlash('danger',$this->options['restriction_msg']);
			App::redirect('Connection');
		}
	}

  /**
   * Bloque la page si l'utilisateur n'est pas administrateur 
   * @param $bd PDO
   * @return bool
   */
	public function restrict_admin($db){
		$permission = $this->session->readWithParam('auth','permission');
		if ($permission === 'user'){
			$this->session->setFlash('danger',$this->options['restriction_msg']);
			App::redirect('News');
		}
	}

  /**
   * Retourne l'utilisateur courant si il y en a un
   * @return bool
   * @return stdClass Contient les informations de l'utilisateur
   */
	public function user(){
		if (!$this->session->read('auth')){
			return false;
		}
		return $this->session->read('auth');
	}

  /**
   * Méthode permettant sélectionner tout les utilisateurs hormis le superadministrateur
   * @param $db PDO
   * @return stdClass
   */
	public function users($db){
		$req = $db ->query("SELECT * from users WHERE permission != 'superadmin'");
		$users = $req->fetchAll();
		return $users;
	}

  /**
   * Méthode permettant d'assigner les informations utilisateurs à la variable session auth
   * @param $user stdClass informations de l'utilisateur
   */
	public function connect($user){
		$this->session->write('auth',$user);
	}

  /**
   * Méthode permettant de connecter l'utilisateur grace a un cookie si il a coché la case se souvenir de moi 
   * @param $db PDO
   */
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

  /**
   * Méthode permettant de connecter l'utilisateur
   * @param $db PDO
   * @param $username string
   * @param $password string
   * @param $remember bool
   * @return bool
   */
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

  /**
   * Méthode permettant de changer la permission d'un utilisateur
   * @param $db PDO
   * @param $permission string
   * @param $id int
   * @return void
   */
	public function changer_permission($db,$permission,$id){
		$req = $db->prepare('UPDATE users SET permission = ? WHERE id = ? ');
		$req->execute([$permission, $id]);
	}

  /**
   * Méthode créant un cookie pour connecter l'utilisateur automatiquement
   * @param $db PDO
   * @param $user_id int
   * @return void
   */
	public function remember($db,$user_id){
		$remember_token = App::random(250);
		$req = $db->prepare('UPDATE  users SET remember_token = ? WHERE id = ?');
		$req->execute([$remember_token, $user_id]);
		setcookie('remember', $user_id. '=='. $remember_token.sha1($user_id .'testsha'),time() + 60*60*24*7);
	}

  /**
   * Détruit le cookie permettant la reconnection de l'utilisateur
   * @return void
   */
	public function logout(){
		setcookie('remember',NULL,-1);
		$this->session->delete('auth');
	}

  /**
   * Envoi un mail a l'utilisateur en cas de perte de mot de passe pour qu'il puisse en choisir un nouveau
   * @param $db PDO
   * @param $email string
   * @return bool
   */
	public function resetPassword($db,$email){
		$req = $db->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
		$req->execute([$email]);
		$user = $req->fetch();
		if($user){
			$reset_token = App::random(60);
			$req = $db->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?');
			$req->execute([$reset_token,$user->id]);
						
			mail($_POST['email'], "réinitialisation de votre mot de passe ","afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nlocalhost/Openclassrooms/Projet/P5/Main/index.php?action=auth.reset_password&id={$user->id}&token=$reset_token");
			return $user;
		}
		return false;
	}

  /**
   * Permet de donner un nouveau mot de passe à l'utilisateur en cas d'oublie
   * @param $password string
   * @param $id int
   * @param $db PDO
   */
	public function confirmReset($password,$id,$db){
		$req = $db->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL WHERE id = ?');
		$req->execute([$password,$id]);
	}
	
  /**
   * @param $db PDO
   * @param $user_id int
   * @param $token string
   * @return bool
   */
	public function checkResetToken($db,$user_id,$token){
		$req = $db->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(),INTERVAL 30 MINUTE)');
		$req->execute([$user_id, $token]);
		$ret = $req->fetch();
		return $ret;
	}
}