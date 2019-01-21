<?php 
require 'inc/header.php'; 
$title = htmlspecialchars($post->titre); ?>

<h1>Mon super blog !</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        <?= htmlspecialchars($post->titre) ?>
        <em>le <?= $post->creation_date_fr ?></em>
    </h3>
    
    <p>
        <?= nl2br(htmlspecialchars($post->contenu)) ?>
    </p>
</div>


<?php require 'inc/footer.php'; ?>