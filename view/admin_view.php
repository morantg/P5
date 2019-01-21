<?php require 'inc/header.php'; ?>
<h2>Edition</h2>
    
<form action="" method="post">
<p style="text-align: center">

<?php
if (isset($message))
{
  echo $message, '<br />';
}
?>
    <?php if (isset($erreurs) && in_array(News::AUTEUR_INVALIDE, $erreurs)) echo 'L\'auteur est invalide.<br />'; ?>
    Auteur : <input type="text" name="auteur" value="<?php if (isset($news)) echo $news->auteur(); ?>" /><br />
        
    <?php if (isset($erreurs) && in_array(News::TITRE_INVALIDE, $erreurs)) echo 'Le titre est invalide.<br />'; ?>
    Titre : <input type="text" name="titre" value="<?php if (isset($news)) echo $news->titre(); ?>" /><br />
        
    <?php if (isset($erreurs) && in_array(News::CONTENU_INVALIDE, $erreurs)) echo 'Le contenu est invalide.<br />'; ?>
    Contenu :<br /><textarea rows="8" cols="60" name="contenu"><?php if (isset($news)) echo $news->contenu(); ?></textarea><br />
<?php
if(isset($news) && !$news->isNew())
{
?>
        <input type="hidden" name="id" value="<?= $news->id() ?>" />
        <input type="submit" value="Modifier" name="modifier" />
<?php
}
else
{
?>
        <input type="submit" value="Ajouter" />
<?php
}
?>
      </p>
    </form>
    
    <p style="text-align: center">Il y a actuellement <?= $manager->count() ?> news. En voici la liste :</p>
    
    <table>
      <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
<?php
foreach ($manager->getList() as $news)
{
  echo '<tr><td>', $news->auteur(), '</td><td>', $news->titre(), '</td><td>', $news->dateAjout()->format('d/m/Y à H\hi'), '</td><td>', ($news->dateAjout() == $news->dateModif() ? '-' : $news->dateModif()->format('d/m/Y à H\hi')), '</td><td><a href="index.php?action=editPosts&modifier=', $news->id(), '">Modifier</a> | <a href="index.php?action=editPosts&supprimer=', $news->id(), '">Supprimer</a></td></tr>', "\n";
}
?>
    </table>


<?php require 'inc/footer.php'; ?>