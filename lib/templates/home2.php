{% extends "landing.php" %}

{% block title %} {{ title }} {% endblock %}

{% block content %}
    
    <script type="text/template" id="combine-list-item">
        <li>
            <!-- <div class="drop-shadow"> -->
                <img src="http://s3.amazonaws.com/ginkatego/uploads/<%=imgId%>" style="width:240px;"/>
                <h2><%=name%></h2>
                <p><%=note%></p>
            <!-- </div> -->
        </li>
    </script>
    <div class="main-container">
<!--         <h1 class="main-logo-line">
            <span>
                <span style="color: #ec0915; text-shadow: 0px 0px 2px red;">gin</span>
                <span style="margin-left: -22px;">katego</span>
            </span>
        </h1> -->
<!--         <div class="discover">
            <div class="discover-cont">
                <div style="text-shadow: 0px 0px 1px #888; line-height: 27px; font-size: 18px; font-family: 'Create Round', serif;">
                    Size en uygun kombinleri keşfedin,  <br/>
                    Hangi kıyafet nerede önce siz haberdar olun
                </div>
            </div>
        </div> -->

<!--         <div style="margin-top: 36px; color: #686868; margin-left: 16px; text-shadow: 0px 0px 1px #888; line-height: 27px; font-size: 28px;">
            Kombinleri keşfedin...
        </div>  -->
        <div id="tab-view">

            <ul class="category-list">
                <li><a href="#all" class="cat active" data-filter="all">EN ÇOK BEĞENİLENLER</a></li>
                <li><a href="#most-viewed" class="cat" data-filter="most-viewed">YENİLER</a></li>
                <li><a href="#latest" class="cat" data-category="latest">TREND</a></li>
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

        <ul id="listing" class="co-listing">

        </ul>

    </div>
{% endblock %}

{% block scripts %}

    {% include 'scripts.html' %}

    <link rel="stylesheet" href="css/bb-tab.css?ver=1" type="text/css" />
    <script type="text/javascript" src="/js/plugins/jquery.easing.1.3.js"></script>

    <script src="/js/models/Combine.js" type="text/javascript"></script>
    <script src="/js/models/CombineElementModel.js" type="text/javascript"></script>

    <script src="/js/collections/CombinesCollection.js" type="text/javascript"></script>
    <script src="/js/collections/CombineElementsCollection.js" type="text/javascript"></script>

    <script src="/js/views/CombinesListView.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/views/BBTabView.js"></script>

    <script type="text/template">
        <form class="combineElementForm" action="images" method="POST" enctype="multipart/form-data">

        </form>
    </script>

    <script type="text/javascript">
        $(function(){

            window.combinesCollection = new CombinesCollection();
            combinesCollection.fetch({
                data: {
                    offset: 0,
                    limit: 10,
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
        // $(document).ready( function(){ 

        //     var tabView = new BBTabView({
        //         el: "#tab-view",
        //         height: 400,
        //         tabs: [{
        //             name: "EN ÇOK BEĞENİLENLER",
        //             content: "tab facotiets",
        //             active: true
        //         },{
        //             name: "MODA",
        //             content: "This is tab1"
        //             // active: true
        //         }, {
        //             name: "CASUAL",
        //             content: "This is tab2"
        //         }, {
        //             name: "SPOR",
        //             content: "this is tab3"
        //         }, {
        //             name: "ŞIK",
        //             content: "this is tab4"
        //         }]
        //     });        
        // });    
    </script>
{% endblock %}


