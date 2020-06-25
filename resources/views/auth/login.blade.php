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
            console.log( 'form status: ' + formStatus );
            return formStatus;
        }
        function checkFormField( form, formField ) {
            let jsChecks = formField.getAttribute( 'data-field-js-checks' ).split( ';' );
            let fieldStatus = true;
            let fieldValidator = new FormFieldValidator();
            let notificationTextHolder = formField.parentElement.querySelector( '.form-standard__status-holder-tooltip' );
            fieldValidator.Field = formField;
            fieldValidator.FieldValue = formField.value;
            for( let jsCheck of jsChecks ) {
                let check = jsCheck.split( ':' );
                fieldValidator.FieldCheck = check[0];
                fieldValidator.FieldCheckValue = check[1];
                if( !fieldValidator.Validate() ) {
                    console.log( fieldValidator.FieldValidationMessage );
                    fieldStatus = false;
                }
            }
            if( notificationTextHolder !== null ) {
                notificationTextHolder.innerHTML = '';
                if( !fieldValidator.FieldValidationMessage === false ) {
                    notificationTextHolder.innerHTML = fieldValidator.FieldValidationMessage;
                }
                if( fieldStatus ) {
                    notificationTextHolder.innerHTML = '<strong>Dit veld is correct ingevuld!</strong>';
                }
            }
            return fieldStatus;
        }

        class FormFieldValidator {

            constructor() {
                this.fieldValidationMessage = '';
                this.returnBoolean = true;
            }

            set Field( field ) {
                this.field = field;
            }
            set FieldValue( fieldValue ) {
                this.fieldValue = fieldValue;
            }
            set FieldCheck( fieldCheck ) {
                this.fieldCheck = fieldCheck;
            }
            set FieldCheckValue( fieldCheckValue ) {
                this.fieldCheckValue = fieldCheckValue;
            }
            set FieldValidationMessage( fieldValidationMessage ) {
                this.fieldValidationMessage = fieldValidationMessage;
            }

            get FieldValidationMessage() {
                if( this.fieldValidationMessage.length !== 0 ) {
                    return '<strong>Dit veld bevat de volgende errors:</strong>' + this.fieldValidationMessage;
                }
                return false;
            }

            Validate() {
                switch( this.fieldCheck ) {
                    case 'required':
                        return this.ValidateRequired();
                    case 'format':
                        return this.ValidateFormat();
                    case 'min-length':
                        return this.ValidateMinLength();
                    case 'max-length':
                        return this.ValidateMaxLength();
                    default:
                        return true;
                }
            }

            ValidateRequired() {
                if( this.fieldCheckValue ) {
                    if( this.field.value.length !== 0 ) {
                        return true;
                    }
                    this.fieldValidationMessage += '<br />- Dit veld is verplicht.';
                    return false;
                }
                return true;
            }

            ValidateFormat() {
                switch( this.fieldCheckValue ) {
                    case 'email':
                        return this.ValidateFormatEmail();
                    case 'numbers':
                        return this.ValidateFormatNumbers();
                    default:
                        return true;
                }
            }
            ValidateFormatEmail() {
                if( /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test( this.fieldValue ) ) {
                    return true;
                }
                this.fieldValidationMessage += '<br />- Dit veld moet een geldig e-mailadres bevatten.';
                return false;
            }
            ValidateFormatNumbers() {
                if( /^\d+$/.test( this.fieldValue ) ) {
                    return true;
                }
                this.fieldValidationMessage += '<br />- Dit veld mag enkel cijfers bevatten.';
                return false;
            }

            ValidateMinLength() {
                if( this.fieldValue.length >= this.fieldCheckValue ) {
                    return true;
                }
                this.fieldValidationMessage += '<br />- Dit veld moet minstens ' + this.fieldCheckValue + ' tekens bevatten.';
                return false;
            }
            ValidateMaxLength() {
                if( this.fieldValue.length <= this.fieldCheckValue ) {
                    return true;
                }
                this.fieldValidationMessage += '<br />- Dit veld mag maximaal ' + this.fieldCheckValue + ' tekens bevatten.';
                return false;
            }

        }

    </script>
@endsection
