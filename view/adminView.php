{% extends 'templates/template_default.php' %}

{% block content %}

<h2>Edition</h2>

{% if erreurs %}
  
  <div class="alert alert-danger">

{% for keys, message in erreurs  %}
  {{ message }}<br> 
{% endfor %}
 
 </div>

{% endif %}

<form action="" method="post">
  <div class="form-group floating-label-form-group controls">
  	<label for="auteur">Auteur</label>
  	<input type="text" name="auteur" class="form-control" value="{% if new %}{{ new.auteur }}{% endif %}" placeholder="Auteur" />
  </div>
  <div class="form-group floating-label-form-group controls">
	 <label for="titre">Titre</label>
	 <input type="text" name="titre" class="form-control" value="{% if new %}{{ new.titre }}{% endif %}" placeholder="Titre"  />
  </div>
  <div>
    <br>
  	<label for="contenu">Contenu</label>
  	<br /><textarea rows="8" cols="60" class="mceEditor" name="contenu">{% if new %} {{ new.contenu | raw }} {% endif %}</textarea><br />
  </div>

{% if new and not new.isNew %}

  <input type="hidden" name="id" value="{{ new.id }}" />
  <button type="submit" class="btn btn-primary">Modifier</button>

{% else %}

  <button type="submit" class="btn btn-primary">Ajouter</button>

{% endif %}

</form>
  
<br>
<h3> liste des news </h3>
<table>
  <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
        
  {% for new in manager.getList %}

    <tr><td>{{ new.auteur }}</td><td>{{ new.titre }}</td><td>{{ new.dateAjout.format('d/m/Y à H:i') }}</td><td>{{ (new.dateAjout == new.dateModif) ? '-' : new.dateModif.format('d/m/Y à H:i') }}</td><td><a href="/Modification/{{ new.id }}">Modifier</a>  <a href="index.php?action=post.edit&supprimer={{ new.id }}">Supprimer</a></td></tr>

  {% endfor %}  
</table>

{% if session['auth'].permission == 'superadmin' %} 

<br>
<h3> Liste des utilisateurs </h3>
<table>
  <tr><th>username</th><th>email</th><th>permission</th><th>changer permission</th></tr>

  {% for user in users %}

    <tr><td>{{user.username}}</td><td>{{ user.email }}</td><td>{{ user.permission }}</td>
      <td> 
        <form action="" method="POST" >
          <input type="hidden" name="id" value="{{ user.id }}" />
          <select name="permission">
            <option  value="user" {% if user.permission == 'user' %} selected {% endif %}>user</option>
            <option value="admin" {% if user.permission == 'admin' %} selected {% endif %}>admin</option>
          </select>
          <button type="submit" class="btn btn-primary">OK</button>
        </form>
      </td>
    </tr>

  {% endfor %}

</table>  

{% endif %}

<br>
<h3> Liste des commentaires </h3>
<form action="" method="POST">
  <table>
    <tr><th>id</th><th>post_id</th><th>author</th><th>comment</th><th>publication</th><th>supression</th></tr>

    {% for comment in comments %}
    
    <tr><td>{{ comment.id }}</td><td>{{ comment.post_id }}</td><td>{{ comment.author }}</td><td>{{ comment.comment }}</td>
      <td>
        <input type="checkbox" name="ids[]" value="{{ comment.id }}" />
      </td>
      <td>
        <input type="checkbox" name="delete_ids[]" value="{{ comment.id }}" />
      </td>
     </tr>
     {% endfor %}
  </table>  
 <br><button type="submit" class="btn btn-primary">valider</button>
</form>

{% endblock %}

