<?php
require('../vendor/autoload.php');
require 'model/autoload.php';

function register()
{
	$twig = App::get_twig();
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
			App::redirect('index.php?action=login');
		}else{
			$errors = $validator->getErrors(); 
		}
	}
	echo $twig->render('register_view.php',array(
		'errors' => $errors
	));
}

function login()
{
	$twig = App::get_twig();
	$auth = App::getAuth();
	$db = DBFactory::getMysqlConnexionWithPDO();
	$auth->connectFromCookie($db);
	$session = Session::getInstance();
	
	if($auth->user()){
		App::redirect('index.php?action=account');
	}

	if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
		$user = $auth->login($db,$_POST['username'],$_POST['password'],isset($_POST['remember']));
		if ($user){
			$session->setFlash('success','Vous êtes maintenant connecté');
			App::redirect('index.php?action=account');
		}else{
			$session->setFlash('danger','Identifiant ou mot de passe incorrecte');
		}
	}
	echo $twig->render('login_view.php',array(
			'session_instance' => $session
	));
}

function logout()
{
	App::getAuth()->logout();
	Session::getInstance()->setFlash('success','vous etes deco');
	App::redirect('index.php?action=login');
}

function confirm()
{
	$db = DBFactory::getMysqlConnexionWithPDO();
	if(App::getAuth()->confirm($db, $_GET['id'], $_GET['token'], Session::getInstance())){
		Session::getInstance()->setFlash('success',"compte validé");
		App::redirect('index.php?action=account');
	}else{
		Session::getInstance()->setFlash('danger',"ce token n'est plus valide");
		App::redirect('index.php?action=login');
	}	
}

function account()
{
	$db = DBFactory::getMysqlConnexionWithPDO();
	$twig = App::get_twig();
	App::getAuth()->restrict();
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
		$req = $db->prepare('UPDATE users SET password = ?');
		$req->execute([$password]);
		$_SESSION['flash']['success'] = "mdp mis a jour";
		App::redirect('index.php?action=account');
	    }
	}
	echo $twig->render('account_view.php',array(
		'session' => $_SESSION,
		'session_instance' => $session_instance,
		'admin' => $admin 
	));
}

function forget()
{
	$twig = App::get_twig();
	$session = Session::getInstance();
	if(!empty($_POST) && !empty($_POST['email'])){
	$db = DBFactory::getMysqlConnexionWithPDO();	
	$auth = App::getAuth();
		if($auth->resetPassword($db,$_POST['email'])){
			$session->setFlash('success','les instructions du rappel de mot de passe vous ont été envoyées par emails');
			App::redirect('index.php?action=login');
		}else{
			$session->setFlash('danger','pas de correspondance');
			App::redirect('index.php?action=forget');
		}
	}
	echo $twig->render('forget_view.php',array(
			'session_instance' => $session

	)); 
}

function reset_password()
{
	$twig = App::get_twig();
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
					App::redirect('index.php?action=account');
				}
			}
		}else{
				Session::getInstance()->setFlash('danger',"ce token n'est plus valide");
				App::redirect('index.php?action=login');
			}
	}else{
			App::redirect('index.php?action=login');
		}
	echo $twig->render('reset_view.php'); 
}

function listPosts()
{
	$session = Session::getInstance();
	$twig = App::get_twig();
	$auth = App::getAuth();
    $db = DBFactory::getMysqlConnexionWithPDO();
    $postManager = new NewsManager($db); 
    $posts = $postManager->getList();
      
	echo $twig->render('listPostsView.php',array(
		'session' => $_SESSION,
		'post'    => $posts,
		'session_instance' => $session,
	));
}

