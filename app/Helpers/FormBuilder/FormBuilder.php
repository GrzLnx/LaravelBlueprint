<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ViewErrorBag;

class FormBuilder
{
    /** Class structure:
     * 1. Defining the variables.
     * 2. Default functions ( __ ).
     * 3. set functions.
     * 4. get functions.
     * 5. public functions.
     * 6. private functions.
     */

    static $uniqueFormNumber = 0;

    /* Class form settings */
    private $formDebug = false;
    private $formFieldIDAddPrefix = true;
    private $formUseJavaScriptCheck = true;
    private $formString = "";
    private $formElement = "";
    private $formHTML = "";
    private $formHiddenFieldsHTML = "";
    private $formJSFunction = "";
    private $formJSString = "";

    /* Form attributes */
    private $formID = "";
    private $formClass = "form-standard";
    private $formAdditionalClasses = "";
    private $formAction = "";
    private $formMethod = "POST";

    /* Form classes */
    private $formClassPrefix = 'form-standard';
    private $formHiddenInputFieldClass;
    private $formTextInputFieldClass;
    private $formNumberInputFieldClass;
    private $formEmailInputFieldClass;
    private $formPasswordInputFieldClass;
    private $formCheckboxInputFieldClass;
    private $formRadioInputFieldClass;
    private $formSearchInputFieldClass;
    private $formTimeInputFieldClass;
    private $formDateInputFieldClass;
    private $formFileInputFieldClass;
    private $formTelInputFieldClass;
    private $formSubmitInputFieldClass;
    private $formTextareaFieldClass;
    private $formSelectFieldClass;
    private $formSubmitButtonClass;

    public function __construct() {
        FormBuilder::$uniqueFormNumber++;
    }

    public function setFormDebug( $formDebug ) {
        $this -> formDebug = $formDebug;
    }
    public function setFormFieldIDAddPrefix( $formFieldIDAddPrefix ) {
        $this -> formFieldIDAddPrefix = $formFieldIDAddPrefix;
    }
    public function setFormClassPrefix( $formClassPrefix ) {
        $this -> formClassPrefix = $formClassPrefix;
    }
    public function setFormAction( $formAction ) {
        $this -> formAction = $formAction;
    }
    public function setFormClass( $formClass ) {
        $this -> formClass = $formClass;
    }
    public function setFormAdditionalClasses( $formClasses ) {
        $this -> formAdditionalClasses = $formClasses;
    }
    public function setFormID( $formID ) {
        $this -> formID = $formID;
    }
    public function setFormClasses() {
        $this -> formHiddenInputFieldClass = $this -> formClassPrefix . '__input-hidden-field';
        $this -> formTextInputFieldClass   = $this -> formClassPrefix . '__input-text-field';
        $this -> formNumberInputFieldClass = $this -> formClassPrefix . '__input-number-field';
        $this -> formEmailInputFieldClass  = $this -> formClassPrefix . '__input-email-field';
        $this -> formSearchInputFieldClass = $this -> formClassPrefix . '__input-search-field';
        $this -> formTimeInputFieldClass   = $this -> formClassPrefix . '__input-time-field';
        $this -> formDateInputFieldClass   = $this -> formClassPrefix . '__input-date-field';
        $this -> formFileInputFieldClass   = $this -> formClassPrefix . '__input-file-field';
        $this -> formTelInputFieldClass    = $this -> formClassPrefix . '__input-tel-field';
        $this -> formTextareaFieldClass    = $this -> formClassPrefix . '__textarea-field';

        $this -> formSubmitInputFieldClass = $this -> formClassPrefix . '__input-submit-field';
        $this -> formSubmitButtonClass     = $this -> formClassPrefix . '__button-submit-field';
    }

    public function getCSRFToken() {
        return $_SESSION[ 'csrf-token' ];
    }
    public function getFormClassPrefix() {
        return $this -> formClassPrefix;
    }
    public function getFormAdditionalClasses() {
        return $this -> formAdditionalClasses;
    }

    public function addHTML( $html ) {
        $this -> formHTML .= $html;
    }

    public function addCSRFField( $csrfValue ) {
        $this -> addHiddenInputField('csrf-' . FormBuilder::$uniqueFormNumber, '', '_token', '', $csrfValue, 'required:true' );
    }

