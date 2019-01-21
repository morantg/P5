{% extends 'templates.php' %}

{% block content %}

<h1>Mon super blog !</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        {{ post.titre }}
        <em>le {{ post.creation_date_fr }}</em>
    </h3>
    
    <p> {{ post.contenu }} </p>
</div>

<h2>Commentaires</h2>

{% if session['auth'] %}   

<form action="index.php?action=addComment&amp;id={{ post.id }}" method="POST">
    <div>
        <label for="author">Auteur</label><br />
        <input type="text" id="author" name="author" class="form-control" />
    </div>
    <div>
        <label for="comment">Commentaire</label><br />
        <textarea id="comment" name="comment" class="form-control"></textarea>
    </div>
    <br>
        <button type="submit" class="btn btn-primary">Poster</button>
</form>
<br>
{% endif %}

{% for comment in comments %}

<p><strong>{{ comment.author }}</strong> le {{ comment.comment_date_fr }}</p>
<p>{{ comment.comment }}</p>

{% endfor %}   

{% endblock %}


