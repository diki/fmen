<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">

    <head>

        {# meta tags and styles #}
        {% include 'head.php' %}

        <title>{% block title %}{% endblock %}</title>

        <meta property="og:url" content="http://www.pindistan.com" />
    </head>

    <body>
        
        <div id="fb-root"></div>
        <script>
          // Additional JS functions here
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '572794652744127', // App ID
              channelUrl : 'http://www.pinditan.com/channel.html', // Channel File
              status     : true, // checwwk login status
              cookie     : true, // enable cookies to allow the server to access the session
              xfbml      : true  // parse XFBML
            });

            // Additional init code here

          };

          // Load the SDK Asynchronously
          (function(d){
             var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement('script'); js.id = id; js.async = true;
             js.src = "//connect.facebook.net/en_US/all.js";
             ref.parentNode.insertBefore(js, ref);
           }(document));
        </script>

        
        {% include 'navigation.php' %}

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

