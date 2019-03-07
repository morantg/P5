# P5

# Installation de l'application

Commencer par créer un virtual host que vous appellerez projet5.local

Télécharger et mettez y tous les fichiers du repository.

Attention si vous voulez utiliser un autre nom que projet5.local pour votre virtual
host veuillez changer les 2 liens qui ce trouve dans la classe Auth dans le fichier
model, dans les fonctions register et resetPasword.

Ensuite créez une base de donnée et importez y le fichier p5_blog.sql présent à 
la racine du repository.

Remplissez le fichier config.php à la racine du repository avec vos identifiant.

3 compte son préparés pour tester l'application.

un compte superadmin -> login : admin
		        mdp : admin

un compte admin -> login : user2
		   mdp : 123 

un compte user -> login : user1
		   mdp : 123  	

Pour pouvoir tester aisément l'application en local je vous conseil d'utiliser maildev pour 
tester facilement tout les envois et récupération de liens.

tuto maildev : https://www.grafikart.fr/tutoriels/maildev-tester-emails-595

# Alalyse

Analyse codacy du projet : https://app.codacy.com/project/morantg/P5/dashboard