    public function addHiddenInputField( $fieldID, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $javaScriptChecks ) {
        $fieldHTML  = "<div class='form-standard__field form-standard__field--hidden' data-field-status=''>";
        $fieldNewID = $this -> getFieldID( $fieldID );
        $fieldClass = $this -> getFieldClasses( $this -> formHiddenInputFieldClass, $fieldAdditionalClass );
        $fieldHTML .= "<input type='hidden' id='" . $fieldNewID . "' class='" . $fieldClass . "' name='" . $fieldName . "' value='" . $fieldValue . "'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= "/>";
        $fieldHTML .= "</div>";

        $this -> formHiddenFieldsHTML .= $fieldHTML;
    }

    public function addTextInputField( $fieldID, $fieldHolderClass, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $fieldPlaceholder, $fieldAutocomplete, $useLabel, $labelText, $javaScriptChecks ) {
        $fieldHTML  = "";
        $fieldHasError = $this -> checkError( $fieldName );
        if( empty( $fieldHolderClass ) ) {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--text' data-field-status='{$fieldHasError}'>";
        } else {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--text {$fieldHolderClass}' data-field-status='{$fieldHasError}'>";
        }
        $fieldNewID = $this -> getFieldID( $fieldID );
        $fieldHTML .= $this -> addLabel( $useLabel, $labelText, $fieldNewID );
        $fieldClass = $this -> getFieldClasses( $this -> formTextInputFieldClass, $fieldAdditionalClass );
        $fieldValue = $this -> checkFieldValue( $fieldValue, $fieldName );
        $fieldHTML .= "<input type='text' id='" . $fieldNewID . "' class='" . $fieldClass . "' name='" . $fieldName . "' placeholder='{$fieldPlaceholder}' autocomplete='{$fieldAutocomplete}' value='" . $fieldValue . "'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= "/>";
        $fieldErrorMessage = $this -> getErrorMessage( $fieldName );
        $fieldHTML .= $this -> getFieldStatusHTML( $fieldErrorMessage );
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }
    public function addEmailInputField( $fieldID, $fieldHolderClass, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $fieldPlaceholder, $fieldAutocomplete, $useLabel, $labelText, $javaScriptChecks ) {
        $fieldHTML  = "";
        $fieldHasError = $this -> checkError( $fieldName );
        if( empty( $fieldHolderClass ) ) {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--email' data-field-status='{$fieldHasError}'>";
        } else {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--email {$fieldHolderClass}' data-field-status='{$fieldHasError}'>";
        }
        $fieldNewID = $this -> getFieldID( $fieldID );
        $fieldHTML .= $this -> addLabel( $useLabel, $labelText, $fieldNewID );
        $fieldClass = $this -> getFieldClasses( $this -> formEmailInputFieldClass, $fieldAdditionalClass );
        $fieldValue = $this -> checkFieldValue( $fieldValue, $fieldName );
        $fieldHTML .= "<input type='email' id='" . $fieldNewID . "' class='" . $fieldClass . "' name='" . $fieldName . "' placeholder='{$fieldPlaceholder}' autocomplete='{$fieldAutocomplete}' value='" . $fieldValue . "'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= "/>";
        $fieldErrorMessage = $this -> getErrorMessage( $fieldName );
        $fieldHTML .= $this -> getFieldStatusHTML( $fieldErrorMessage );
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }
    public function addPasswordInputField( $fieldID, $fieldHolderClass, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $fieldPlaceholder, $fieldAutocomplete, $useLabel, $labelText, $javaScriptChecks ) {
        $fieldHTML  = "";
        $fieldHasError = $this -> checkError( $fieldName );
        if( empty( $fieldHolderClass ) ) {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--password' data-field-status='{$fieldHasError}'>";
        } else {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--password {$fieldHolderClass}' data-field-status='{$fieldHasError}'>";
        }
        $fieldNewID = $this -> getFieldID( $fieldID );
        $fieldHTML .= $this -> addLabel( $useLabel, $labelText, $fieldNewID );
        $fieldClass = $this -> getFieldClasses( $this -> formPasswordInputFieldClass, $fieldAdditionalClass );
        $fieldValue = $this -> checkFieldValue( $fieldValue, $fieldName );
        $fieldHTML .= "<input type='password' id='" . $fieldNewID . "' class='" . $fieldClass . "' name='" . $fieldName . "' placeholder='{$fieldPlaceholder}' autocomplete='{$fieldAutocomplete}' value='" . $fieldValue . "'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= "/>";
        $fieldErrorMessage = $this -> getErrorMessage( $fieldName );
        $fieldHTML .= $this -> getFieldStatusHTML( $fieldErrorMessage );
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }
    public function addSubmitInputField( $buttonID, $buttonHolderClass, $buttonAdditionalClass, $buttonName, $buttonHTMLAttributes, $buttonValue ) {
        $fieldHTML  = "";
        $fieldHasError = $this -> checkError( $buttonName );
        if( empty( $buttonHolderClass ) ) {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--submit' data-field-status='{$fieldHasError}'>";
        } else {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--submit {$buttonHolderClass}' data-field-status='{$fieldHasError}'>";
        }
        $fieldNewID = $this -> getFieldID( $buttonID );
        $fieldClass = $this -> getFieldClasses( $this -> formSubmitInputFieldClass, $buttonAdditionalClass );
        $fieldHTML .= "<input type='submit' id='" . $fieldNewID . "' class='" . $fieldClass . "' name='" . $buttonName . "' value='" . $buttonValue . "'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $buttonHTMLAttributes );
        $fieldHTML .= "/>";
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }

