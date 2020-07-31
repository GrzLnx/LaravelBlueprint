@inject('registerForm', \App\Helpers\FormBuilder )
@extends( 'templates.account-page' )

@section('content')
    <main>
        <section class="section--full-height grid-parent" id="section--register" data-section-background="color-accent--fourth">

            <div class="textblock-standard object-max-width--650 grid-child">
                <h1>{{ __('Maak uw eigen account') }}</h1>
                <p><hold-line>Ben je hier voor het eerst? Dan kan je hier een account aanmaken! </hold-line>
                   <hold-line>Heb je al een account en ben je hier per ongeluk terecht gekomen?</hold-line>
                   <hold-line>Ga dan naar <a href="{{ route( 'login' ) }}">de loginpagina</a> om in te loggen.</hold-line></p>
            </div>

            {{ $registerForm -> setFormClasses() }}
            {{ $registerForm -> setFormUseJavaScriptCheck( true ) }}
            {{ $registerForm -> setFormID( 'form-register' ) }}
            {{ $registerForm -> setFormAdditionalClasses( 'grid-child' ) }}
            {{ $registerForm -> setFormFieldIDAddPrefix( true ) }}
            {{ $registerForm -> setFormAction( route( 'register' ) ) }}
            {{ $registerForm -> addCSRFField( csrf_token() ) }}
            {{ $registerForm -> addTextInputField( 'name', '', '', 'name', 'autofocus', old( 'name' ), 'Naam', 'name', true, __('Naam'), 'required:true' ) }}
            {{ $registerForm -> addTextInputField( 'username', '', '', 'username', '', old( 'username' ), 'Gebruikersnaam', 'username', true, __('Gebruikersnaam'), 'required:true' ) }}
            {{ $registerForm -> addEmailInputField( 'email', '', '', 'email', '', old( 'email' ), 'E-mail', 'email', true, __('E-mailadres'), 'required:true;format:email' ) }}
            {{ $registerForm -> addPasswordInputField( 'password', '', '', 'password', '', '', 'Wachtwoord', 'new-password', true, __('Wachtwoord'), 'required:true;min-length:6' ) }}
            {{ $registerForm -> addPasswordInputField( 'password_confirmation', '', '', 'password_confirmation', '', '', 'Bevestig wachtwoord', 'new-password', true, __('Bevestig wachtwoord'), 'required:true;min-length:6;password-confirm:password' ) }}
            {{ $registerForm -> addCheckboxInputField( 'agree_to_the_terms', '', '', 'terms', '', old( 'terms' ), true, 'Ja, ik ga akkoord met <a>de voorwaarden</a>.', 'required:true' ) }}
            {{ $registerForm -> addSubmitButton( 'submit', '', '', 'submit', '', __( 'Klik hier om je account aan te maken' ) ) }}
            {{ $registerForm -> renderForm() }}

        </section>
    </main>
@endsection
