<ul class="list">
{% if session.username %}
    <li>
        <!-- <form action="/user/logout" method="POST"> -->
            <input type="submit" value="Çıkış" id="logout" style="border: none"/>
        <!-- </form> -->
    </li>
    <li>
        Hoşgeldin {{ session.username }} !
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
            $("#login").click(function(e){
                $('#loginModal').modal({});
            });
        });
    </script>
{% endif %}

{% if session.fb_logged_in %}
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#logout").click(function(e){
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