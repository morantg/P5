{% extends 'templates/template_default.php' %}

{% block content %}

{% for data in post %}
    <div class="post-preview">
        <a href="/News/{{ data.id }}">
            <h2 class="post-title">
                {{ data.titre }}
            </h2>
            <h3 class="post-subtitle">
                {{ data.getExtrait | raw }}
            </h3>    
        </a>
        <p class="post-meta">Publié par
            <a href="#">{{ data.auteur }}</a>
            le {{ data.dateAjout.format('d/m/Y à H:i') }}
        </p>
    </div>
    <hr>
{% endfor %}
    
    

{% endblock %}



