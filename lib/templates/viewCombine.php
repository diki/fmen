{% extends "master.php" %}

{% block title %} {{ title }} {% endblock %}


{% block contentHeader %}
{% endblock %}

{% block content %}

<div id="content">
                    
    <link rel="stylesheet" type="text/css" href="/css/products.css">
    <style>

        .left-list {
            float: left;
        }

        .left-list li {
            /*float: left;*/
        }

        #combineImgArea {
            float: left;
        }

        #combineImageForm {
            margin-left: 100px;
            margin-top: 82px;
        }

        #combineElements {
            margin: 16px;
            border: #e5e5e5;
            background: #e5e5e5;
            border-radius: 4px;
            padding: 32px;
        }

        #elementsContainer {
            background: #f0f1f5;
            border: 3px dashed gray;
            border-radius: 6px;
            color: gray;
            min-height: 100px;
            margin-bottom:  16px;
        }

        .img-container {
            /*border-right: 2px dashed #E5E5E5;*/
            /*border-radius: 20px;*/
            height: 600px;
            position: relative;
            border: 1px solid #AAA;
        }

        .combine-image-wrapper {
            /*background: none repeat scroll 0 0 #F0F0F2;*/
            height: 570px;
            margin-left: 20px;
            margin-top: 10px;
            padding: 10px 20px;
            position: relative;
            width: 380px;

            display: none;
        }

    </style>
    

    <div style="padding-top: 24px;">
        
        <!-- content inside is filled by backbone view -->
        <div id="combineEditor" style="background: white;">
       
            

        <div class="span6 img-container" id="combineImgArea" style="">
            <div class="combine-image-wrapper" style="display: block;">
                
                    <img id="combineImage" src="http://s3.amazonaws.com/ginkatego/uploads/1358468591_570x570.jpeg" style="width: 380px;height: 570px;">        
                
            
        <div id="ip_{{combine['id']}}" class="image-placer" style="left:266px;top:124px;">
                <span style="display: block">o</span>
                <div class="product-hover-view small">
                    <img src="{{combine['imgUrl']}}" style="float:left;">
                    <div class="product-hover-info">
                        <span><b>34.00</b> TL</span>
                        <a href="http://www.trendyol.com/Bershka/ButikDetay/12919?c=Notset" target="_blank">Mağazaya git</a>
                    </div>
                </div>
            </div>
        </div>

        </div>


        <div class="span6 left-container">

            <ul style="list-style: none;" class="combine-attr-list combine-elements-list" id="combineOperations">

                {% for element in elements %}
                    <div class="product-item" id="pr_{{element['id']}}">
                    
                    <li>
                        <div class="catalog-image-wrapper listed">
                            <img src="http://s.trendyol.com/Assets/ProductImages/12890/08305201812028_1_org.jpg" style="margin: 0px;" width="100" height="150">
                            </div>
                            <div class="product-item-info">
                                <span>i dunno know&nbsp;</span>
                                <span style="font-size:18px; font-family: 'Georgia', serif;">
                                    <b style="font-size: 24px;">34,</b> 00 TL
                                </span>
                                <a class="store" href="http://www.trendyol.com/Bershka/ButikDetay/12919?c=Notset" target="_blank">Mağazaya git</a>
                            </div>
                        </div>
                    </li>
                {% endfor %}
            </ul>
        </div>
        <br style="clear: both">
    </div>

    </div>

{% endblock %}

{% block scripts %}

{% endblock %}