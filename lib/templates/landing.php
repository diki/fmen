<!DOCTYPE html>
<html>

    <head>

        {# meta tags and styles #}
        {% include 'head.php' %}

        <title>{% block title %}{% endblock %} - My Webpage</title>
    </head>

    <style>
        .bg-container {
            width: 100%;
            background-repeat: no-repeat, repeat;
            background-size: cover, auto;
            background-attachment: fixed;
            background-position: center;

            background-image: url('/images/bg5.jpg'), url('/images/bg_pattern.png');

            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 1;
        }

        #stage {
            z-index: 2000098;
            position: relative;
        }
    </style>
    <body>
        
        {% include 'header4.php' %}

        <script src="js/lib/jquery.js" type="text/javascript"></script>

        <div class="bg-container">
        </div>

        <h1 style="margin-top:120px;font-weight:bold;width: 100%; text-align:center;color: white;position: relative; z-index: 9999;line-height:72px;text-shadow: 1px 1px 16px black;">web'in en güzel 
            <br/>
            <img style="opacity: 1; margin-top: 6px;"src="/images/dikikom2.png"/><span>leri</span></h1>
            
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

