@inject('logInForm', \App\Helpers\FormBuilder )
@extends( 'templates.account-page' )

@section( 'content' )
    <main>
        <section class="section--full-height grid-parent" id="section--login" data-section-background="color-accent--third">

            <div class="textblock-standard object-max-width--650 grid-child">
                <h1>{{ __('Inloggen') }}</h1>
                <p>
                    <hold-line>Voer onderstaand je gegevens in om in te loggen. </hold-line>
                    <hold-line>Heb je nog geen account? Maak dan een <a href="{{ route( 'register' ) }}">nieuw account</a> aan. </hold-line>
                </p>
                <p>
                   <hold-line>Ben je jouw wachtwoord vergeten? Vraag dan een <a href="{{ route( 'password.request' ) }}">nieuw wachtwoord</a> aan. </hold-line>
                </p>
            </div>

            {{ $logInForm -> setFormClasses() }}
            {{ $logInForm -> setFormUseJavaScriptCheck( true ) }}
            {{ $logInForm -> setFormID( 'form-login' ) }}
            {{ $logInForm -> setFormAdditionalClasses( 'grid-child' ) }}
            {{ $logInForm -> setFormFieldIDAddPrefix( true ) }}
            {{ $logInForm -> setFormAction( route( 'login' ) ) }}
            {{ $logInForm -> addCSRFField( csrf_token() ) }}
            {{ $logInForm -> addEmailInputField( 'email', '', '', 'email', 'autofocus', old( 'email' ), 'E-mail', 'email', true, __('E-mailadres'), 'required:true;format:email;min-length:8;max-length:40' ) }}
            {{ $logInForm -> addPasswordInputField( 'password', '', '', 'password', '', '', 'Wachtwoord', 'current-password', true, __('Wachtwoord'), 'required:true' ) }}
            {{ $logInForm -> addCheckboxInputField( 'remember', '', '', 'remember', '', '', true, __('Blijf ingelogd'), '' ) }}
            {{ $logInForm -> addSubmitButton( 'submit', '', '', 'submit', '', __( 'Klik hier om in te loggen' ) ) }}
            {{ $logInForm -> renderForm() }}

        </section>
    </main>
@endsection
