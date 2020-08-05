<header>
<nav class="default-nav">
    <ul>
        <li><a href="/">Homepage</a></li>
        <li><a href="/news">News</a></li>
        <li><a href="/projects">Projects</a></li>
        <li><a href="/users">Users</a></li>
        @auth
            <li><a href="/my-account">My account</a></li>
            <li><a href="{{ route( 'logout' ) }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Uitloggen</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        @else
            <li><a href="/login">Sign In</a></li>
            <li><a href="/register">Sign Up</a></li>
        @endauth
    </ul>
</nav>
</header>
