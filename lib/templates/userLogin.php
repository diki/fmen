<ul class="list">
{% if session.username %}
    <li>
        <form action="/user/logout" method="POST">
            <input type="submit" value="Çıkış" style="border: none"/>
        </form>
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
        <a class="user-nav-link" href="/user/login">Giriş Yap</a>
    </li>
{% endif %}
</ul>