<?php

class postController extends Controller{

	public function __construct(){
		$this->db = DBFactory::getMysqlConnexionWithPDO();
		$this->postManager = new NewsManager($this->db);
		$this->commentManager = new CommentManager($this->db);
		$this->auth = App::getAuth();
		$this->session = Session::getInstance();
	}

	public function list(){
		$posts = $this->postManager->getList();
      	
      	$this->render('listView.php',array(
			'session' => $_SESSION,
			'post'    => $posts,
			'session_instance' => $this->session
		));
	}

	public function show(){
		$post = $this->postManager->getUnique((int)$_GET['id']);
    	$id = filter_input(INPUT_GET, 'id');
    	$comments = $this->commentManager->getComments($id);

		$this->render('PostView.php',array(
		'session' => $_SESSION,
		'post'    => $post,
		'comments'=> $comments,
		'session_instance' => $this->session
		));
	}

	public function edit(){
		$news = null;
		$erreurs = null;
		$this->auth->restrict_admin($this->db);
		$this->auth->restrict_superadmin($this->db);
		$users = $this->auth->users($this->db);
		$comments = $this->commentManager->allCommentsUnpublished();

		if (isset($_GET['modifier']))
		{
	  	$news = $this->postManager->getUnique((int) $_GET['modifier']);
		}
		if (isset($_GET['supprimer']))
		{
	  	$this->postManager->delete((int) $_GET['supprimer']);
	  	$this->session->setFlash('success','La news a bien été supprimée !');
	  	App::redirect('Edition');
		}
		if (isset($_POST['permission'])){
			
			$this->auth->changer_permission($this->db, $_POST['permission'], $_POST['id']);
			$this->session->setFlash('success','La nouvelle permission a bien été adoptée !');
			App::redirect('Edition');
		}
		if (isset($_POST['ids'])){

			$this->commentManager->publication($_POST['ids']);
			$this->session->setFlash('success','les commentaires ont bien été publiés !');
			App::redirect('Edition');
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
		   	 $this->postManager->save($news);
		    	if($news->isNew()){
		   	 		$this->session->setFlash('success','La news a bien été ajoutée !');
		   	 	}else{
		   	 		$this->session->setFlash('success','La news a bien été modifiée !');
		   	 	}
		   	 	App::redirect('Edition');
	    	}else{
	    		$erreurs = $news->erreurs();
			}
		}
		$this->render('adminView.php',array(
			'session' => $_SESSION,
			'new'    => $news,
			'manager' => $this->postManager,
			'session_instance' => $this->session,
			'erreurs' => $erreurs,
			'users' => $users,
			'comments' => $comments
		));
	}

	public function addComment(){
		if (empty($_POST['comment'])) {
	        $this->session->setFlash('danger','commentaire vide');
	        App::redirect('/Openclassrooms/Projet/P5/Main/News/' . $_GET['id']);
		}
		$affectedLines = $this->commentManager->postComment($_GET['id'], $_POST['author'], $_POST['comment']);
		if ($affectedLines === false) {
	        throw new Exception('Impossible d\'ajouter le commentaire !');
	    }else {
	    	$this->session->setFlash('success','votre message a été soumis a la publication');
	    	App::redirect('/Openclassrooms/Projet/P5/Main/News/' . $_GET['id']);
		}
		$this->render('PostView.php',array('session' => $_SESSION));
	}
}