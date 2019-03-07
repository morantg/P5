<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mon blog</title>

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="/css/clean-blog.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

  </head>
  <body>
     <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="/News">Mon blog</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            {% if session['auth'] %}
            <li class="nav-item">
              <a class="nav-link" href="/Main/Apropos">A propos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Main/News">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Main/MonCompte">Mon compte</a>
            </li>
            {% if session['auth'].permission == 'superadmin' or session['auth'].permission == 'admin'  %} 
            <li class="nav-item">
              <a class="nav-link" href="/Main/Edition">Edition</a>
            </li>
            {% endif %}
            <li class="nav-item">
              <a class="nav-link" href="/Main/Contact">Me contacter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?action=auth.logout">Se déconnecter</a>
            </li>
            {% else %}
            <li class="nav-item">
              <a class="nav-link" href="/Apropos">A propos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/News">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Inscription">S'inscrire</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Connection">Se connecter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Contact">Me contacter</a>
            </li>
            {% endif %}
          </ul>
        </div>
      </div>
    </nav>
   <!-- Page Header -->
    <header class="masthead" style="background-image: url('/img/contact-bg.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="page-heading">
              <h1>Contactez Moi</h1>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          {% if session_instance.hasFlashes %}

          {% for keys, message in session_instance.getFlashes  %}

          <br /><div class="alert alert-{{ keys }}"> {{ message }} </div>

          {% endfor %}
       
          {% endif %}
          
          {% block content %}{% endblock %}
        </div>
      </div>
    </div>
    
    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <ul class="list-inline text-center">
              <li class="list-inline-item">
                <a href="https://twitter.com/">
                  <span class="fa-stack fa-lg">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="https://facebook.com/">
                  <span class="fa-stack fa-lg">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="https://github.com/morantg">
                  <span class="fa-stack fa-lg">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
            </ul>
            <p class="copyright text-muted">Copyright &copy; P5_blog 2018</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="/js/clean-blog.min.js"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=pk1okg92xbl4ryit35pzoygyhrvm2dsq9aqvcfitrmnkvbyn"></script>
    <script>tinymce.init({ 
      mode : "specific_textareas",
      editor_selector : "mceEditor",
      entity_encoding : "raw",
      encoding: "UTF-8" 
    });</script>

  </body>
</html>       






      