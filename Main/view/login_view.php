{% extends 'templates.php' %}

{% block content %}

<a href="index.php?action=register">Vous n'avez pas de compte? Créer en un ici.</a>

<h1>Se connecter</h1>

<form action="" method="POST">
	<div class="form-group floating-label-form-group controls">
		<label for="username">Pseudo ou email</label>
		<input type="text" name="username" class="form-control" placeholder="Pseudo ou email" />
	</div>	
	<div class="form-group floating-label-form-group controls">
		<label for="password">Mot de passe</label>
		<input type="password" name="password" class="form-control" placeholder="Mot de passe" />
	</div>
	<br><a href="index.php?action=forget">J'ai oublié mon mot de pase</a><br><br>
	<div class="form-group">
		<label>
			<input type="checkbox" name="remember" value="1"/> Se souvenir de moi
		</label>
	</div>		
	<button type="submit" class="btn btn-primary">Se connecter</button>
</form>

{% endblock %}