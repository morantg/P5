{% extends 'templates/template_default.php' %}

{% block content %}

<h1>Réinitialiser mon mdp</h1>

<form action="" method="POST">
	<div class="form-group floating-label-form-group controls">
		<label for="password">Mot de passe</label>
		<input type="password" name="password" class="form-control" placeholder="Mot de passe" />
	</div>
	<div class="form-group floating-label-form-group controls">
		<label for="password_confirm">Confirmation du mot de passe</label>
		<input type="password" name="password_confirm" class="form-control" placeholder="Confirmation du mot de passe" />
	</div>		
	<br><button type="submit" class="btn btn-primary">Réinitialiser mon mdp</button>
</form>

{% endblock %}
