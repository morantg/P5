<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mon blog</title>

    <!-- Bootstrap core CSS -->
    <link href="/Openclassrooms/projet/P5/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="/Openclassrooms/projet/P5/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="/Openclassrooms/projet/P5/Main/css/clean-blog.min.css" rel="stylesheet">
    <link href="/Openclassrooms/projet/P5/Main/css/style.css" rel="stylesheet">

  </head>
  <body>
     <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="index.php">Mon blog</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            {% if session['auth'] %}
            <li class="nav-item">
              <a class="nav-link" href="/Openclassrooms/Projet/P5/Main/Apropos">A propos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Openclassrooms/Projet/P5/Main/News">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Openclassrooms/Projet/P5/Main/MonCompte">Mon compte</a>
            </li>
            {% if session['admin'] %} 
            <li class="nav-item">
              <a class="nav-link" href="/Openclassrooms/Projet/P5/Main/Edition">Edition</a>
            </li>
            {% endif %}
            <li class="nav-item">
              <a class="nav-link" href="/Openclassrooms/Projet/P5/Main/Contact">Me contacter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?action=auth.logout">Se déconnecter</a>
            </li>
            {% else %}
            <li class="nav-item">
              <a class="nav-link" href="/Openclassrooms/Projet/P5/Main/Apropos">A propos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Openclassrooms/Projet/P5/Main/News">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Openclassrooms/Projet/P5/Main/Inscription">S'inscrire</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Openclassrooms/Projet/P5/Main/Connection">Se connecter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Openclassrooms/Projet/P5/Main/Contact">Me contacter</a>
            </li>
            {% endif %}
          </ul>
        </div>
      </div>
    </nav>
   <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/about-bg.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="page-heading">
              <h1>{{ title_about }}</h1>
              <span class="subheading">This is what I do.</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
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
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
            </ul>
            <p class="copyright text-muted">Copyright &copy; Your Website 2018</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/clean-blog.min.js"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=expsirpgv36h6sccv64i0qrvz1cvboujrff5y5okhma2g5oz"></script>
    <script>tinymce.init({ 
      mode : "specific_textareas",
      editor_selector : "mceEditor",
      entity_encoding : "raw",
      encoding: "UTF-8" 
    });</script>

  </body>
</html>       






      