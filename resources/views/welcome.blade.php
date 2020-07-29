@extends( 'templates.welcome-page' )

@section('page-title', 'Welkom')

@section( 'content' )
    <main>
        <section class="grid-parent" id="section--welcome" data-section-background="color-accent--third">

            <div class="textblock textblock--default grid-child">
                <h1>Gelieve in te loggen</h1>
                <p>Om deze applicatie te kunnen gebruiken moet je inloggen. Heb je nog geen account? Maak dan een account aan.</p>
                <p><a href="/login" class="button button--first-accent">Klik hier om in te loggen</a><a href="/register" class="button button--second-accent">Klik hier om een account aan te maken</a></p>
            </div>

        </section>
    </main>
@endsection
