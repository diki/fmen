
{% extends "landing.php" %}

{% block title %} {{ title }} {% endblock %}

{% block content %}
    
    <!-- combine list item template -->
    <script type="text/template" id="combine-list-item">
            <div class="combine-list-wrapper">
                <a href="/combines?cid=<%=id%>" style="display: block; overflow:hidden;">
                    <img src="http://s3.amazonaws.com/ginkatego/uploads/<%=imgId%>" style="border: 1px solid #e5e5e5;"/>
                </a>
                <div style="display:block;" class="combine-list-item-line">
                    <span class="item-like"><i class="icon-heart"></i><%=likes%></span>
                    <span><i class="icon-eye-open"></i><%=views%></span>
                </div>

                <div class="combine-list-item-info" >
                    <p style="color: white;"><%=name%></p>
                </div>
            </div>
    </script>

    <style type="text/css">
        #stage {
            margin-top: -17px;
            box-shadow: inset 0 20px 20px -20px #000000;
        }

        .main-container {
            box-shadow: inset 0 20px 20px -20px #000000;
        }

        #listing li{
            /*position: relative;*/
        }

        .item-like: {
            cursor: pointer;
        }

        .box {
            position: absolute;
        }

        /*#libido { background: red }*/

.size21, .size22, .size23, .twocols { background: #ccc }
.size31, .size32, .size33, .threecols { background: #ff9999 }
    </style>

    <script type="text/javascript">

    </script>
    <div class="main-container">

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
        
        <div id="tab-view">

            <ul class="category-list">
                <li><a href="#all" class="active" data-filter="all">EN ÇOK BEĞENİLENLER</a></li>
                <li><a href="#most-viewed" class="passive" data-filter="most-viewed">YENİLER</a></li>
                <li><a href="#latest" class="passive" data-category="latest">TREND</a></li>
            </ul>
            <div class="category-list-sl">
                <!-- <div class="category-list-active" style="opacity: 1; left: 375px;"></div> -->
            </div>
<!--                 <a class="header-nav-list-item-link bb-tab-link first-tab" href="">
                    <span>
                        EN ÇOK BEĞENİLENLER
                    </span>
                </a>
                <a class="header-nav-list-item-link bb-tab-link" href="">
                    <span>
                        YENİLER
                    </span>
                </a>
                <a class="header-nav-list-item-link bb-tab-link last-tab" href="">
                    <span>
                        MODA
                    </span>
                </a> -->
<!--                 <a class="header-nav-list-item-link bb-tab-link" href="">
                    <span>CASUAL</span>
                </a>
                <a class="header-nav-list-item-link bb-tab-link" href="">
                    <span>SPOR</span>
                </a>
                <a class="header-nav-list-item-link bb-tab-link" href="">
                    <span>ŞIK</span>
                </a> -->
<!--             <ul class="header-nav-list bb-tab-links" style="z-index:999999">
                <li class="header-nav-list-item bb-tab-list-item" data-target="bb_tab_0">
                    <a class="header-nav-list-item-link bb-tab-link first-tab" href="">EN ÇOK BEĞENİLENLER</a>
                </li>
                <li class="header-nav-list-item bb-tab-list-item" data-target="bb_tab_1">
                    <a class="header-nav-list-item-link bb-tab-link" href="">MODA</a>
                </li>
                <li class="header-nav-list-item bb-tab-list-item" data-target="bb_tab_2">
                    <a class="header-nav-list-item-link bb-tab-link" href="">CASUAL</a>
                </li>
                <li class="header-nav-list-item bb-tab-list-item" data-target="bb_tab_3">
                    <a class="header-nav-list-item-link bb-tab-link" href="">SPOR</a>
                </li>
                <li class="header-nav-list-item bb-tab-list-item" data-target="bb_tab_4">
                    <a class="header-nav-list-item-link bb-tab-link" href="">ŞIK</a>
                </li>
            </ul> -->
        </div>

        <ul id="listing" class="co-listing" style="position:relative;">

        </ul>


    </div>
{% endblock %}

{% block scripts %}

    {% include 'scripts.html' %}

    <link rel="stylesheet" href="css/bb-tab.css?ver=1" type="text/css" />
    <link rel="stylesheet" href="css/elusive-webfont.css?ver=1" type="text/css" />

    <script type="text/javascript" src="/js/plugins/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="/js/lib/jquery.cookie.js"></script>
    <script type="text/javascript" src="/js/lib/jquery.shapeshift.min.js"></script>

    <script src="/js/models/Combine.js" type="text/javascript"></script>
    <script src="/js/models/CombineElementModel.js" type="text/javascript"></script>

    <script src="/js/collections/CombinesCollection.js" type="text/javascript"></script>
    <script src="/js/collections/CombineElementsCollection.js" type="text/javascript"></script>

    <script src="/js/views/CombineListItemView.js" type="text/javascript"></script>
    <script src="/js/views/CombinesListView.js" type="text/javascript"></script>

    <script type="text/javascript" src="js/views/BBTabView.js"></script>

    <script type="text/javascript" src="js/app.js"></script>

    <script type="text/template">
        <form class="combineElementForm" action="images" method="POST" enctype="multipart/form-data">

        </form>
    </script>

    <script type="text/javascript">
        $(function(){

            // $('#listing').nested({
            //     minWidth: 100,
            //     gutter: 10
            // }); 

            window.combinesCollection = new CombinesCollection();
            combinesCollection.fetch({
                data: {
                    offset: 0,
                    limit: 20,
                    startDate: "0",
                    endDate: "0",
                    sex: "men",
                    category: 0
                },

                success: function(c,resp){
                    c.reset(resp);
                }
            });

            /*
                view responsible for drawing combine items
             */
            window.combinesListView = new CombinesListView({
                collection: combinesCollection
            });

      });   
    </script>
{% endblock %}


