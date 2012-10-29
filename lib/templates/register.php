{% extends "master.php" %}

{% block title %} {{ title }} {% endblock %}

{% block content %}
    
    <h2>Register</h2>
    
    <div id="userRegister">
        <ul>
            <li>
                <label for="e">email:</label><input type="text" name="email" id="e"/>
                <div style="display: inline-block; color: red;" id="foremail" class="validation"></div>
            </li>

            <li>
                <label for="n">Name:</label><input type="text" name="name" id="n"/>
                <div style="display: inline-block; color: red;" id="forname" class="validation"></div>
            </li>
            <li>
                <label for="s">Surname:</label><input type="text" name="surname" id="s"/>
                <div style="display: inline-block; color: red;" id="forsurname" class="validation"></div>
            </li>            

            <li>
                <label for="p">password:</label><input type="text" name="password" id="p"/>
                <div style="display: inline-block; color: red;" id="forpassword" class="validation"></div>
            </li>
            <li>
                <label for="rp">re-password:</label><input type="text" name="re-password" id="rp"/>
                <div style="display: inline-block; color: red;" id="forepassword" class="validation"></div>
            </li>

            <li>
                <label for="type">type:</label>
                <select name="type" id="t" name="type">
                    <option value="default">Seçiniz</option>
                    <option value="artist">Sanatçı</option>
                    <option value="collector">Koleksiyoncu</option>
                </select>
                <div style="display: inline-block; color: red;" id="fortype" class="validation"></div>
            </li>
            <li>
                <input type="submit" id="registerButton"/>
            </li>                   
        </ul>
    </div>

{% endblock %}

{% block scripts %}

    <script src="/js/lib/jquery.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function(){
            $("#registerButton").click(function(){
                var name = $("#n").val();
                if(name===""){
                    $(".validation").html("");
                    $("#forname").html("Name cannot be empty");
                    return;
                }

                var surname = $("#s").val();
                if(surname===""){
                    $(".validation").html("");
                    $("#forsurname").html("Surname cannot be empty");
                    return;
                }
                
                var email = $("#e").val();
                if(email===""){
                    $(".validation").html("");
                    $("#foremail").html("Email cannot be empty");
                    return;
                }
                
                var password = $("#p").val();
                if(password===""){
                    $(".validation").html("");
                    $("#foremail").html("Password cannot be empty");
                    return;
                }

                var repass = $("#rp").val();
                if(repass!==password){
                    $(".validation").html("");
                    $("#forrepassword").html("Passwords do not match");
                    return;
                }
                
                var type = $("#t").val();
                if(type==="default"){
                    $(".validation").html("");
                    $("#fortype").html("Type cannot be empty");
                    return;
                }

                console.log("before ajax");
                $.ajax({
                    type: "POST",
                    url: "/user/register",
                    dataType: "json",
                    data: {
                        name: name,
                        surname: surname,
                        password: password,
                        email: email,
                        type: type
                    },

                    success: function(d){
                        //console.log(d);
                        if(d.success && d.redirect_url!==undefined){
                            location.href=d.redirect_url;
                        }
                    }
                });

            });
        });
    </script>
    
{% endblock %}