<?php require 'inc/header.php'; ?>

<h1>Se connecter</h1>

<form action="" method="POST">
	<div class="form-group">
		<label for="">Pseudo ou email</label>
		<input type="text" name="username" class="form-control" />
	</div>	
	<div class="form-group">
		<label for="">Mot de passe <a href="index.php?action=forget">(J'ai oublié mon mot de pase)</a></label>
		<input type="password" name="password" class="form-control" />
	</div>
	<div class="form-group">
		<label>
			<input type="checkbox" name="remember" value="1"/> Se souvenir de moi
		</label>
	</div>		
	<button type="submit" class="btn btn-primary">Se connecter</button>
</form>

<?php require 'inc/footer.php'; ?>