/** The standard functions **/

/* Function to check if the url contains a string. */
function url_contains( url_string ) {
    return window.location.href.indexOf( url_string ) > -1;
}

/* Function to change a CSS variable */
function changeVar( var_name, new_value ) {
    document.documentElement.style.setProperty( '--' + var_name, new_value );
}

/** The custom functions **/

function createStandardCSSVariables() {
    changeVar( 'js--screen-width', window.innerWidth + 'px' );
    changeVar( 'js--screen-height', window.innerHeight + 'px' );
}

function toggleTheme() {
    const html_el = document.getElementsByTagName( 'html' )[0];
    const currentTheme = html_el.getAttribute( 'data-theme' );
    if( currentTheme === 'light' ) {
        html_el.setAttribute( 'data-theme', 'dark' );
    } else {
        html_el.setAttribute( 'data-theme', 'light' );
    }
    return true;
}

/** The place to execute the functions **/

/* Code to be executed when the site is loaded. */
function executeOnLoad() {
    createStandardCSSVariables();
}

/** -----   -----   -----   -----   -----   -----   -----   -----   -----   -----   ----- **/

window.addEventListener( 'DOMContentLoaded', function() {
    executeOnLoad();
} );

document.getElementById("theme-button").addEventListener( "click", function() {
    toggleTheme();
} );

/** -----   -----   -----
 * JavaScript for the custom HTML elements.
 * -----   -----   ----- **/

class HoldLine extends HTMLElement {
    constructor() {
        super();
    }
}

customElements.define('hold-line', HoldLine);

/** -----   -----   -----
 * JavaScript for the forms.
 * -----   -----   ----- **/

function checkForm( form ) {
    setFormLabelHeightVar( form );
    const formFieldsToCheck = form.querySelectorAll( '[data-field-js-check="true"]' );
    let formStatus = true;
    for( let formField of formFieldsToCheck ) {
        let checkFormField = new CheckFormField( form, formField );
        checkFormField.CheckField();
        if( !checkFormField.FormFieldStatus ) {
            formStatus = false;
        }
        checkFormField.ChangeNotifyText();
        checkFormField.ChangeFieldStatus();
    }
    console.log( 'form status: ' + formStatus );
    return formStatus;
}

function setFormLabelHeightVar( form ) {
    const labelElements = form.querySelectorAll( 'label:not(.form-standard__status-holder)' );
    for( let labelElement of labelElements ) {
        if( labelElement.offsetHeight !== 23 ) {
            labelElement.parentElement.style.setProperty( '--form-field--label-height', labelElement.offsetHeight );
        }
    }
}

class CheckFormField {

    constructor( form, formField ) {
        this.Form = form;
        this.FormField = formField;
        this.formFieldStatus = true;
        this.formFieldNotifyText = '';
        this.notificationTextHolder = this.formField.parentElement.querySelector( '.form-standard__status-holder-tooltip' );
        this.fieldValidator = new FormFieldValidator();
    }

    set Form( form ) {
        this.form = form;
    }
    set FormField( formField ) {
        this.formField = formField;
    }
    set FormFieldStatus( fieldStatus ) {
        this.formFieldStatus = fieldStatus;
    }

    get FormFieldStatus() {
        return this.formFieldStatus;
    }

    FormJSChecks( jsChecks ) {
        this.fieldValidator.Field = this.formField;
        this.fieldValidator.FieldValue = this.formField.value;
        jsChecks = jsChecks.split( ';' );
        for( let jsCheck of jsChecks ) {
            jsCheck = jsCheck.split( ':' );
            this.fieldValidator.FieldCheck = jsCheck[0];
            this.fieldValidator.FieldCheckValue = jsCheck[1];
            if( !this.fieldValidator.Validate() ) {
                this.FormFieldStatus = false;
            }
        }
    }
    CheckField() {
        let jsChecks = this.formField.getAttribute( 'data-field-js-checks' );
        this.FormJSChecks( jsChecks );
    }
    ChangeFieldStatus() {
        if( this.formFieldStatus ) {
            this.formField.parentElement.setAttribute( 'data-field-status', 'success' );
        } else {
            this.formField.parentElement.setAttribute( 'data-field-status', 'error' );
        }
    }
    ChangeNotifyText() {
        if( this.notificationTextHolder === null ) {
            return;
        }
        this.formFieldNotifyText = this.fieldValidator.FieldValidationMessage;
        if( this.formFieldNotifyText !== false ) {
            this.notificationTextHolder.innerHTML = this.fieldValidator.FieldValidationMessage;
        } else {
            this.notificationTextHolder.innerHTML = '<strong>Dit veld is correct ingevuld!</strong>';
        }
    }

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
        console.log( this.field );
        if( this.fieldCheckValue ) {
            /* Check for checkbox */
            if( this.field.type === "checkbox" ) {
                if( this.field.checked ) {
                    return true;
                }
                this.fieldValidationMessage += '<br />- Dit veld is verplicht.';
                return false;
            }
            /* TODO:: Check for radio */
            /* Check for fields with content */
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
