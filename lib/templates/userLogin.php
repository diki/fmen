<li>
<ul class="list">
{% if session.username %}
    <li>
        <!-- <form action="/user/logout" method="POST"> -->
            <input type="submit" value="Çıkış" id="logout" style="border: none"/>
        <!-- </form> -->
    </li>
    <li>
        <span class="profile-nav">Hoşgeldin {{ session.username }} !</span>
        <ul id="profile-list" style="display:none;background:black;color:white;list-style:none;">
            
            {% if session.user.type=="author" %}
                <li style="float:none;">
                    <a href="/profile/{{ session.user.id }}">Profil</a>
                </li>

                <script type="text/javascript">
                    $(document).ready(function(){
                        $(".profile-nav").click(function(){
                            $("#profile-list").toggle();
                        });
                    });
                </script>

            {% endif %}
        </ul>
    </li>

{% else %}
    <li>
        <a class="user-nav-link" href="/user/register">Kaydol</a>
    </li>
    <li>|</li>
    <li>
        <a class="user-nav-link" id="login">Girişle</a>
    </li>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".user-nav-link").click(function(){
                $('#loginModal').modal({});
            });
        });
    </script>
{% endif %}

{% if session.fb_logged_in %}
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#logout").click(function(e){
                FB.getLoginStatus(function(ret) {
                    console.log(ret);
                    FB.logout(function(response){
                        console.log("usr logged out");
                        $.ajax({
                            type: "POST",
                            url: "/user/logout",
                            // dataType: "json",
                            success: function(r){
                                window.location.href = "/";
                            }
                        });
                    });
                    
                });
            });
        });
    </script>

{% else %}

    <script type="text/javascript">

        $(document).ready(function(){
            $("#logout").click(function(e){
                $.ajax({
                    type: "POST",
                    url: "/user/logout",
                    // dataType: "json",
                    success: function(r){
                        window.location.href = "/";
                    }
                });
            });
        });
    </script>

{% endif %}
</ul>
</li>