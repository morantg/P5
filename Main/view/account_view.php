{% extends 'templates.php' %}

{% block content %}

<h1> Bonjour {{session['auth'].username}} </h1> 

<form action="" method="post">
	<div class="form-group floating-label-form-group controls">
		<label for="password">Mot de passe</label>
		<input class="form-control" type="password" name="password" placeholder="changer de mdp"/>
	</div>
	<div class="form-group floating-label-form-group controls">
		<label for="password_confirm">confirmation</label>
		<input class="form-control" type="password" name="password_confirm" placeholder="confirmation"/>
	</div>
	<br>
	<button class="btn btn-primary">changer mon mdp</button>
</form>

{% endblock %}
