@inject('logInForm', \App\Helpers\FormBuilder )
@extends( 'templates.account-page' )

@section( 'content' )
    <main>
        <section class="grid-parent" id="section--login" data-section-background="color-accent--third">

            <div class="textblock-standard grid-child">
                <h1>{{ __('Inloggen') }}</h1>
            </div>

            {{ $logInForm -> setFormClasses() }}
            {{ $logInForm -> setFormID( 'form-login' ) }}
            {{ $logInForm -> setFormAdditionalClasses( 'grid-child' ) }}
            {{ $logInForm -> setFormFieldIDAddPrefix( true ) }}
            {{ $logInForm -> setFormAction( route( 'login' ) ) }}
            {{ $logInForm -> addCSRFField( csrf_token() ) }}
            {{ $logInForm -> addEmailInputField( 'email', '', '', 'email', 'autofocus', old( 'email' ), 'E-mail', 'email', true, __('E-mailadres'), 'required:true;format:email;min-length:8;max-length:40' ) }}
            {{ $logInForm -> addPasswordInputField( 'password', '', '', 'password', '', '', 'Wachtwoord', 'current-password', true, __('Wachtwoord'), 'required:true' ) }}
            {{ $logInForm -> addCheckboxInputField( 'remember', '', '', 'remember', '', '', true, __('Blijf ingelogd'), '' ) }}
            {{ $logInForm -> addSubmitButton( 'submit', '', '', 'submit', '', __( 'Inloggen' ) ) }}
            @if( Route::has( 'password.request' ) )
                {{ $logInForm -> addHTML( '<a href="' . route( 'password.request' ) . '">' . __( 'Oeps, ik ben mijn wachtwoord vergeten!' ) . '</a>' ) }}
            @endif
            {{ $logInForm -> renderForm() }}

        </section>
    </main>
    <script>
        function checkForm( form ) {
            const formFieldsToCheck = form.querySelectorAll( '[data-field-js-check="true"]' );
            let formStatus = true;
            for( let formField of formFieldsToCheck ) {
                if( !checkFormField( form, formField ) ) {
                    formStatus = false;
                }
            }
            console.log( formStatus );
            return false;
        }
        function checkFormField( form, formField ) {
            let jsChecks = formField.getAttribute( 'data-field-js-checks' ).split( ';' );
            for( let jsCheck of jsChecks ) {
                let check = jsCheck.split( ':' );
                let checkType = check[0];
                let checkContent = check[1];
                switch( checkType ) {
                    case 'required':
                        if( checkContent == "true" ) {
                            return formField.value.length !== 0;
                        }
                        break;
                    case 'format':
                        break;
                }
            }
            return true;
        }
    </script>
@endsection
