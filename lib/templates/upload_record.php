{% extends "master.php" %}

{% block title %} {{ title }} {% endblock %}

{% block content %}
    
    <style type="text/css">
        ul#userLists li:hover {
            color: #FFFFFF;
            background: #e5e5e5;
            cursor: pointer;
        }

        ul#userLists li.selected {
            color: white;
            background: #3FB618;
        }        
    </style>
    <h2>upload</h2>
    <div id="container">

        <input type="hidden" value="{{imgUrl}}" id="imgUrl" />
        <input type="hidden" value="{{srcUrl}}" id="srcUrl" />

        <div style="float: left;">
            <div id="uploadImageWrapper" style="border: 1px solid #e5e5e5;">
                <img src="{{imgUrl}}" id="uploadImage"/>
            </div>
        </div>

        <div style="float: left; width: 50%;">
            <ul style="list-style: none;">
                <li style="background: white;">
                    <label>Listeleriniz</label>
                    <ul id="userLists" style="list-style: none;">
                    </ul>

                    <div>
                            <input type="text" id="newListName" class="input-medium"/>
                            <button id="addNewList" class="btn btn-primary">Yeni Liste</button>
                    </form>
                </li>
                <li>
                    <label class="" for="note">Not</label>
                    <textarea class="" id="note" rows="3" style=""></textarea>

                    <label for="type">Tip:</label>
                    <select id="type">
                        <option value="piece" selected="true">Parça</option>
                        <option value="combine">Kombin</option>
                    </select>
                </li>
                <li>
                    <button id="addNewRecord" class="btn btn-primary">Kaydı Yükle</button>
                </li>
            </ul>
        </div>

    </div>

{% endblock %}

{% block scripts %}

   <script type="text/javascript">

        /*
            function to get query parameters from URL
         */
        // function getParameterByName(name)
        // {
        //     name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        //     var regexS = "[\\?&]" + name + "=([^&#]*)";
        //     var regex = new RegExp(regexS);
        //     var results = regex.exec(window.location.search);
        //     if(results == null)
        //         return "";
        //     else
        //         return decodeURIComponent(results[1].replace(/\+/g, " "));
        // }

        var imageObj = document.getElementById("uploadImage");

        /*
            adjust image size and margin
         */
        imageObj.onload = function(){
            var imageWidth = 0;
            var imageHeight = 0;
            var topMargin = 0;
            var leftMargin = 0;

            if (imageObj.width > imageObj.height) { // landscape
                topMargin = Math.floor(( 200 - (200 * imageObj.height / imageObj.width)) / 2);
                imageWidth = 200;
                imageHeight = Math.round(200 * imageObj.height / imageObj.width);
            } else if (imageObj.width < imageObj.height) {
                leftMargin = Math.floor(( 200 - (200 * imageObj.width / imageObj.height)) / 2);
                imageWidth = Math.round(200 * imageObj.width / imageObj.height);
                imageHeight = 200;
            }

            imageObj.style.margin    = topMargin+"px "+leftMargin+"px";
            imageObj.width = imageWidth;
            imageObj.height = imageHeight;
        }

        /*
            create new record button
         */

        $("#addNewList").click(function(){
            var newListModel = {
                name: $("#newListName").val()
            }

            $.ajax({
                type: "POST",
                url: "/user/list/create",
                dataType: "json",

                data: {
                    model: JSON.stringify(newListModel)
                },

                success: function(resp){
                    $("#userLists").append('<li id="'+resp.id+'">'+newListModel.name+'</li>');
                    //console.log("yuuuuuuu");
                }
            });
        });

        /*
            read lists of user and render
         */
        $.ajax({
            type: "POST",
            url: "/user/list/read",
            dataType: "json",

            success: function(r){
                var listData = r.data;
                $.each(listData, function(idx, el){
                    $("#userLists").append('<li id="'+el.id+'">'+el.name+'</li>');
                })
            }
        });

        /*
            bind click events of user list items
         */
        $("#userLists > li").live("click", function(e){

            if($(e.target).hasClass("selected")){
                $(e.target).removeClass("selected");
                return;
            }

            $("li").removeClass("selected");
            $(e.target).addClass("selected");
        });

        /*
            add new record
         */
        $("#addNewRecord").click(function(e){
            var folder = "not_assigned";
            if($("li.selected").length > 0){
                folder = $("li.selected").html();
            }
            var newRecordModel = {
                "folder": folder,
                "imgUrl": $("#imgUrl").val(),
                "srcUrl": $("#srcUrl").val(),
                "type": $("#type").val(),
                "note": $("#note").val()
            }

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/user/record/manage/create",
                data: {
                    model: JSON.stringify(newRecordModel)
                },

                success: function(resp){
                    console.log("server", resp);
                }
            });
            console.log(newRecordModel, "annaaaa");
        });
   </script>
{% endblock %}