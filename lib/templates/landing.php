<!DOCTYPE html>
<html>

    <head>

        {# meta tags and styles #}
        {% include 'head.php' %}

        <title>{% block title %}{% endblock %} - My Webpage</title>
    </head>

    <body>
        
        {% include 'header2.php' %}

        <script src="/js/lib/jquery.js" type="text/javascript"></script>

        <div style="z-index: 0;">
            {% include 'rotating_slider.php' %}
        </div>
        <div id="stage">
        
<!--             {% include 'userLogin.php' %} -->


            <div id="content">
                {% block content %}
                {% endblock %}
            </div>
            

        </div>
        
        {% block scripts %}
        {% endblock %}
    </body>
</html>

