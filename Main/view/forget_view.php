{% extends 'templates.php' %}

{% block content %}

<h1>Mot de passe oublié</h1>

<form action="" method="POST">
	<div class="form-group">
		<label for="">Email</label>
		<input type="email" name="email" class="form-control" />
	</div>	
	<button type="submit" class="btn btn-primary">Envoyer</button>
</form>

{% endblock %}