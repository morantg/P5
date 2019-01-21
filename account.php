<?php 


require 'inc/functions.php';
logged_only();
if(!empty($_POST)){
	if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
		$_SESSION['flash']['danger'] = "les mdp ne corresponde pas";

	}else{
		$user_id = $_SESSION['auth']->id;
		$password= password_hash($_POST['password'],PASSWORD_BCRYPT);
		require_once 'inc/db.php';
		$pdo->prepare('UPDATE users SET password = ?')->execute([$password]);
		$_SESSION['flash']['success'] = "mdp mis a jour";
		
	}
}
require 'inc/header.php'; 

?>





<h1> Bonjour <?= $_SESSION['auth']->username; ?> </h1>

<form action="" method="post">
	<div class="form-group">
		<input class="form-control" type="password" name="password" placeholder="changer de mdp"/>
	</div>
	<div class="form-group">
		<input class="form-control" type="password" name="password_confirm" placeholder="confirmation"/>
	</div>
	<button class="btn btn-primary">changer mon mdp</button>






<?php require 'inc/footer.php'; ?>