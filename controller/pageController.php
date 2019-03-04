<?php

class pageController extends Controller{

	private $mysql_db;
	private $session;

	public function __construct($mysql_db, $session){
		$this->mysql_db = $mysql_db;
		$this->session = $session;
	}	
	
	public function about(){
		$about = new About($this->mysql_db);
		$contenu = $about->getAbout();
		$about_edit = filter_input(INPUT_POST,'about');
		if($about_edit){
			$about->editAbout($about_edit);
			$this->session->setFlash('success','La section a propos a bien été éditée');
			App::redirect('Edition');
		}
		
		$this->render('aboutView.php',array(
			'session' => $_SESSION,
			'contenu' => $contenu
		));
	}

	public function contact(){
		$errors = array();

		if(!empty($_POST)){
			$validator = new validator($_POST);
			
			$validator->isEmail('email',"email non valide");
			$validator->isEmpty('objet',"veuillez mettre un objet pour votre message");
			$validator->isEmpty('message',"votre message est vide");
			
			if($validator->isValid()){
				mail("gmorant@gmail.com",$_POST['objet'] ,$_POST['message']);
				$this->session->setFlash('success','votre message a bien été envoyé');
				App::redirect('Contact');
			}else{
				$errors = $validator->getErrors(); 
			}
		}
		$this->render('contactView.php',array(
			'session' => $_SESSION,
			'errors' => $errors,
			'session_instance' => $this->session
		));
	}

	public function notFound(){
		$this->render('404.php',array(
			'session' => $_SESSION,
		));
	}


}
