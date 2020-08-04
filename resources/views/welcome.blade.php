@extends( 'templates.welcome-page' )

@section('page-title', 'Welkom')

@section( 'content' )
    <main>
        <section class="grid-parent" id="section--articles" data-section-background="color-accent--first">
        </section>
        <section class="grid-parent" id="section--welcome">

            <div class="projects-standard grid-child grid-child--d-7">
                <h5>New projects</h5>
            </div>
            <div class="projects-standard grid-child grid-child--d-5">
                <h5>Completed projects</h5>
            </div>

        </section>
    </main>
@endsection
