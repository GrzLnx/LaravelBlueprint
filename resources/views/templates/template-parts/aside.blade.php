<aside>
    <section class="section--full-height grid-parent" id="section--sidebar">
        <div class="textblock-standard grid-child">
            <button id="theme-button">Wijzig thema</button>
        </div>
        @auth
            <nav class="nav--with-icons grid-child" id="nav--main-menu">
                <h2>Kies een applicatie</h2>
                <ul>
                    <li><a href="/">Overzicht</a></li>
                    <li><a href="/calendar">Kalender</a></li>
                    <li><a href="/notes">Notities</a></li>
                    <li><a href="/financials">Financiën</a></li>
                    <li><a href="/planner">Planner</a></li>
                    <li><a href="/birthdays">Verjaardagen</a></li>
                    <li><a href="/contacts">Contactpersonen</a></li>
                    <li><a href="/passwords">Wachtwoorden</a></li>
                    <li><a href="/shipments">Pakketjes</a></li>
                    <li><a href="/clothing">Kleding</a></li>
                    <li><a href="/shopping">Boodschappen</a></li>
                </ul>
            </nav>
            <nav class="nav--with-icons grid-child" id="nav--bottom-menu">
                <ul>
                    <li><a href="/settings">Instellingen</a></li>
                    <li><a href="{{ route( 'logout' ) }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Uitloggen</a></li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </nav>
        @else
            <nav class="nav--with-icons grid-child" id="nav--bottom-menu">
                <ul>
                    <li><a href="/settings">Instellingen</a></li>
                    <li><a href="/login">Inloggen</a></li>
                </ul>
            </nav>
        @endauth
    </section>
</aside>
