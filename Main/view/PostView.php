{% extends 'templates/template_default.php' %}

{% block content %}

        <div>
            <a href="/Main/News">Retour à la liste des billets</a>
        </div>
        <hr>
        <div class="post-preview">
            <h3>
                {{ post.titre }}
            </h3>
            <p> {{ post.contenu | raw }} </p>
            {% if post.dateAjout  == post.dateModif  %}  
            <p class="post-meta">Publié par
                <a href="#">{{ post.auteur }}</a>
                le {{ post.dateAjout.format('d/m/Y à H:i') }}
            </p>
            {% else %}
            <p class="post-meta">Mis a jour par
                <a href="#">{{ post.auteur }}</a>
                le {{ post.dateModif.format('d/m/Y à H:i') }}
            </p>
            {% endif %}
        </div>

        <h2>Commentaires</h2>

        {% if session['auth'] %}   

        <form action="index.php?action=post.addComment&amp;id={{ post.id }}" method="POST">
            <div class="form-group floating-label-form-group controls">
                <label for="comment">Votre commentaire</label><br />
                <input type="hidden" name="author" value="{{ session['auth'].username }}" />
                <textarea rows="5" id="comment" name="comment" class="form-control" placeholder="Votre commentaire"></textarea>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Poster</button>
        </form>
        <br>
        {% else %}
        <a href="index.php?action=auth.login">Connectez vous pour laisser un message.</a><br><br>
        {% endif %}

        {% for comment in comments %}

        <p><strong>{{ comment.author }}</strong> le {{ comment.comment_date_fr }}</p>
        <p>{{ comment.comment }}</p>

        {% endfor %}
 

{% endblock %}


