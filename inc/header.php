<?php 
$auth = App::getAuth();
if(isset($_SESSION['auth'])){
$db = DBFactory::getMysqlConnexionWithPDO(); 
$admin = Validator::isAdmin($db,$_SESSION['auth']->id);
}
?>
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
            <?php if(isset($_SESSION['auth'])): ?>
              <li><a href="index.php?action=listPosts">Posts</a></li>
            <?php if($admin): ?>  
              <li><a href="index.php?action=editPosts">Edition</a></li>
            <?php endif; ?>  
              <li><a href="index.php?action=logout">deco</a></li>
            <?php else: ?>
            <li><a href="index.php?action=listPosts">Posts</a></li> 
            <li><a href="index.php?action=register">S'inscrire</a></li>
            <li><a href="index.php?action=login">Se connecter</a></li>
          <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
        <?php 

       
        if( Session::getInstance()->hasFlashes()) {
            foreach(Session::getInstance()->getFlashes() as $type => $message) {
                echo "<br /><div class=\"alert alert-$type\"> $message </div>";
            }
            unset($_SESSION['flash']);
        }
        ?>

        






      