function post()
{
	$twig = App::get_twig();
    $auth = App::getAuth();
    $db = DBFactory::getMysqlConnexionWithPDO();
    $session = Session::getInstance();
    $postManager = new NewsManager($db);
    $commentManager = new CommentManager($db);

	$post = $postManager->getUnique((int)$_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

	echo $twig->render('PostView.php',array(
		'session' => $_SESSION,
		'post'    => $post,
		'comments'=> $comments,
		'session_instance' => $session
	));
}

function addComment($postId, $author, $comment)
{
    $auth = App::getAuth();
    $twig = App::get_twig();
	$db = DBFactory::getMysqlConnexionWithPDO();
	$session = Session::getInstance();
    $commentManager = new CommentManager($db);

    if (empty($_POST['comment'])) {
        $session->setFlash('danger','commentaire vide');
        App::redirect('index.php?action=post&id=' . $postId);
	}

    $affectedLines = $commentManager->postComment($postId, $author, $comment);
	if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }else {
    	$session->setFlash('success','votre message a été soumis a la publication');
    	App::redirect('index.php?action=post&id=' . $postId);
	}
	echo $twig->render('PostView.php',array(
		'session' => $_SESSION
	));
}


function editPosts()
{
	$db = DBFactory::getMysqlConnexionWithPDO();
	$auth = App::getAuth();
	$auth->restrict_admin($db);
	$auth->restrict_superadmin($db);
	$users = $auth->users($db);
	$twig = App::get_twig();
	$session = Session::getInstance();
	$news = null;
	$erreurs = null;
	
	$manager = new NewsManager($db);
	$commentManager = new CommentManager($db);

	$comments = $commentManager->allCommentsUnpublished();

	if (isset($_GET['modifier']))
	{
  	$news = $manager->getUnique((int) $_GET['modifier']);
	}

	if (isset($_GET['supprimer']))
	{
  	$manager->delete((int) $_GET['supprimer']);
  	$session->setFlash('success','La news a bien été supprimée !');
  	App::redirect('index.php?action=editPosts');
	}

	if (isset($_POST['permission'])){
		
		$auth->changer_permission($db, $_POST['permission'], $_POST['id']);
		$session->setFlash('success','La nouvelle permission a bien été adoptée !');
		App::redirect('index.php?action=editPosts');
	}

	if (isset($_POST['ids'])){

		$commentManager->publication($_POST['ids']);
		$session->setFlash('success','les commentaires ont bien été publiés !');
		App::redirect('index.php?action=editPosts');
	}

	if (isset($_POST['auteur']))
	{
  		$news = new News(
    		[
      		'auteur' => $_POST['auteur'],
      		'titre' => $_POST['titre'],
      		'contenu' => $_POST['contenu']
    		]
  		);
  		
  		if (isset($_POST['id']))
  		{
   	 	$news->setId($_POST['id']);
  		}
  
  		if ($news->isValid())
  		{
	   	 $manager->save($news);
	    	if($news->isNew()){
	   	 		$session->setFlash('success','La news a bien été ajoutée !');
	   	 	}else{
	   	 		$session->setFlash('success','La news a bien été modifiée !');
	   	 	}
	   	 	App::redirect('index.php?action=editPosts');
    	}else{
    		$erreurs = $news->erreurs();
		}
  	}
	echo $twig->render('admin_view.php',array(
		'session' => $_SESSION,
		'new'    => $news,
		'manager' => $manager,
		'session_instance' => $session,
		'erreurs' => $erreurs,
		'users' => $users,
		'comments' => $comments
	));
}

function about(){
	$db = DBFactory::getMysqlConnexionWithPDO();
	$title_about = App::getTitleAbout();
	$twig = App::get_twig();
	$session = Session::getInstance();
	$about = new About($db);
	$contenu = $about->getAbout();

	if(isset($_POST['about'])){
		$about->editAbout($_POST['about']);
		App::redirect('index.php?action=editPosts');
	}
	
	
	echo $twig->render('about_view.php',array(
		'session' => $_SESSION,
		'title_about' => $title_about,
		'contenu' => $contenu
	));
}

function contact(){
	
	$twig = App::get_twig();
	$session = Session::getInstance();

	echo $twig->render('contact_view.php',array(
		'session' => $_SESSION
	));
}





