@inject('resetPasswordForm', \App\Helpers\FormBuilder )
@extends( 'templates.account-page' )

@section( 'content' )
<main>
    <section class="section--full-height grid-parent" id="section--reset-password" data-section-background="color-accent--third">

        <div class="textblock-standard object-max-width--700 grid-child">
            <h1>{{ __('Nieuw wachtwoord aanmaken') }}</h1>
            <p><hold-line>Op deze pagina kan je een nieuw wachtwoord instellen. Probeer 'm deze keer te onthouden! </hold-line></p>
        </div>

        {{ $resetPasswordForm -> setFormClasses() }}
        {{ $resetPasswordForm -> setFormUseJavaScriptCheck( true ) }}
        {{ $resetPasswordForm -> setFormID( 'form-reset-password' ) }}
        {{ $resetPasswordForm -> setFormAdditionalClasses( 'grid-child' ) }}
        {{ $resetPasswordForm -> setFormFieldIDAddPrefix( true ) }}
        {{ $resetPasswordForm -> setFormAction( route('password.update') ) }}
        {{ $resetPasswordForm -> addCSRFField( csrf_token() ) }}
        {{ $resetPasswordForm -> addHiddenInputField( 'token', '', 'token', '', $token, 'required:true' ) }}
        {{ $resetPasswordForm -> addEmailInputField( 'email', '', '', 'email', 'autofocus', $email ?? old( 'email' ), 'E-mail', 'email', true, __('E-mailadres'), 'required:true;format:email;min-length:8;max-length:40' ) }}
        {{ $resetPasswordForm -> addPasswordInputField( 'password', '', '', 'password', '', '', 'Wachtwoord', 'current-password', true, __('Wachtwoord'), 'required:true' ) }}
        {{ $resetPasswordForm -> addPasswordInputField( 'password_confirmation', '', '', 'password_confirmation', '', '', 'Bevestig wachtwoord', 'new-password', true, __('Bevestig wachtwoord'), 'required:true;min-length:6;password-confirm:password' ) }}
        {{ $resetPasswordForm -> addSubmitButton( 'submit', '', '', 'submit', '', __( 'Wijzig je wachtwoord' ) ) }}
        {{ $resetPasswordForm -> renderForm() }}

    </section>
</main>
@endsection
