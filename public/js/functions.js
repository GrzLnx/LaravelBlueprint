/** Standard JavaScript functions **/

/**
 * Function to check if the url contains a string.
 * @param {String} f_URLString - The value the URL has to contains.
 */
function boolURLContains( f_URLString ) {
    return window.location.href.indexOf( f_URLString ) > -1;
}

/**
 * Function to check if the url is the given string.
 * @param {String} f_URLString - The value the URL has to be.
 */
function boolURLIs( f_URLString ) {
    return window.location.pathname === f_URLString;
}

/* Function to change a CSS variable */
function changeVar( var_name, new_value ) {
    document.documentElement.style.setProperty( '--' + var_name, new_value );
}

/** Custom JavaScript functions **/

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

/** Executing the functions **/

/* Code to be executed when the site is loaded. */
function executeOnLoad() {
    createStandardCSSVariables();
}
function executeOnScroll() {
}
function executeOnResize() {
    createStandardCSSVariables();
}

/** -----   -----   -----   -----   -----   -----   -----   -----   -----   -----   ----- **/

window.addEventListener( 'DOMContentLoaded', function() {
    executeOnLoad();
} );
window.addEventListener( 'scroll', event => {
    executeOnScroll();
} );
window.addEventListener( 'resize', event => {
    executeOnResize();
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

customElements.define( 'hold-line', HoldLine );

/** -----   -----   -----
 * JavaScript for the ServiceWorkers.
 * -----   -----   ----- **/

if( 'serviceWorker' in navigator ) {
    navigator.serviceWorker.register( '/serviceworker.js' ).then(
        serviceWorker => console.log( 'The service worker is successfully registered.', serviceWorker )
    ).catch(
        error => console.log( 'The service worker is not registered.', error )
    );
}

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
        if( labelElement.offsetHeight !== 25 ) {
            labelElement.parentElement.style.setProperty( '--form-field--label-height', labelElement.offsetHeight + 'px' );
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
        this.fieldValidator.Form = this.form;
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

    set Form( form ) {
        this.form = form;
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
            case 'password-confirm':
                return this.ValidatePasswordConfirm();
            default:
                return true;
        }
    }

    ValidateRequired() {
        console.log( this.field );
        if( this.fieldCheckValue ) {
            /* Check for group */
            if( this.field.hasAttribute( 'data-field-js-group' ) ) {
                if( this.field.getAttribute( 'data-field-js-group-label' ) === '1' ) {
                    let fieldName = this.field.getAttribute( 'data-field-js-group' );
                    let fields = this.form.querySelectorAll( '[data-field-js-group-label="0"][data-field-js-group="' + fieldName + '"]' );
                    for( let field of fields ) {
                        if( field.checked ) {
                            return true;
                        }
                    }
                    this.fieldValidationMessage += '<br />- Dit veld is verplicht.';
                    return false;
                }
            }
            /* Check for checkbox */
            if( this.field.type === "checkbox" ) {
                if( this.field.checked ) {
                    return true;
                }
                this.fieldValidationMessage += '<br />- Dit veld is verplicht.';
                return false;
            }
            /* The required check for a radio type input field. */
            if( this.field.type === "radio" ) {
                let fieldStatus = false;
                for( let radioInput of this.form.querySelectorAll( '[name="' + this.field.name + '"]' ) ) {
                    console.log( radioInput );
                    if( radioInput.checked ) {
                        fieldStatus = true;
                    }
                }
                if( fieldStatus ) {
                    return true;
                }
                this.fieldValidationMessage += '<br />- Dit veld is verplicht.';
                return false;
            }
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

    ValidatePasswordConfirm() {
        const compareField = this.form.elements[ this.fieldCheckValue ];
        const compareFieldPlaceholder = compareField.placeholder;
        const compareFieldValue = compareField.value;
        if( this.fieldValue === compareFieldValue ) {
            return true;
        }
        this.fieldValidationMessage += '<br />- Dit veld moet gelijk zijn aan het veld ' + compareFieldPlaceholder + '.';
        return false;
    }

}
