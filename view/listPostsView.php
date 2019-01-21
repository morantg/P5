<?php require 'inc/header.php'; ?>

<?php $title = 'Mon blog'; ?>

<h1>Mon super blog !</h1>
<h4>Derniers billets du blog :</h4>

<?php
while ($data = $posts->fetch(PDO::FETCH_ASSOC))
{
?>
    <div class="news">
        <h3>
            <?= $data['titre'] ?>
            <em>le <?= $data['creation_date_fr'] ?></em>
        </h3>
        
        <p>
            <?= $data['contenu'] ?>
            <br />
            <em><a href="index.php?action=post&amp;id=<?= $data['id'] ?>">Commentaires</a></em>
        </p>
    </div>
<?php
}
$posts->closeCursor();
?>

<?php require 'inc/footer.php'; ?>
