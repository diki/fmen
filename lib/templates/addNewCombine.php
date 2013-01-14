{% extends "master.php" %}

{% block title %} {{ title }} {% endblock %}

{% block content %}
    
    <link rel="stylesheet" type="text/css" href="/css/products.css">
    <style>
        .SI-FILES-STYLIZED label.cabinet
        {
            width: 225px;
            height: 225px;
            background: url(/css/images.jpg) 0 0 no-repeat;

            display: block;
            overflow: hidden;
            cursor: pointer;
        }

        .SI-FILES-STYLIZED label.cabinet input.file
        {
            position: relative;
            height: 100%;
            width: auto;
            opacity: 0;
            -moz-opacity: 0;
            filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
        }

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
        </div>

        <!-- products catalog modal box -->
        <div class="modal hide fade" id="userProductsWindow">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Kayıtlarınız</h3>
            </div>
            <div class="modal-body" id="productCatalog">
                <div class="product-list">
                </div>
            </div>
            <div class="modal-footer">
                    <a class="btn btn-primary disabled" id="addProductFromcatalog">Seçili Parçaları Ekle</a>
                </div>
            </div>
        </div>


{% endblock %}


{% block scripts %}

    {% include 'scripts.html' %}

    <script type="text/javascript" src="/js/lib/jquery.form.js"></script>
    <script type="text/javascript" src="/js/lib/si.files.js"></script>
    <script type="text/javascript" src="/js/plugins/jquery.image-uploader.js"></script>

    <script type="text/javascript" src="/js/models/CombineElementModel.js"></script>
    <script type="text/javascript" src="/js/collections/CombineElementsCollection.js"></script>

    <script type="text/javascript" src="/js/models/Combine.js"></script>

    <script type="text/javascript" src="/js/models/UserRecord.js"></script>
    <script type="text/javascript" src="/js/collections/UserRecordCollection.js"></script>

    <script type="text/javascript" src="/js/views/CombineEditorView.js"></script>
    <script type="text/javascript" src="/js/views/CombineElementsGroupView.js"></script>
    <script type="text/javascript" src="/js/views/CombineElementEditableView.js"></script>

    <script type="text/javascript" src="/js/views/ProductsCatalogView.js"></script>

    <script type="text/template" id="newElementCreator">
       
        <ul id="newElementWrapper" style="list-style: none;">
            
            <% if(mainElement) { %>
                <li>main element</li>
            <% } else { %>
                <li>alt element</li>
            <% } %>
            <ul style="list-style: none; float:left;">
                <li>
                    <label>Eleman Adı</label>
                    <input type="text" class="newElementName" />
                </li>
                <li>
                    <label>Fiyatı</label>
                    <input type="text" class="newElementPrice" />
                </li>
                <li>
                    <label>Tagler</label>
                    <input type="text" class="newElementTags" />
                </li>
                <li>
                    <label>Link</label>
                    <input type="text" class="newElementLink" />
                </li>
                <li>
                    <label>Açıklamalar</label>
                    <textarea class="newElementNote" rows="10" cols="90" style="width: 500px;"></textarea>
                </li>
                <li>
                   <button type="submit" class="btn new-element-button"><i class="icon-plus"></i>Kaydet</button>
                   <button type="submit" class="btn new-element-cancel"><i class="icon-remove"></i>İptal</button>
                </li>  
            </ul>
            
            <li style="float: left;">
                <div class="img-upload-wrapper">
                    
                    <form class="img-upload-form" action="/images" method="POST" enctype="multipart/form-data">
                        <ul>
                            <li>
                                <label class="cabinet"> 
                                    <input type="file" class="file img-uploader" name="image"/>
                                </label>
                            </li>
                            <li>
                                <input type="hidden" value="400" name="height" />
                                <input type="hidden" value="400" name="width" />
                                <input type="hidden" value="true" name="element" />
                            </li>
                        </ul>
                    </form>

                    <img class="img-preview" src="" style="display: none; margin-left: 32px;" /> 
                </div>
            </li>

        </ul>

        <br style="clear: both" />
    </script>

    <script type="text/template" id="combineElementsGroupView">
        <div id="<%=id%>">
            <div class="main-element-img left">
                <img src="uploaded-images/thumbs/<%=imgId%>.jpg" />
            </div>
            <ul class="main-element-info" style="list-style: none;">
                <li>
                    <h6><%=name%></h6>
                </li>
                <li>
                    <div>Fiyat</div>
                    <div><%=price%></div>
                </li>
                <li>
                    <div>Nerede</div>
                    <div><%=link%></div>
                </li>            
            </ul>
            <br style="clear: both" />
            <ul class="alt-elements" style="list-style: none;">
            </ul>
        </div>
    </script>

    <script type="text/template" id="imagePlacerTemplate">
        <div id="ip_<%=id%>" class="image-placer" style="left:<%=relX%>px;top:<%=relY%>px;">
            <span style="display: block">o</span>
            <div class="product-hover-view small">
                <img src="<%=imageUrl%>" style="float:left;"/>
                <div class="product-hover-info">
                    <span><b><%=price%></b> TL</span>
                    <a href="<%=sourceUrl%>" target="_blank">Mağazaya git</a>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="combineElementEditableView">
        <div class="product-item" id="pr_<%=productId%>">
            <!-- <img src="<%=imageUrl%>" style="float:left;"/> -->

            <div class="product-item-info">
                <a class="remove-product">X</a>
                <span><%=note%>&nbsp;</span>
                <span style="font-size:18px; font-family: 'Georgia', serif;">
                    <b style="font-size: 24px;"><%=(price+"").toString().split(".")[0]%>,</b> 
                    <%=(price+"").toString().split(".")[1]%> TL
                </span>
                <a class="store" href="<%=sourceUrl%>" target="_blank">Mağazaya git</a>
            </div>
        </div>
    </script>    


    <script type="text/template" id="combineEditorViewTemplate">
       
            

        <div class="span6 img-container" id="combineImgArea" style="">
            <div class="combine-image-wrapper">
                <% if(imgID===undefined) { %>
                    <img id="combineImage" src="" style="width: 380px;height: 570px;" />        
                <% } else { %>
                    <img id="combineImage" src="/ginkatego/uploaded-images/<%=imgID%>" style="width: 380px;height:570px;" />
                <% } %>
            </div>
            <form id="combineImageForm" action="/images" method="POST" enctype="multipart/form-data">
                <ul style="list-style: none;">
                    <li>
                        <% if(imgID===undefined) { %>
                            <label class="cabinet"> 
                        <% } else { %>
                            <label style="width: 100px; height: 20px;" class="cabinet"> 
                        <% } %>
                            <input type="file" class="file" name="image" id="imgUpload"/>
                        </label>
                    </li>

                    <li>
                        <input type="hidden" value="570" name="width" />
                        <input type="hidden" value="570" name="height" />
                    </li>
                </ul>
            </form>
        </div>


        <div class="span6 left-container">
            <div class="alert alert-success" id="infoMessage" style="display: none;">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <span>Heads up!</span>
            </div>

            <div id="action-info" style="display: none">
                Kombin resmi üzerine tıklayarak ürün kataloğunuzdan ürün ekleyin
            </div>

            <ul style="list-style: none;" class="combine-attr-list" id="combineOperations">
                <li>
                    <label>İsim</label>
                    <input type="text" id="combineName" value=<%=(name === undefined? '""' : '"'+name+'"')%>/>
                </li>
                <li>
                    <label>Açıklamalar</label>
                    <textarea id="combineNotes" rows="4" cols="90"><%=(notes === undefined? '' : notes)%></textarea>
                </li>
                <li>
                    <label>Cinsiyet</label>
                    <select id="combineSex">
                        <option value="default">Please select</option>
                        <option value="men">Erkek</option>
                        <option value="women">Kadın</option>
                    </select>
                </li>

                <li>
                    <label>Kategori</label>
                    <select id="combineCategory">
                        <option value="default">Please select</option>
                        <option value="casual">Casual</option>
                        <option value="sport">Sport</option>
                        <option value="luxury">Luxury</option>
                        <option value="sweet">Sweet</option>
                        <option value="charming">Charming</option>
                        <option value="sexy">Sexy</option>
                    </select>
                </li>

                <li>
                   <button type="submit" class="btn btn-primary" id="newCombineButton">Oluştur</button>
                </li>
            </ul>
        </div>
        <br style="clear: both" />
    </script>

    <script type="text/javascript">
        function validateCombineCreation(formData, jqForm, options){
            for (var i=0; i < formData.length; i++) { 
                if (!formData[i].value) { 
                    alert('Please enter a value for both Username and Password'); 
                    return false; 
                } 
            }
        }
    </script>
    <script type="text/javascript">

        (function(){

            /*
                create UserRecordListView and initialize UserProductCollection and fetch
                for latter use, enable them load parallel
             */
            window.userRecordCol = new UserRecordCollection();

            //TODO: we should fetch or create combineElement model here
            var combineModel = new Combine();
            window.combineEditorView = new CombineEditorView({
                model: combineModel
            });
            window.pcv = new ProductsCatalogView({
                collection: userRecordCol
            });

            $("#combineElementsManager").bind("combineCreated", function(e){
                console.log("combine created successfully");
                
                $(this).show();

                var self = this;
                var elementsContainer = $("#elementsContainer");

                if(combine.get("elements").length==0){
                    //console.log("000000");
                    elementsContainer.html('<h2>Şu an hiçbir eleman yok</h2>')
                }

                //bind add event handler
                combine.get("elements").on("add", function(model,collection){
                    //console.log("elemt added", c, m);
                    
                    //clear if first
                    if(collection.length===1){
                        $("#elementsContainer").html("");
                    }
                    if(model.get("keyElement")===1){

                        var cegv = new CombineElementsGroupView({
                            model: model  //this is also window.activeCombineElement
                        });

                        window.currentElementsGroupView = cegv;

                        //add new combine group view to elementsContainer
                        elementsContainer.append(cegv.el);
                    } else {
                        //append to current elementsGroupView
                        //console.log("added alternative");
                        console.log(currentElementsGroupView);
                        currentElementsGroupView.collection.add(model);
                    }
                })
            });

            /**
             * click of add new combine button on click
             * render template with id newElementCreator on $("#newElementInputsContainer")
             * then bind imageUploader plugin to img-upload wrapper
             * @return {[type]} [description]
             */
            
            // window.combineElementEditorView = new CombineElementEditorView();
            // $("#newCombineElementButton").click(function(){
                
            //     //CombineElementEditorView responsible for adding main and sub combine elements                
            //     //var ceev = new CombineElementEditorView();
            //     combineElementEditorView.render({mainElement: true});

            // }); 

            // $("#newAlternativeElementButton").click(function(){
            //     combineElementEditorView.render({mainElement: false});
            // });

        })();

    </script>


{% endblock %}