{% extends "master.php" %}

{% block title %} {{ title }} {% endblock %}


{% block contentHeader %}
{% endblock %}

{% block content %}

<div id="content">
                    
    <link rel="stylesheet" type="text/css" href="/css/products.css">
    <link rel="stylesheet" href="css/elusive-webfont.css?ver=1" type="text/css" />
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
            /*height: 600px;*/
            position: relative;
            /*border: 1px solid #AAA;*/
        }

        .combine-image-wrapper {
            /*background: none repeat scroll 0 0 #F0F0F2;*/
            /*height: 570px;*/
/*            margin-left: 20px;
            margin-top: 10px;*/
            padding: 20px 40px;
            border:1px solid #AAA;
            position: relative;
            width: 380px;

            display: none;
        }

        .like-combine-big{
            font-size: 24px;
            float: right;
            display: b;
            display: block;
            margin-top: -11px;
            margin-right: 10px;
            color: #AAA;
        }

        .like-combine-big:hover {
            text-decoration: none;
            color: red;
        }

        #stage {
            background: white;
        }

    </style>
    

        
        <!-- content inside is filled by backbone view -->
        <div id="combineEditor" style="background: white;min-height:800px; width:90%; margin: 0 auto;">
       
            
            <div class="span6 img-container" id="combineImgArea" style="margin-top: 18px;">
                <div class="combine-image-wrapper" style="display: block;">
                    <img id="combineImage" src="http://s3.amazonaws.com/ginkatego/uploads/{{combine['imgId']}}">        
                    
                {% for element in elements %}
                    <div id="ip_{{element['recordId']}}" class="image-placer" style="left:{{element['relX']}}px;top:{{element['relY']}}px;">
                        <span style="display: block">o</span>
                        <div class="product-hover-view small">
                            <img src="{{element['imageUrl']}}" style="float:left;">
                            <div class="product-hover-info">
                                <span><b>{{element['price']}}</b> TL</span>
                                <a href="{{element['sourceUrl']}}" target="_blank">Mağazaya git</a>
                            </div>
                        </div>
                    </div>
                {% endfor %}

                </div>

                <div class="addthis_toolbox addthis_default_style" style="margin-top: 30px;margin-left: -4px;padding-bottom:20px;border-bottom:2px solid #000;">
                    <a style="width:80px;" class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                    <a style="width:89px;" class="addthis_button_tweet"></a>
                    <a style="width:69px;" class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                    <a class="addthis_button_pinterest_pinit"></a>
                    <a class="like-combine-big"><i class="icon-heart"></i></a>
                </div>
                
                <div class="fb-comments" style="margin-top: 30px;margin-left: -7px;" data-href="http://www.pindistan.com/combines?cid={{combine['id']}}" data-width="470" data-num-posts="10"></div>

            </div>
        <div class="span4 left-container">

            <ul style="list-style: none;" class="combine-attr-list combine-elements-list" id="combineOperations">

                {% for element in elements %}
                    <div class="product-item" id="pr_{{element['id']}}">
                    
                    <li>
                        <div class="catalog-image-wrapper listed">
                            <div style="width: 150px; height: 150px; border: 1px solid black;">
                                <img src="{{element['imageUrl']}}" style="width:{{element['width']}}px; height:{{element['height']}}px;margin:{{75-element['height']/2}}px 0;" />
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


<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-512f82111686f469"></script>

<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
<!-- AddThis Button END -->
    </div>

{% endblock %}

{% block scripts %}

{% endblock %}