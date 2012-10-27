{% extends "master.php" %}

{% block title %} {{ title }} {% endblock %}

{% block content %}
    
    <h2>Login</h2>
    
    <div id="userLogin">
        <form method="POST" id="loginForm">
            <ul>
                <li>
                    <label for="e">eMail:</label><input type="text" name="email" id="e" value="{{session.email}}"/>
                    <div style="display: inline-block; color: red;" id="foremail" class="validation">{{session.emailerror}}</div>
                </li>

                <li>
                    <label for="p">password:</label><input type="text" name="password" id="p" value="{{session.password}}"/>
                    <div style="display: inline-block; color: red;" id="forpassword" class="validation">{{session.passworderror}}</div>
                </li>

                <li>
                    <label for="t"></label>
                    <select id="t" name="type">
                        <option value="default">Seçiniz</option>
                        <option value="artist">Sanatçı</option>
                        <option value="collector">Koleksiyoncu</option>
                    </select>
                    <div style="display: inline-block; color: red;" id="fortype" class="validation">{{session.typeerror}}</div>
                </li>
                <li>
                    <input type="submit" id="loginButton"/>
                </li>                   
            </ul>
        </form>
    </div>

{% endblock %}

{% block scripts %}
    <script type="text/javascript">

        $(function(){
            $("#loginButton").click(function(e){
                e.preventDefault();

                var email = $("#e").val();
                if(email===""){
                    //alert("email field cannot be empty");
                    $(".validation").html("");
                    $("#foremail").html("Email cannot be empty");
                    return;
                }
                
                var password = $("#p").val();
                if(password===""){
                    //alert("password min char");
                    $(".validation").html("");
                    $("#forpassword").html("Password cannot be empty");
                    return;
                }
                
                var type = $("#t").val();
                if(type==="default"){
                    $(".validation").html("");
                    $("#fortype").html("Type cannot be empty");
                    return;
                }

                $("#loginForm").submit();
            });
            // $("#loginForm").submit(function(e){

            //     e.preventDefault();

            //     // console.log("soooo");
            //     // var email = $("#e").val();
            //     // if(email===""){
            //     //     //alert("email field cannot be empty");
            //     //     $(".validation").html("");
            //     //     $("#foremail").html("Email cannot be empty");
            //     //     return;
            //     // }
                
            //     // var password = $("#p").val();
            //     // if(password===""){
            //     //     //alert("password min char");
            //     //     $(".validation").html("");
            //     //     $("#forpassword").html("Password cannot be empty");
            //     //     return;
            //     // }
                
            //     // var type = $("#t").val();
            //     // if(type==="default"){
            //     //     $(".validation").html("");
            //     //     $("#fortype").html("Type cannot be empty");
            //     //     return;
            //     // }

            //     $(this).submit();
            //     return false;
            // });
        });
    </script>
{% endblock %}