{% extends 'templates.php' %}

{% block content %}

<div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">    
{% for data in post %}
    <div class="post-preview">
        <a href="index.php?action=post&amp;id={{ data.id }}">
            <h2 class="post-title">
                {{ data.titre }}
            </h2>
            <h3 class="post-subtitle">
                {{ data.contenu | raw }}
            </h3>    
        </a>
        <p class="post-meta">Publié par
            <a href="#">{{ data.auteur }}</a>
            le {{ data.dateAjout.format('d/m/Y à H:i') }}
        </p>
    </div>
    <hr>
{% endfor %}
    
    </div>
</div>    

{% endblock %}



