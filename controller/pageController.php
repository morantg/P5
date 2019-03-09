<?php

namespace controller;

class PageController extends Controller
{

    private $mysql_db;
    private $session;

    public function __construct($mysql_db, $session)
    {
        $this->mysql_db = $mysql_db;
        $this->session = $session;
    }
    
    public function about()
    {
        $this->render('aboutView.php', array('session' => $_SESSION,));
    }

    public function contact()
    {
        $errors = array();

        if (!empty($_POST)) {
            $validator = new \model\validator($_POST);
            
            $validator->isEmail('email', "email non valide");
            $validator->isEmpty('objet', "veuillez mettre un objet pour votre message");
            $validator->isEmpty('message', "votre message est vide");
            
            if ($validator->isValid()) {
                mail("admin@gmail.com", $_POST['objet'], $_POST['message']);
                $this->session->setFlash('success', 'votre message a bien été envoyé');
                \model\App::redirect('Contact');
            } else {
                $errors = $validator->getErrors();
            }
        }
        $this->render('contactView.php', array(
            'session' => $_SESSION,
            'errors' => $errors,
            'session_instance' => $this->session
        ));
    }

    public function notFound()
    {
        $this->render('404.php', array(
            'session' => $_SESSION,
        ));
    }
}
