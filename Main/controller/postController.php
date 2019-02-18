<?php

class postController extends Controller{



	public function listPosts(){
		
		$session = Session::getInstance();
		$auth = App::getAuth();
    	$db = DBFactory::getMysqlConnexionWithPDO();
    	$postManager = new NewsManager($db); 
    	$posts = $postManager->getList();
      
		$this->render('listPostsView.php',array(
			'session' => $_SESSION,
			'post'    => $posts,
			'session_instance' => $session
		));
	}

	
	public function post(){

    	$auth = App::getAuth();
    	$db = DBFactory::getMysqlConnexionWithPDO();
   	 	$session = Session::getInstance();
    	$postManager = new NewsManager($db);
    	$commentManager = new CommentManager($db);

		$post = $postManager->getUnique((int)$_GET['id']);
    	$comments = $commentManager->getComments($_GET['id']);

		$this->render('PostView.php',array(
		'session' => $_SESSION,
		'post'    => $post,
		'comments'=> $comments,
		'session_instance' => $session
		));
	}

	
	public function editPosts(){

		$db = DBFactory::getMysqlConnexionWithPDO();
		$auth = App::getAuth();
		$auth->restrict_admin($db);
		$auth->restrict_superadmin($db);
		$users = $auth->users($db);
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
		
		$this->render('admin_view.php',array(
			'session' => $_SESSION,
			'new'    => $news,
			'manager' => $manager,
			'session_instance' => $session,
			'erreurs' => $erreurs,
			'users' => $users,
			'comments' => $comments
		));
	}


	public function addComment($postId, $author, $comment){

		$auth = App::getAuth();
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
		$this->render('PostView.php',array(
			'session' => $_SESSION
		));

	}


}