<!DOCTYPE html>
<html>

    <head>

        {# meta tags and styles #}
        {% include 'head.php' %}

        <title>{% block title %}{% endblock %} - My Webpage</title>
    </head>

    <body>
        
        {% include 'header2.php' %}

        {% block contentHeader %}
        {% endblock %}

        <div id="stage">    
            <div id="content">
                {% block content %}
                {% endblock %}
            </div>
        </div>
        
        {% block scripts %}
        {% endblock %}
    </body>
</html>

