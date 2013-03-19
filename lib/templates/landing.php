<!DOCTYPE html>
<html>

    <head>

        {# meta tags and styles #}
        {% include 'head.php' %}

        <title>{% block title %}{% endblock %} - My Webpage</title>

        <link href='http://fonts.googleapis.com/css?family=Inder&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
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
            z-index: 1000;
            position: relative;
        }

        .box {
            z-index: 110;
        }
    </style>
    <body>
        
        {% include 'header4.php' %}
        
        <div class="bg-container">
        </div>
        <h1 style="font-family: 'Inder', sans-serif;padding:30px 0; background:rgba(0,0,0,0.7);margin-top:70px;font-weight:bold;width: 100%; text-align:center;color: white;position: relative; z-index: 2;line-height:72px;text-shadow: 1px 1px 16px black;">web'in en güzel 
            <br/>
            <img style="opacity: 1; margin-top: 6px;"src="/images/dikikom2.png"/>
            <span>leri</span>
        </h1>
            
        <div id="stage">
        

            <div id="content">
              {% block content %}
                {% endblock %}
            </div>
        </div>

        <div class="modal hide fade" id="loginModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="text-align:center;padding-top:30px;">
                <a style="display:inline-block; width:200px;" id="fb-login">
                    <img src="/images/connect-with-facebook.png"/>
                </a>
                <a style="display:inline-block; width:200px;margin-left:24px;" id="tw-login">
                    <img src="/images/connect-with-twitter.png"/>
                </a>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>


        <script type="text/javascript">
            //twitter fb login windows
            //
            var fbTimer, fbChildWindow;
            function fbPolling() {
                if(fbChildWindow && fbChildWindow.closed) {
                    // The popup has been closed, stop the timer and reload window.
                    clearInterval(fbTimer);
                    window.location.href = window.location.href;
                    // console.log("fb window closed");
                }
            }
            var twTimer, twChildWindow;
            function twPolling() {
                if(twChildWindow && twChildWindow.closed) {
                    // The popup has been closed, stop the timer and reload window.
                    clearInterval(twTimer);
                    window.location.href = window.location.href;
                    // console.log("fb window closed");
                }
            }
            $("#fb-login").click(function(){
                fbChildWindow  = window.open("/user/fb-login" ,"", 'width=400, height=320');
                fbTimer = setInterval('fbPolling()', 1000);
            });
            //twitter fb login windows
            $("#tw-login").click(function(){
                twChildWindow = window.open("/user/twitter-login" ,"", 'width=600, height=320');
                twTimer = setInterval('twPolling()', 1000);
            });
        </script>
        {% block scripts %}
        {% endblock %}
    </body>
</html>