    public function addRadioInputField( $fieldID, $fieldHolderClass, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $useLabel, $labelText, $javaScriptChecks ) {
        $fieldHTML  = "";
        $fieldHasError = $this -> checkError( $fieldName );
        if( empty( $fieldHolderClass ) ) {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--radio' data-field-status='{$fieldHasError}'>";
        } else {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--radio {$fieldHolderClass}' data-field-status='{$fieldHasError}'>";
        }
        $fieldNewID = $this -> getFieldID( $fieldID );
        $fieldClass = $this -> getFieldClasses( $this -> formRadioInputFieldClass, $fieldAdditionalClass );
        $fieldCheck = $this -> checkRadioValue( $fieldValue, $fieldName );
        $fieldHTML .= "<input type='radio' id='" . $fieldNewID . "' class='" . $fieldClass . "' name='" . $fieldName . "' value='" . $fieldValue . "{$fieldCheck}'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= "/>";
        $fieldHTML .= $this -> addLabel( $useLabel, $labelText, $fieldNewID );
        $fieldErrorMessage = $this -> getErrorMessage( $fieldName );
        $fieldHTML .= $this -> getFieldStatusHTML( $fieldErrorMessage );
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }
    public function addCheckboxInputField( $fieldID, $fieldHolderClass, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $useLabel, $labelText, $javaScriptChecks ) {
        $fieldHTML  = "";
        $fieldHasError = $this -> checkError( $fieldName );
        if( empty( $fieldHolderClass ) ) {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--checkbox' data-field-status='{$fieldHasError}'>";
        } else {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--checkbox {$fieldHolderClass}' data-field-status='{$fieldHasError}'>";
        }
        $fieldNewID = $this -> getFieldID( $fieldID );
        $fieldClass = $this -> getFieldClasses( $this -> formCheckboxInputFieldClass, $fieldAdditionalClass );
        $fieldCheck = $this -> checkCheckboxValue( $fieldValue, $fieldName );
        $fieldHTML .= "<input type='checkbox' id='" . $fieldNewID . "' class='" . $fieldClass . "' name='" . $fieldName . "' value='" . $fieldValue . "{$fieldCheck}'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= "/>";
        $fieldHTML .= $this -> addLabel( $useLabel, $labelText, $fieldNewID );
        $fieldErrorMessage = $this -> getErrorMessage( $fieldName );
        $fieldHTML .= $this -> getFieldStatusHTML( $fieldErrorMessage );
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }

    public function addTextareaField( $fieldID, $fieldHolderClass, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $fieldPlaceholder, $fieldAutocomplete, $useLabel, $labelText, $javaScriptChecks ) {
        $fieldHTML  = "";
        $fieldHasError = $this -> checkError( $fieldName );
        if( empty( $fieldHolderClass ) ) {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--textarea' data-field-status='{$fieldHasError}'>";
        } else {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--textarea {$fieldHolderClass}' data-field-status='{$fieldHasError}'>";
        }
        $fieldNewID = $this -> getFieldID( $fieldID );
        $fieldHTML .= $this -> addLabel( $useLabel, $labelText, $fieldNewID );
        $fieldClass = $this -> getFieldClasses( $this -> formTextareaFieldClass, $fieldAdditionalClass );
        $fieldValue = $this -> checkFieldValue( $fieldValue, $fieldName );
        $fieldHTML .= "<textarea id='" . $fieldNewID . "' class='" . $fieldClass . "' name='" . $fieldName . "' placeholder='{$fieldPlaceholder}' autocomplete='{$fieldAutocomplete}'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= ">{$fieldValue}</textarea>";
        $fieldErrorMessage = $this -> getErrorMessage( $fieldName );
        $fieldHTML .= $this -> getFieldStatusHTML( $fieldErrorMessage );
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }

