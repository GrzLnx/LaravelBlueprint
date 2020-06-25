@inject('registerForm', \App\Helpers\FormBuilder )
@extends( 'templates.account-page' )

@section('content')
    <main>
        <section class="grid-parent" id="section--register">

            <div class="textblock-standard grid-child">
                <h1>{{ __('Registreren') }}</h1>
            </div>

            {{ $registerForm -> setFormClasses() }}
            {{ $registerForm -> setFormID( 'form-register' ) }}
            {{ $registerForm -> setFormAdditionalClasses( 'grid-child' ) }}
            {{ $registerForm -> setFormFieldIDAddPrefix( true ) }}
            {{ $registerForm -> setFormAction( route( 'register' ) ) }}
            {{ $registerForm -> addCSRFField( csrf_token() ) }}
            {{ $registerForm -> addTextInputField( 'name', '', '', 'name', 'autofocus', old( 'name' ), 'Naam', 'name', true, __('Naam'), 'required:true' ) }}
            {{ $registerForm -> addTextInputField( 'username', '', '', 'username', '', old( 'username' ), 'Gebruikersnaam', 'username', true, __('Gebruikersnaam'), 'required:true' ) }}
            {{ $registerForm -> addEmailInputField( 'email', '', '', 'email', '', old( 'email' ), 'E-mail', 'email', true, __('E-mailadres'), 'required:true' ) }}
            {{ $registerForm -> addPasswordInputField( 'password', '', '', 'password', '', '', 'Wachtwoord', 'new-password', true, __('Wachtwoord'), 'required:true' ) }}
            {{ $registerForm -> addPasswordInputField( 'password_confirmation', '', '', 'password_confirmation', '', '', 'Bevestig wachtwoord', 'new-password', true, __('Bevestig wachtwoord'), 'required:true' ) }}
            {{ $registerForm -> addSubmitButton( 'submit', '', '', 'submit', '', __( 'Registreer' ) ) }}
            {{ $registerForm -> renderForm() }}

        </section>
    </main>
@endsection
