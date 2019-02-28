<?php

class postController extends Controller{

	private $db;
	private $postManager;
	private $commentManager;
	private $auth;
	private $session;


	public function __construct($db, $postManager, $commentManager, $auth, $session){
		$this->db = $db;
		$this->postManager = $postManager;
		$this->commentManager = $commentManager;
		$this->auth = $auth;
		$this->session = $session;
	}

	public function list(){
		$posts = $this->postManager->getList();
		$session_user = $_SESSION;
      	
      	$this->render('listView.php',array(
			'session' => $session_user,
			'post'    => $posts,
			'session_instance' => $this->session
		));
	}

	public function show(){
		$id = filter_input(INPUT_GET, 'id');
		$post = $this->postManager->getUnique($id);
    	$comments = $this->commentManager->getComments($id);
    	$session_user = $_SESSION;

		$this->render('PostView.php',array(
		'session' => $session_user,
		'post'    => $post,
		'comments'=> $comments,
		'session_instance' => $this->session
		));
	}

	public function edit(){
		$news = null;
		$erreurs = null;
		$this->auth->restrict();
		$this->auth->restrict_admin($this->db);
		
		$users = $this->auth->users($this->db);
		$comments = $this->commentManager->allCommentsUnpublished();
		
		$modifier = filter_input(INPUT_GET, 'modifier');
		$supprimer = filter_input(INPUT_GET, 'supprimer');
		$permission = filter_input(INPUT_POST, 'permission');
		$ids = filter_input(INPUT_POST, 'ids');
		$auteur = filter_input(INPUT_POST, 'auteur');
		$id = filter_input(INPUT_POST, 'id');
		$session_user = $_SESSION;

		if ($modifier)
		{
	  	$news = $this->postManager->getUnique($modifier);
		}
		if ($supprimer)
		{
	  	$this->postManager->delete($supprimer);
	  	$this->session->setFlash('success','La news a bien été supprimée !');
	  	App::redirect('Edition');
		}
		if ($permission){
			$id = filter_input(INPUT_POST, 'id');
			$this->auth->changer_permission($this->db, $permission, $id);
			$this->session->setFlash('success','La nouvelle permission a bien été adoptée !');
			App::redirect('Edition');
		}
		if ($ids){
  			$this->commentManager->publication($ids);
			$this->session->setFlash('success','les commentaires ont bien été publiés !');
			App::redirect('Edition');
		}
		if ($auteur)
		{
	  		$titre = filter_input(INPUT_POST, 'titre');
			$contenu = filter_input(INPUT_POST, 'contenu');
	  		$news = new News(
	    		[
	      		'auteur' => $auteur,
	      		'titre' => $titre,
	      		'contenu' => $contenu
	    		]
	  		);
	  		
	  		if ($id)
	  		{
	  		 $news->setId($id);
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
			'session' => $session_user,
			'new'    => $news,
			'manager' => $this->postManager,
			'session_instance' => $this->session,
			'erreurs' => $erreurs,
			'users' => $users,
			'comments' => $comments
		));
	}

	public function addComment(){
		$session_user = $_SESSION;
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
		$this->render('PostView.php',array('session' => $session_user));
	}
}