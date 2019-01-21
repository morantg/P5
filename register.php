<?php

require_once 'inc/bootstrap.php';




$db = DBFactory::getMysqlConnexionWithPDO();

$user = $db ->query('SELECT * from users ')->fetchAll();


if(!empty($_POST)){
	$errors = array();

	$validator = new validator($_POST);
	$validator->isAlpha('username',"Votre pseudo n'est pas valide (alphanumérique)");
	
	if($validator->isValid()){

		$validator->isUniq('username', $db,'users','Ce pseudo est pris');
	}
	
	$validator->isEmail('email',"email non valide");
	
	if($validator->isValid()){
	$validator->isUniq('email', $db,'users','Ce mail est déjà pris');

}
	$validator->isConfirmed('password','vous devez rentrer un mdp valide');


	
	if($validator->isValid()){
	

	

	App::getAuth()->register($db,$_POST['username'],$_POST['password'],$_POST['email']);

	

	Session::getInstance()->setFlash('success','email de confirmation envoyé');

    App::redirect('login.php');
	
	}else{

		$errors = $validator->getErrors(); 
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

