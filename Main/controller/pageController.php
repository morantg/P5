<?php

class pageController extends Controller{

	
	public function about(){

		$db = DBFactory::getMysqlConnexionWithPDO();
		$title_about = App::getTitleAbout();
		$session = Session::getInstance();
		$about = new About($db);
		$contenu = $about->getAbout();

		if(isset($_POST['about'])){
			$about->editAbout($_POST['about']);
			App::redirect('index.php?action=post.editPosts');
		}
		
		$this->render('about_view.php',array(
			'session' => $_SESSION,
			'title_about' => $title_about,
			'contenu' => $contenu
		));
	}


	public function contact(){

		$session = Session::getInstance();
		$errors = array();

		if(!empty($_POST)){
			$validator = new validator($_POST);
			
			$validator->isEmail('email',"email non valide");
			$validator->isEmpty('objet',"veuillez mettre un objet pour votre message");
			$validator->isEmpty('message',"votre message est vide");
			
			if($validator->isValid()){
				mail("gmorant@gmail.com",$_POST['objet'] ,$_POST['message']);
				$session->setFlash('success','votre message a bien été envoyé');
				App::redirect('index.php?action=page.contact');
			}else{
				$errors = $validator->getErrors(); 
			}
		}
		$this->render('contact_view.php',array(
			'session' => $_SESSION,
			'errors' => $errors,
			'session_instance' => $session
		));
	}


}
