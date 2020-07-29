@inject('requestNewVertificationEmail', \App\Helpers\FormBuilder )
@extends( 'templates.account-page' )

@section( 'content' )
    <main>
        <section class="grid-parent" id="section--login" data-section-background="color-accent--third">

            <div class="textblock-standard object-max-width--650 grid-child">
                <h1>{{ __('Bevestig jouw e-mailadres') }}</h1>
                @if( session( 'resent' ) )
                    <p><hold-line>Een bevestigingslink is succesvol verstuurd naar jouw e-mailadres!</hold-line></p>
                @endif
                <p><hold-line>Geen bevestigingslink ontvangen, of werkte de link niet? Vraag dan een nieuwe bevestigingslink aan. </hold-line>
                   <hold-line>PS: al in de spam folder gekeken?</hold-line></p>
            </div>

            {{ $requestNewVertificationEmail -> setFormClasses() }}
            {{ $requestNewVertificationEmail -> setFormUseJavaScriptCheck( true ) }}
            {{ $requestNewVertificationEmail -> setFormID( 'form-request-vertification-email' ) }}
            {{ $requestNewVertificationEmail -> setFormAdditionalClasses( 'grid-child' ) }}
            {{ $requestNewVertificationEmail -> setFormFieldIDAddPrefix( true ) }}
            {{ $requestNewVertificationEmail -> setFormAction( route( 'verification.resend' ) ) }}
            {{ $requestNewVertificationEmail -> addCSRFField( csrf_token() ) }}
            {{ $requestNewVertificationEmail -> addSubmitButton( 'submit', '', '', 'submit', '', __( 'Vraag een nieuwe bevestigingslink aan' ) ) }}
            {{ $requestNewVertificationEmail -> renderForm() }}

        </section>
    </main>
@endsection
