{% extends 'templates.php' %}

{% block content %}

<h1> Bonjour {{session['auth'].username}} </h1> 

<form action="" method="post">
	<div class="form-group">
		<input class="form-control" type="password" name="password" placeholder="changer de mdp"/>
	</div>
	<div class="form-group">
		<input class="form-control" type="password" name="password_confirm" placeholder="confirmation"/>
	</div>
	<button class="btn btn-primary">changer mon mdp</button>
</form>

{% endblock %}
