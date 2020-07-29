@inject('confirmPasswordForm', \App\Helpers\FormBuilder )
@extends( 'templates.account-page' )

@section( 'content' )
    <main>
        <section class="grid-parent" id="section--confirm-password" data-section-background="color-accent--third">

            <div class="textblock-standard object-max-width--700 grid-child">
                <h1>{{ __('Wachtwoord controle') }}</h1>
                <p><hold-line>Bevestig jouw wachtwoord. Ben je jouw wachtwoord vergeten? </hold-line>
                   <hold-line>Vraag dan een <a href="{{ route( 'password.request' ) }}">nieuw wachtwoord</a> aan.</hold-line></p>
            </div>

            {{ $confirmPasswordForm -> setFormClasses() }}
            {{ $confirmPasswordForm -> setFormUseJavaScriptCheck( true ) }}
            {{ $confirmPasswordForm -> setFormID( 'form-confirm-password' ) }}
            {{ $confirmPasswordForm -> setFormAdditionalClasses( 'grid-child' ) }}
            {{ $confirmPasswordForm -> setFormFieldIDAddPrefix( true ) }}
            {{ $confirmPasswordForm -> setFormAction( route('password.confirm') ) }}
            {{ $confirmPasswordForm -> addCSRFField( csrf_token() ) }}
            {{ $confirmPasswordForm -> addPasswordInputField( 'password', '', '', 'password', '', '', 'Wachtwoord', 'current-password', true, __('Wachtwoord'), 'required:true' ) }}
            {{ $confirmPasswordForm -> addSubmitButton( 'submit', '', '', 'submit', '', __( 'Wijzig je wachtwoord' ) ) }}
            {{ $confirmPasswordForm -> renderForm() }}

        </section>
    </main>
@endsection
