@extends( 'templates.welcome-page' )

@section('page-title', 'Welkom')

@section( 'content' )
    <main>
        <section class="section--full-height grid-parent" id="section--welcome" data-section-background="color-accent--third">

            <div class="textblock-standard object-max-width--700 grid-child">
                <h1>Oeps, je bent niet ingelogd!</h1>
                <p>Om deze applicatie te kunnen gebruiken heb je een account nodig! Heb je nog geen account? Deze kan je heel makkelijk aanmaken.</p>
                <p><a href="/login" class="button button--first-accent">Inloggen</a><a href="/register" class="button button--second-accent">Maak een account aan</a></p>
            </div>

        </section>
    </main>
@endsection
