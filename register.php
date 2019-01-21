<?php

require_once 'inc/functions.php';
session_start();

if(!empty($_POST)){
	$errors = array();
	require_once 'inc/db.php';

	if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
		$errors['username'] = "votre pseudo n'est pas valide(alphanumérique)";
	} else{
		$req = $pdo->prepare('SELECT id FROM users WHERE username = ?');
		$req->execute([$_POST['username']]);
		$user = $req->fetch();
		if($user){
			$errors['username'] = 'Ce pseudo est déjà pris';
		}

	}

	if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
		$errors['email'] = "email non valide";
	}else{
		$req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
		$req->execute([$_POST['email']]);
		$user = $req->fetch();
		if($user){
			$errors['email'] = 'Ce mail est déjà pris';
		}
	}	


	if(empty($_POST['password']) || $_POST['password']!= $_POST['password_confirm']){
		$errors['password'] = "vous devez rentrer un mdp valide";
	}

	
	if(empty($errors)){
	require_once 'inc/db.php';

	$req=$pdo->prepare ("INSERT INTO users SET username = ?,password = ?,email = ?, confirmation_token = ?");

	$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

	$token = str_random(60);


	$req->execute([$_POST['username'],$password, $_POST['email'],$token]);

	$user_id = $pdo->lastInsertId();

	mail($_POST['email'], "confirmation compte","afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/p5_blog/Comptes/confirm.php?id=$user_id&token=$token");
	$_SESSION['flash']['success'] = 'email envoyé';
	header('Location: login.php');
	exit();
	
	}

	

}



?>

<?php require 'inc/header.php'; ?>

<h1>S'inscrire</h1>

<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
	<p>vous n'avez pas rempli le form correctement</p>
	<ul>
	<?php foreach ($errors as $error): ?>
		<li><?= $error; ?></li>
	<?php endforeach; ?>	
		
	</ul>
</div>
<?php endif; ?>

<form action="" method="POST">
	
	<div class="form-group">
		<label for="">Pseudo</label>
		<input type="text" name="username" class="form-control" />
	</div>	

	<div class="form-group">
		<label for="">Email</label>
		<input type="text" name="email" class="form-control" />
	</div>	

	<div class="form-group">
		<label for="">Mot de passe</label>
		<input type="password" name="password" class="form-control" />
	</div>	

	<div class="form-group">
		<label for="">Confirmez votre mot de passe</label>
		<input type="password" name="password_confirm" class="form-control" />
	</div>	

	<button type="submit" class="btn btn-primary">M'inscrire</button>


</form>

<?php require 'inc/footer.php'; ?>

