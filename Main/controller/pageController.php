<?php

class pageController extends Controller{

	private $db;
	private $session;

	public function __construct($db, $session){
		$this->db = $db;
		$this->session = $session;
	}	
	
	public function about(){
		$about = new About($this->db);
		$contenu = $about->getAbout();

		if(isset($_POST['about'])){
			$about->editAbout($_POST['about']);
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


}
