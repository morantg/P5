<?php
require('controller/frontend.php');


// Routing 
if (isset($_GET['action']) && $_GET['action']!= 'addComment' ){
    
    $request = $_GET['action'];
    $routeur = new Routeur($request);
    $routeur->renderController();
    }elseif(isset($_GET['action']) && $_GET['action'] === 'addComment'){
        addComment($_GET['id'], $_POST['author'], $_POST['comment']);
    }else{
    about();
}



