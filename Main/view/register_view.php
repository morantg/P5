{% extends 'templates.php' %}

{% block content %}

<h1>S'inscrire</h1>

{% if errors is not empty %}
<div class="alert alert-danger">
	<p>vous n'avez pas rempli le form correctement</p>
	<ul>
	{% for error in errors %}
		<li>{{  error  }}</li>
	{% endfor %} 	
	</ul>
</div>
{% endif %}

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

{% endblock %}
	