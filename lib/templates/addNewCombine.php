{% extends "master.php" %}

{% block title %} {{ title }} {% endblock %}

{% block content %}

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
            margin-left: 188px;
            margin-top: 40px;
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

    </style>
    

    <div>
        
        <div id="combineEditor">
        </div>

        <div id="combineElementsManager" style="">
            <h2>Kombin Elemanları</h2>
            
            <div id="combineElements">

                <ul id="elementsContainer" style="list-style: none;">
                </ul>

                <button type="submit" class="btn btn-inverse" id="newCombineElementButton"><i class="icon-plus"></i>Yeni eleman ekle</button>
                <button type="submit" class="btn btn-inverse" id="newAlternativeElementButton"><i class="icon-plus"></i>Seçili kombine yeni eleman ekle</button>

                <div id="newElementInputsContainer">

                </div>
            </div>
        </div>
    </div>
{% endblock %}


{% block scripts %}
    <script src="/js/lib/jquery.js" type="text/javascript"></script>
    {% include 'scripts.html' %}

    <script type="text/javascript" src="/js/lib/jquery.form.js"></script>
    <script type="text/javascript" src="/js/lib/si.files.js"></script>
    <script type="text/javascript" src="/js/plugins/jquery.image-uploader.js"></script>

    <script type="text/javascript" src="/js/models/CombineElementModel.js"></script>
    <script type="text/javascript" src="/js/collections/CombineElementsCollection.js"></script>
    <script type="text/javascript" src="/js/models/Combine.js"></script>

    <script type="text/javascript" src="/js/views/CombineEditorView.js"></script>
    <script type="text/javascript" src="/js/views/CombineElementsGroupView.js"></script>
    <script type="text/javascript" src="/js/views/CombineElementEditorView.js"></script>

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
                    
                    <form class="img-upload-form" action="images" method="POST" enctype="multipart/form-data">
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

    <script type="text/template" id="combineEditorViewTemplate">
       
       <h1>Yeni kombin ekle</h1>
            
        <ul style="list-style: none; float: left;" class="left-list">
            <li>
                <label>İsim</label>
                <input type="text" id="combineName" value=<%=(name === undefined? '""' : '"'+name+'"')%>/>
            </li>
            <li>
                <label>Açıklamalar</label>
                <textarea id="combineNotes" rows="10" cols="90" style="width: 500px;"><%=(notes === undefined? '' : notes)%></textarea>
            </li>
            <li>
               <button type="submit" class="btn" id="newCombineButton"><i class="icon-upload"></i>Oluştur</button>
            </li>
        </ul>

        <div id="combineImgArea">
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
                        <input type="hidden" value="400" name="height" />
                        <input type="hidden" value="400" name="width" />
                    </li>
                </ul>
            </form>

            <% if(imgID===undefined) { %>
                <img id="combineImage" src="" style="display: none; margin-left: 32px;" />        
            <% } else { %>
                <img id="combineImage" src="/ginkatego/uploaded-images/<%=imgID%>" style="display: none; margin-left: 32px;" />
            <% } %>
                   
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

            /**
             * maklng buttons stylized
             * @param  {[type]} ell [description]
             * @param  {[type]} idx [description]
             * @return {[type]}     [description]
             */
            // _.each($("#imgUpload"), function (ell, idx) {
            //     SI.Files.stylize(ell);
            // });

            //TODO: we should fetch or create combineElement model here
            var combineModel = new Combine();
            cev = new CombineEditorView({
                model: combineModel
            });
            
            /**
             *  click of add button
             *
             * sends server request  to create new combine combine with uploaded image id on server
             * also sets window.combine and window.newCombineId values
             * 
             * @return {[type]} [description]
             */
            $("#newCombineButton").click(function(){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "server/combines/add",
                    data: {
                        imgID: combineImageId,
                        name: $("#combineName").val(),
                        notes: $("#combineNotes").val()
                    },

                    success: function(resp){
                        console.log("new combine created with id ", resp.id);
                        window.newCombineID = resp.id;

                        console.log("creating new combine model");
                        
                        window.combine = new Combine();
                        combine.id = resp.id;

                        //handling DOM events inside of it
                        //will be a Backbone View in future
                        $("#combineElementsManager").trigger("combineCreated");
                    }
                });
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
            
            window.combineElementEditorView = new CombineElementEditorView();
            $("#newCombineElementButton").click(function(){
                
                //CombineElementEditorView responsible for adding main and sub combine elements                
                //var ceev = new CombineElementEditorView();
                combineElementEditorView.render({mainElement: true});

            }); 

            $("#newAlternativeElementButton").click(function(){
                combineElementEditorView.render({mainElement: false});
            });

        })();

    </script>


{% endblock %}