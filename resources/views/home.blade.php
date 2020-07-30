@extends( 'templates.home-page' )

@section('page-title', 'Dashboard')

@section( 'content' )
    <main>
        <section class="section--full-height grid-parent" id="section--home" data-section-background="color-accent--third">

            <div class="textblock-standard object-max-width--600 grid-child">
                <h1>Dashboard</h1>
                <p><strong>Your ID is:</strong> {{ Auth::user() -> id }}</p>
                <p><strong>Your name is:</strong> {{ Auth::user() -> name }}</p>
                <p><strong>Your password is:</strong> {{ Auth::user() -> password }}</p>
            </div>

        </section>
    </main>
@endsection