    public function addSelectField( $fieldID, $fieldHolderClass, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $fieldAutocomplete, $optionsArray, $useLabel, $labelText, $javaScriptChecks ) {
        $fieldHTML  = "";
        $fieldHasError = $this -> checkError( $fieldName );
        if( empty( $fieldHolderClass ) ) {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--select' data-field-status='{$fieldHasError}'>";
        } else {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--select {$fieldHolderClass}' data-field-status='{$fieldHasError}'>";
        }
        $fieldNewID = $this -> getFieldID( $fieldID );
        $fieldHTML .= $this -> addLabel( $useLabel, $labelText, $fieldNewID );
        $fieldClass = $this -> getFieldClasses( $this -> formSelectFieldClass, $fieldAdditionalClass );
        $fieldHTML .= "<select id='" . $fieldNewID . "' class='" . $fieldClass . "' name='" . $fieldName . "' autocomplete='{$fieldAutocomplete}'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= " />";
        foreach( $optionsArray as $option ) {
            $fieldHTML .= "<option value='" . $option[ 'value' ] . "'";
            if( $option[ 'value' ] === $fieldValue ) { $fieldHTML .= " selected"; }
            if( strlen( $option[ 'HTMLAttributes' ] ) !== 0 ) { $fieldHTML .= " " . $option[ 'HTMLAttributes' ]; }
            $fieldHTML .= ">" . $option[ 'name' ] . "</option>";
        }
        $fieldHTML .= "</select>";
        $fieldErrorMessage = $this -> getErrorMessage( $fieldName );
        $fieldHTML .= $this -> getFieldStatusHTML( $fieldErrorMessage );
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }

    public function addSubmitButton( $buttonID, $buttonHolderClass, $buttonAdditionalClass, $buttonName, $buttonHTMLAttributes, $buttonValue ) {
        $fieldHTML  = "";
        $fieldHasError = $this -> checkError( $buttonName );
        if( empty( $buttonHolderClass ) ) {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--button' data-field-status='{$fieldHasError}'>";
        } else {
            $fieldHTML .= "<div class='form-standard__field form-standard__field--button {$buttonHolderClass}' data-field-status='{$fieldHasError}'>";
        }
        $fieldNewID = $this -> getFieldID( $buttonID );
        $fieldClass = $this -> getFieldClasses( $this -> formSubmitButtonClass, $buttonAdditionalClass );
        $fieldHTML .= "<button type='submit' id='" . $fieldNewID . "' class='" . $fieldClass . "' name='" . $buttonName . "' value='submit'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $buttonHTMLAttributes );
        $fieldHTML .= ">{$buttonValue}</button>";
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }

    // form id submit met js als dat moet, onclick js functie uitvoeren

    public function renderForm() {
        $this -> checkFormID();
        $this -> addHiddenInputField( 'form-id', '', '__form-id', '', $this -> formID, 'required:true' );

        $formClasses = $this -> getFormClasses();
        if( $this -> formUseJavaScriptCheck ) {
            $this -> formElement = "<form class='" . $formClasses . "' id='" . $this -> formID . "' action='" . $this -> formAction . "' method='" . $this -> formMethod . "' onsubmit='return checkForm( this );'>";
        } else {
            $this -> formElement = "<form class='" . $formClasses . "' id='" . $this -> formID . "' action='" . $this -> formAction . "' method='" . $this -> formMethod . "'>";
        }
        $this -> formString .= $this -> formElement;
        $this -> formString .= $this -> formHiddenFieldsHTML;
        $this -> formString .= $this -> formHTML;
        $this -> formString .= "</form>";

        if( $this -> formDebug ) {
            $this -> debug();
        }

        echo $this -> formString;
        echo $this -> formJSString;
    }

