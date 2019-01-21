{% extends 'templates.php' %}

{% block content %}

<h1>Mon super blog !</h1>
<h4>Derniers billets du blog :</h4>


{% for data in post %}
    <div class="news">
        <h3>
            {{ data.titre }}
            <em>le {{ data.creation_date_fr }}</em>
        </h3>
        <p>
            {{ data.contenu }}
            <br />
            <em><a href="index.php?action=post&amp;id={{ data.id }}">Commentaires</a></em>
        </p>
    </div>
{% endfor %}    

{% endblock %}
