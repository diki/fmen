{% extends "master.php" %}

{% block title %} {{ title }} {% endblock %}


{% block contentHeader %}
    <link rel="stylesheet" href="css/bb-tab.css?ver=1" type="text/css" />
    
    <style type="text/css">

    </style>
    <div class="content-header">
        <div class="wrapper">
            <div class="page-title">
                Erkek kombinleri
            </div>
            
            <!-- <div class="sep"></div> -->
            <!-- <hr class="rainbow" /> -->
            <!-- <div id="tab-view"></div> -->
            
            <ul class="category-list">
                <li><a href="#all" class="cat active" data-filter="all">YENİLER</a></li>
                <li><a href="#most-viewed" class="cat" data-filter="most-viewed">GÖRÜNTÜLENENLER</a></li>
                <li><a href="#latest" class="cat" data-category="latest">EDİTÖRÜN SEÇİMİ</a></li>
            </ul>
            <div class="category-list-sl">
                <div class="category-list-active" style="opacity: 1; left: 296px;"></div>
            </div>

            <ul id="listing" class="co-listing">

            </ul>

<!--             <ul class="category-button-list">
                <li>
                    <a href="#groundbreakers" class="cat is-gb" data-category="groundbreakers">En çok beğenilenler</a>
                </li>
                <li>
                    <a href="#arts" class="cat" data-category="arts">Gündelik</a>
                </li>
                <li>
                    <a href="#science-tech" class="cat" data-category="science-tech">Spor</a>
                </li>
                <li>
                    <a href="#sports" class="cat" data-category="sports">Lüx</a>
                </li>
                <li>
                    <a href="#business" class="cat" data-category="business">Seksi</a>
                </li>
                <li>
                    <a href="#organizers" class="cat" data-category="organizers">Çekici</a>
                </li>
                <li>
                    <a href="#politics" class="cat" data-category="politics">Tatlı</a>
                </li>
                <li>
                    <a href="#education" class="cat" data-category="education">Marjinal</a>
                </li>        
            </ul> -->
        </div>
    </div>
{% endblock %}

{% block content %}
    <link rel="stylesheet" href="/css/simplePagination.css?ver=1" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Julius+Sans+One&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Rambla&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Karla:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <link href='http://fonts.googleapis.com/css?family=Playfair+Display&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <div id="container">

        <div id="paginator"></div>

    </div>

    <script type="text/template" id="combine-list-item">
        <li>
            <div class="drop-shadow">
                <img src="http://s3.amazonaws.com/ginkatego/uploads/<%=imgId%>" />
                <h2><%=name%></h2>
            </div>
            <div class="content">
                <h2><%=name%></h2>
                <p><%=note%></p>
            </div>
            <br style="clear: both;"/>
            <hr/>
        </li>
    </script>

{% endblock %}

{% block scripts %}

    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js" type="text/javascript"></script>

    <script src="/js/plugins/jquery.simplePagination.js" type="text/javascript"></script>
    
    {% include 'scripts.html' %}

    <script src="/js/models/Combine.js" type="text/javascript"></script>
    <script src="/js/models/CombineElementModel.js" type="text/javascript"></script>
    <script src="/js/collections/CombinesCollection.js" type="text/javascript"></script>
    <script src="/js/collections/CombineElementsCollection.js" type="text/javascript"></script>

    <script src="/js/views/CombinesListView.js" type="text/javascript"></script>

    <script type="text/javascript" src="js/views/BBTabView.js"></script>
    <script>
    
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
    </script>

    <!-- <script type="text/javascript">
        $(document).ready( function(){ 

            var tabView = new BBTabView({
                el: "#tab-view",
                height: 0,
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
    </script> -->
{% endblock %}