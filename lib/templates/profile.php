{% extends "master.php" %}

{% block title %} {{ title }} {% endblock %}

{% block content %}
    
    <h2>Profile</h2>

    <div>
        <div id="pictureContainer" style="width: 192px;">
            <img src="//s3.amazonaws.com/ginkatego/uploads/{{session.user.img_id}}" />
        </div>

        <div>
            <span>{{session.user.name}}</span>
            <span>{{session.user.surname}}</span>
        </div>


        <form id="changePictureForm" action="/images" method="POST" enctype="multipart/form-data">
            <ul>
                <li>
                    <label class="cabinet"> 
                        <input type="file" id="changePicture" name="image"/>
                    </label>
                </li>
                <li>
                    <input type="hidden" value="192" name="height" />
                    <input type="hidden" value="192" name="width" />
                    <input type="hidden" value="true" name="element" />
                </li>
            </ul>
        </form>
    </div>
{% endblock %}

{% block scripts %}

    <script type="text/javascript" src="/js/lib/jquery.form.js"></script>
    <script>
        $(document).ready(function(){
            $("#changePicture").change(function(e){

                console.log("eefef");
                $("#changePictureForm").ajaxSubmit(function(resp){
                    var srcText =JSON.parse(resp).id;
                    $("#pictureContainer").find("img").attr("src", "//s3.amazonaws.com/ginkatego/uploads/"+srcText);
                    $.ajax({
                        type : "POST",
                        url  : "/server/profile/updateImage",
                        data : {
                            src: srcText
                        },
                        success: function(resp){
                            console.log("image changed", resp);
                        }
                    });
                });

            });
            
        });
    </script>    
{% endblock %}