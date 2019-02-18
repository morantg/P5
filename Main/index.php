<?php

require('../vendor/autoload.php');
require 'model/autoload.php';



// Routing 
if (isset($_GET['action'])){

	if($_GET['action'] == 'post'){

	$request = $_GET['action'];
   	$controller = new postController();
   	$controller->$request();

   }elseif($_GET['action'] == 'login'){

	$request = $_GET['action'];
   	$controller = new authController();
   	$controller->$request();
   
   }elseif($_GET['action'] == 'account'){

	$request = $_GET['action'];
   	$controller = new authController();
   	$controller->$request();
   
   }elseif($_GET['action'] == 'listPosts'){

	$request = $_GET['action'];
   	$controller = new postController();
   	$controller->$request();
   
   }elseif($_GET['action'] == 'logout'){

	$request = $_GET['action'];
   	$controller = new authController();
   	$controller->$request();
   
   }elseif($_GET['action'] == 'register'){

	$request = $_GET['action'];
   	$controller = new authController();
   	$controller->$request();
   
   }elseif($_GET['action'] == 'confirm'){

	$request = $_GET['action'];
   	$controller = new authController();
   	$controller->$request();

   }elseif($_GET['action'] == 'forget'){

	$request = $_GET['action'];
   	$controller = new authController();
   	$controller->$request();

   }elseif($_GET['action'] == 'reset_password'){

	$request = $_GET['action'];
   	$controller = new authController();
   	$controller->$request();

   }elseif($_GET['action'] == 'editPosts'){

	$request = $_GET['action'];
   	$controller = new postController();
   	$controller->$request();

   }elseif($_GET['action'] == 'about'){

	$request = $_GET['action'];
   	$controller = new pageController();
   	$controller->$request();
   
   }elseif($_GET['action'] == 'contact'){

	$request = $_GET['action'];
   	$controller = new pageController();
   	$controller->$request();
   
   }elseif($_GET['action'] == 'addComment'){

	$request = $_GET['action'];
   	$controller = new postController();
   	$controller->$request($_GET['id'], $_POST['author'], $_POST['comment']);
   }			

}else{
	$controller = new postController();
	$controller->listPosts();

}














