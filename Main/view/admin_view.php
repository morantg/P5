{% extends 'templates.php' %}

{% block content %}

<h2>Edition</h2>
    
<form action="" method="post">
<p style="text-align: center">

{% if message %}

{{ message }}
<br>
{% endif %}

Auteur : <input type="text" name="auteur" value="{% if new %} {{ new.auteur }} {% endif %}" /><br />
Titre : <input type="text" name="titre" value="{% if new %} {{ new.titre }} {% endif %}" /><br />
Contenu :<br /><textarea rows="8" cols="60" name="contenu">{% if new %} {{ new.contenu }} {% endif %}</textarea><br />

{% if new and not new.isNew %}

<input type="hidden" name="id" value="{{ new.id }}" />
<input type="submit" value="Modifier" name="modifier" />

{% else %}

<input type="submit" value="Ajouter" />

{% endif %}
</p>
</form>
  <p style="text-align: center">Il y a actuellement {{ manager.count }} news. En voici la liste :</p>
  <table>
      <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
      
      {% for new in manager.getList %}

      <tr><td>{{ new.auteur }}</td><td>{{ new.titre }}</td><td>{{ new.dateAjout.format('d/m/Y à H\hi') }}</td><td>{{ (new.dateAjout == new.dateModif) ? '-' : new.dateModif.format('d/m/Y à H\hi') }}</td><td><a href="index.php?action=editPosts&modifier={{ new.id }}">Modifier</a> | <a href="index.php?action=editPosts&supprimer={{ new.id }}">Supprimer</a></td></tr><br>

      {% endfor %}  
  </table>

{% endblock %}

