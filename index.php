<?php
require('controller/frontend.php');
//require 'inc/bootstrap.php';
	
if (isset($_GET['action'])) {
 
 	if ($_GET['action'] == 'register') {
           register();
        }elseif($_GET['action'] == 'login'){
        	login();
        }elseif($_GET['action'] == 'logout'){
        	logout();
        }elseif ($_GET['action'] == 'confirm') {
        	confirm();
        }elseif($_GET['action'] == 'account'){
        	account();
        }elseif ($_GET['action'] == 'forget') {
        	forget();
        }elseif ($_GET['action'] == 'reset_password') {
            reset_password();
        }elseif($_GET['action'] == 'listPosts') {
            listPosts();
        }elseif ($_GET['action'] == 'post') {
             post();
        }elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                }
            }
            
        }
    
    }
    else{
        listPosts();
}





        