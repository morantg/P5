<?php require 'inc/header.php'; ?>

<h1>Réinitialiser mon mdp</h1>

<form action="" method="POST">
	<div class="form-group">
		<label for="">Mot de passe</label>
		<input type="password" name="password" class="form-control" />
	</div>
	<div class="form-group">
		<label for="">Confirmation du mot de passe</label>
		<input type="password" name="password_confirm" class="form-control" />
	</div>		
	<button type="submit" class="btn btn-primary">Réinitialiser mon mdp</button>
</form>

<?php require 'inc/footer.php'; ?>