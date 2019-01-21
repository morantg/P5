<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Mon projet</title>

    <!-- Bootstrap core CSS -->
    <link href="css/app.css" rel="stylesheet">

    
  </head>

  <body>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Mon projet</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            {% if session['auth'] %}
              <li><a href="index.php?action=listPosts">Posts</a></li>
            <!--<?php if(isset($admin)): ?>  
              <li><a href="index.php?action=editPosts">Edition</a></li>
            <?php endif; ?>-->  
              <li><a href="index.php?action=logout">deco</a></li>
            {% else %}
            <li><a href="index.php?action=listPosts">Posts</a></li> 
            <li><a href="index.php?action=register">S'inscrire</a></li>
            <li><a href="index.php?action=login">Se connecter</a></li>
          {% endif %}
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      
       {% if session_instance.hasFlashes %}

       {% for keys, message in session_instance.getFlashes  %}

      <br /><div class="alert alert-{{ keys }}"> {{ message }} </div>

       {% endfor %}
       
       {% endif %}
        
       {% block content %}{% endblock %}
    </div>
  </body>
</html>       






      