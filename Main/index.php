<?php
require('controller/frontend.php');
//require 'inc/bootstrap.php';

// Routing  
try{
    if (isset($_GET['action'])) {

        switch ($_GET['action']) {
            case 'register':
                register();
                break;
            case 'login':
                login();
                break;
            case 'logout':
                logout();
                break;
            case 'confirm':
                confirm();
                break;
            case 'account':
                account();
                break;
            case 'forget':
                forget();
                break;
            case 'reset_password':
                reset_password();
                break;
            case 'editPosts':
                edition();
                break;
            case 'listPosts':
                listPosts();
                break;
            case 'post':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    post();
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
                break;
            case 'addComment':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
                break;  
            default:
                listPosts();
                break;
        }
    }else{
            listPosts();
        }
}

catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