    private function addLabel( $useLabel, $labelText, $fieldID ) {
        $labelHTML = "";
        if( $useLabel ) {
            $labelHTML = "<label for='{$fieldID}'>{$labelText}</label>";
        }
        return $labelHTML;
    }
    private function addJavaScriptChecks( $javaScriptChecks ) {
        if( strlen( $javaScriptChecks ) !== 0 ) {
            $javaScriptChecksHTML = " data-field-js-check='true' data-field-js-checks='" . $javaScriptChecks . "'";
        } else {
            $javaScriptChecksHTML = " data-field-js-check='false'";
        }
        return $javaScriptChecksHTML;
    }
    private function addFieldHTMLAttributes( $HTMLAttributes ) {
        $fieldHTMLAttributes = "";
        if( strlen( $HTMLAttributes ) !== 0 ) {
            $fieldHTMLAttributes = ' ' . $HTMLAttributes;
        }
        return $fieldHTMLAttributes;
    }

    private function getFormClasses() {
        $this -> formClass;
        if( !empty( $this -> formAdditionalClasses ) ) {
            return $this -> formClass . ' ' . $this -> formAdditionalClasses;
        } else {
            return $this -> formClass;
        }
    }
    private function getFieldClasses( $fieldClass, $fieldAdditionalClass ) {
        if( !empty( $fieldAdditionalClass ) ) {
            return $fieldClass . ' ' . $fieldAdditionalClass;
        } else {
            return $fieldClass;
        }
    }
    private function getFieldID( $fieldID ) {
        if( $this -> formFieldIDAddPrefix ) {
            return $this -> formID . '-' . $fieldID;
        } else {
            return $fieldID;
        }
    }
    private function getFieldStatusHTML( $tooltipText ) {
        $fieldStatusHTML  = '';
        $fieldStatusHTML .= '<div class="form-standard__status-holder">';
        $fieldStatusHTML .= '<span class="form-standard__status-holder-tooltip">' . $tooltipText . '</span>';
        $fieldStatusHTML .= '<span class="form-standard__status-holder-icons"></span>';
        $fieldStatusHTML .= '</div>';
        return $fieldStatusHTML;
    }
    private function getErrorMessage( $fieldName ) {
        $formErrors = Session::get('errors', new ViewErrorBag) -> {'default'} -> messages();
        if( count( $formErrors ) !== 0 ) {
            if( key_exists( $fieldName, $formErrors ) ) {
                return $formErrors[$fieldName][0];
            }
        }
        return '';
    }

    private function checkFieldValue( $fieldValue, $fieldName ) {
        if( !empty( $fieldValue ) ) {
            return $fieldValue;
        }
        if( !empty( $_POST[ $fieldName ] ) ) {
            return $_POST[ $fieldName ];
        }
        return '';
    }
    private function checkRadioValue( $fieldValue, $fieldName ) {
        if( !empty( $_POST[ $fieldName ] ) ) {
            if( $fieldValue === $_POST[ $fieldName ] ) {
                return ' checked';
            }
        }
        return '';
    }
    private function checkCheckboxValue( $fieldValue, $fieldName ) {
        if( !empty( $_POST[ $fieldName ] ) ) {
            if( $fieldValue === $_POST[ $fieldName ] ) {
                return ' checked';
            }
        }
        return "";
    }
    private function checkError( $fieldName ) {
        $formErrors = Session::get('errors', new ViewErrorBag) -> {'default'} -> messages();
        if( count( $formErrors ) !== 0 ) {
            if( key_exists( $fieldName, $formErrors ) ) {
                return 'error';
            }
        }
        return '';
    }
    private function checkFormID() {
        if( empty( $this -> formID ) ) {
            $this -> formID = 'form-' . FormBuilder::$uniqueFormNumber;
        }
    }

    private function debug() {
        if( !empty( $_POST[ 'submit' ] ) ) {

            /* Debug the CSRF */
            if( hash_equals( $_SESSION[ 'csrf-token' ], $_POST[ 'csrf' ] ) ) {
                echo '<pre>The CSRF is correct. <br />The submitted CSRF was: ' . $_POST[ 'csrf' ] . '<br />The correct CSRF was: ' . $_SESSION[ 'csrf-token' ] . '</pre>';
            } else {
                echo '<pre>The CSRF is correct. <br />The submitted CSRF was: ' . $_POST[ 'csrf' ] . '<br />The correct CSRF was: ' . $_SESSION[ 'csrf-token' ] . '</pre>';
            }

            /* Debug the post data */
            echo '<pre>';
            foreach( $_POST as $key => $value ) {
                echo "Field: " . htmlspecialchars( $key ) ." is ". htmlspecialchars( $value ) . "<br>";
            }
            echo '</pre>';

        }
    }

}
