@extends( 'templates.welcome-page' )

@section('page-title', 'Welkom')

@section( 'content' )
    <div class="textblock textblock--default">
        <h1>Gelieve in te loggen</h1>
        <p>Om deze applicatie te kunnen gebruiken moet je inloggen. Heb je nog geen account? Maak dan een account aan.</p>
        <p><a href="/login" class="button accent-button">Klik hier om in te loggen</a><a href="/register" class="button subtle-button">Klik hier om een account aan te maken</a></p>
    </div>
@endsection
