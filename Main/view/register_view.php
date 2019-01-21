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
	<div class="form-group floating-label-form-group controls">
		<label for="">Pseudo</label>
		<input type="text" name="username" class="form-control" placeholder="Pseudo" />
	</div>	
	<div class="form-group floating-label-form-group controls">
		<label for="">Email</label>
		<input type="text" name="email" class="form-control" placeholder="Email" />
	</div>	
	<div class="form-group floating-label-form-group controls">
		<label for="">Mot de passe</label>
		<input type="password" name="password" class="form-control" placeholder="Mot de passe" />
	</div>	
	<div class="form-group floating-label-form-group controls">
		<label for="">Confirmez votre mot de passe</label>
		<input type="password" name="password_confirm" class="form-control" placeholder="confirmez votre mot de passe" />
	</div>
	<br>	
	<button type="submit" class="btn btn-primary">M'inscrire</button>
</form>

{% endblock %}
	