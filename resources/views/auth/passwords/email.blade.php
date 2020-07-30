@inject('requestResetPasswordForm', \App\Helpers\FormBuilder )
@extends( 'templates.account-page' )

@section( 'content' )
<main>
    <section class="section--full-height grid-parent" id="section--reset-password" data-section-background="color-accent--third">

        <div class="textblock-standard object-max-width--750 grid-child">
            <h1>{{ __('Nieuw wachtwoord aanvragen') }}</h1>
            <p><hold-line>Oeps, ben je jouw wachtwoord vergeten? Geen probleem! Hier vraag je zonder problemen een nieuw wachtwoord aan, het enige wat wij daarvoor van jou nodig hebben is het e-mailadres dat je gebruikt om bij ons in te loggen. </hold-line></p>
        </div>

        {{ $requestResetPasswordForm -> setFormClasses() }}
        {{ $requestResetPasswordForm -> setFormUseJavaScriptCheck( true ) }}
        {{ $requestResetPasswordForm -> setFormID( 'form-request-reset-password' ) }}
        {{ $requestResetPasswordForm -> setFormAdditionalClasses( 'grid-child' ) }}
        {{ $requestResetPasswordForm -> setFormFieldIDAddPrefix( true ) }}
        {{ $requestResetPasswordForm -> setFormAction( route('password.update') ) }}
        {{ $requestResetPasswordForm -> addCSRFField( csrf_token() ) }}
        {{ $requestResetPasswordForm -> addEmailInputField( 'email', '', '', 'email', 'autofocus', old( 'email' ), 'E-mail', 'email', true, __('E-mailadres'), 'required:true;format:email;min-length:8;max-length:40' ) }}
        {{ $requestResetPasswordForm -> addSubmitButton( 'submit', '', '', 'submit', '', __( 'Reset link aanvragen' ) ) }}
        {{ $requestResetPasswordForm -> renderForm() }}

        @auth
            <div class="textblock-standard object-max-width--700 grid-child">
                <p>Wil je jouw wachtwoord niet aanpassen? Ga dan terug naar <a href="{{ route( 'home' ) }}">het dashboard</a>.</p>
            </div>
        @else
            <div class="textblock-standard object-max-width--700 grid-child">
                <p>Wil je jouw wachtwoord niet aanpassen? Ga dan terug naar <a href="{{ route( 'home' ) }}">de loginpagina</a> of naar
                    <a href="{{ route( 'welcome' ) }}">het overzicht</a>.</p>
            </div>
        @endauth

    </section>
</main>
@endsection
