{% extends "landing.php" %}

{% block title %} {{ title }} {% endblock %}

{% block content %}
    
    <div class="main-container">
<!--         <h1 class="main-logo-line">
            <span>
                <span style="color: #ec0915; text-shadow: 0px 0px 2px red;">gin</span>
                <span style="margin-left: -22px;">katego</span>
            </span>
        </h1> -->
        <div class="discover">
            <div class="discover-cont">
                <!-- <div style="font-weight: bold;"><span style="color: #007C5B;">ginkatego</span> KOMBİN KOLEKSİYONU</div> -->
                <div style="text-shadow: 0px 0px 1px #888; line-height: 27px; font-size: 18px; font-family: 'Create Round', serif;">
                    Size en uygun kombinleri keşfedin,  <br/>
                    Hangi kıyafet nerede önce siz haberdar olun
                </div>
            </div>
        </div>

        <div style="margin-top: 36px; color: #686868; margin-left: 16px; text-shadow: 0px 0px 1px #888; line-height: 27px; font-size: 28px;">
            Kombinleri keşfedin...
        </div> 
        <div id="tab-view"></div>
    </div>
{% endblock %}

{% block scripts %}

    {% include 'scripts.html' %}

    <link rel="stylesheet" href="css/bb-tab.css?ver=1" type="text/css" />
    <script type="text/javascript" src="/js/plugins/jquery.easing.1.3.js"></script>

    <script type="text/javascript" src="js/views/BBTabView.js"></script>

    <script type="text/template">
        <form class="combineElementForm" action="images" method="POST" enctype="multipart/form-data">

        </form>
    </script>

    <script type="text/javascript">
        $(document).ready( function(){ 

            var tabView = new BBTabView({
                el: "#tab-view",
                height: 400,
                tabs: [{
                    name: "EN ÇOK BEĞENİLENLER",
                    content: "tab facotiets",
                    active: true
                },{
                    name: "MODA",
                    content: "This is tab1"
                    // active: true
                }, {
                    name: "CASUAL",
                    content: "This is tab2"
                }, {
                    name: "SPOR",
                    content: "this is tab3"
                }, {
                    name: "ŞIK",
                    content: "this is tab4"
                }]
            });        
        });    
    </script>
{% endblock %}


