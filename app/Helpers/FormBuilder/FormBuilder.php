<?php

namespace App\Helpers;

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
    private $formString = "";
    private $formElement = "";
    private $formHTML = "";
    private $formHiddenFieldsHTML = "";

    /* Form attributes */
    private $formID = "";
    private $formClass = "form-standard";
    private $formAction = "";
    private $formMethod = "POST";

    /* Form classes */
    private $formClassPrefix = 'form-standard';
    private $formHiddenInputFieldClass;
    private $formTextInputFieldClass;
    private $formNumberInputFieldClass;
    private $formEmailInputFieldClass;
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

        /* Set the variables */
        $this -> formHiddenInputFieldClass = $this -> formClassPrefix . '__input-hidden-field';
        $this -> formTextInputFieldClass = $this -> formClassPrefix . '__input-text-field';
        $this -> formEmailInputFieldClass = $this -> formClassPrefix . '__input-email-field';
        $this -> formTextareaFieldClass = $this -> formClassPrefix . '__textarea-field';

        $this -> formSubmitInputFieldClass = $this -> formClassPrefix . '__input-submit-field';
        $this -> formSubmitButtonClass = $this -> formClassPrefix . '__button-submit-field';
    }

    public function setFormDebug( $formDebug ) {
        $this -> formDebug = $formDebug;
    }
    public function setFormAction( $formAction ) {
        $this -> formAction = $formAction;
    }
    public function setFormClass( $formClass ) {
        $this -> formClass = $formClass;
    }
    public function setFormID( $formID ) {
        $this -> formID = $formID;
    }

    public function getCSRFToken() {
        return $_SESSION[ 'csrf-token' ];
    }

    public function addHTML( $html ) {
        $this -> formHTML .= $html;
    }

    public function addCSRFField( $csrfValue ) {
        $this -> addHiddenInputField('csrf-' . FormBuilder::$uniqueFormNumber, '', '_token', '', $csrfValue, 'required:true' );
    }

    public function addHiddenInputField( $fieldID, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $javaScriptChecks ) {
        $fieldHTML  = "<div class='form-standard__field form-standard__field--hidden' data-field-status=''>";
        $fieldClass = $this -> getFieldClasses( $this -> formHiddenInputFieldClass, $fieldAdditionalClass );
        $fieldHTML .= "<input type='hidden' id='" . $fieldID . "' class='" . $fieldClass . "' name='" . $fieldName . "' value='" . $fieldValue . "'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= "/>";
        $fieldHTML .= "</div>";

        $this -> formHiddenFieldsHTML .= $fieldHTML;
    }

    public function addTextInputField( $fieldID, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $fieldPlaceholder, $fieldAutocomplete, $useLabel, $labelText, $javaScriptChecks ) {
        $fieldHTML  = "<div class='form-standard__field form-standard__field--text' data-field-status=''>";
        $fieldHTML .= $this -> addLabel( $useLabel, $labelText, $fieldID );
        $fieldClass = $this -> getFieldClasses( $this -> formTextInputFieldClass, $fieldAdditionalClass );
        $fieldValue = $this -> checkFieldValue( $fieldValue, $fieldName );
        $fieldHTML .= "<input type='text' id='" . $fieldID . "' class='" . $fieldClass . "' name='" . $fieldName . "' placeholder='{$fieldPlaceholder}' autocomplete='{$fieldAutocomplete}' value='" . $fieldValue . "'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= "/>";
        $fieldHTML .= $this -> getFieldStatusHTML();
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }
    public function addEmailInputField( $fieldID, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $fieldPlaceholder, $fieldAutocomplete, $useLabel, $labelText, $javaScriptChecks ) {
        $fieldHTML  = "<div class='form-standard__field form-standard__field--email' data-field-status=''>";
        $fieldHTML .= $this -> addLabel( $useLabel, $labelText, $fieldID );
        $fieldClass = $this -> getFieldClasses( $this -> formEmailInputFieldClass, $fieldAdditionalClass );
        $fieldValue = $this -> checkFieldValue( $fieldValue, $fieldName );
        $fieldHTML .= "<input type='email' id='" . $fieldID . "' class='" . $fieldClass . "' name='" . $fieldName . "' placeholder='{$fieldPlaceholder}' autocomplete='{$fieldAutocomplete}' value='" . $fieldValue . "'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= "/>";
        $fieldHTML .= $this -> getFieldStatusHTML();
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }
    public function addSubmitInputField( $buttonID, $buttonAdditionalClass, $buttonName, $buttonHTMLAttributes, $buttonValue ) {
        $fieldHTML  = "<div class='form-standard__field form-standard__field--submit' data-field-status=''>";
        $fieldClass = $this -> getFieldClasses( $this -> formSubmitInputFieldClass, $buttonAdditionalClass );
        $fieldHTML .= "<input type='submit' id='" . $buttonID . "' class='" . $fieldClass . "' name='" . $buttonName . "' value='" . $buttonValue . "'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $buttonHTMLAttributes );
        $fieldHTML .= "/>";
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }

    public function addTextareaField( $fieldID, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $fieldPlaceholder, $fieldAutocomplete, $useLabel, $labelText, $javaScriptChecks ) {
        $fieldHTML  = "<div class='form-standard__field form-standard__field--textarea' data-field-status=''>";
        $fieldHTML .= $this -> addLabel( $useLabel, $labelText, $fieldID );
        $fieldClass = $this -> getFieldClasses( $this -> formTextareaFieldClass, $fieldAdditionalClass );
        $fieldValue = $this -> checkFieldValue( $fieldValue, $fieldName );
        $fieldHTML .= "<textarea id='" . $fieldID . "' class='" . $fieldClass . "' name='" . $fieldName . "' placeholder='{$fieldPlaceholder}' autocomplete='{$fieldAutocomplete}'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $fieldHTMLAttributes );
        $fieldHTML .= $this -> addJavaScriptChecks( $javaScriptChecks );
        $fieldHTML .= ">{$fieldValue}</textarea>";
        $fieldHTML .= $this -> getFieldStatusHTML();
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }

    public function addSelectField( $fieldID, $fieldAdditionalClass, $fieldName, $fieldHTMLAttributes, $fieldValue, $fieldAutocomplete, $optionsArray, $useLabel, $labelText, $javaScriptChecks ) {
        $fieldHTML  = "<div class='form-standard__field form-standard__field--select' data-field-status=''>";
        $fieldHTML .= $this -> addLabel( $useLabel, $labelText, $fieldID );
        $fieldClass = $this -> getFieldClasses( $this -> formSelectFieldClass, $fieldAdditionalClass );
        $fieldHTML .= "<select id='" . $fieldID . "' class='" . $fieldClass . "' name='" . $fieldName . "' autocomplete='{$fieldAutocomplete}'";
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
        $fieldHTML .= $this -> getFieldStatusHTML();
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }

    public function addSubmitButton( $buttonID, $buttonAdditionalClass, $buttonName, $buttonHTMLAttributes, $buttonValue ) {
        $fieldHTML  = "<div class='form-standard__field form-standard__field--button' data-field-status=''>";
        $fieldClass = $this -> getFieldClasses( $this -> formSubmitButtonClass, $buttonAdditionalClass );
        $fieldHTML .= "<button type='submit' id='" . $buttonID . "' class='" . $fieldClass . "' name='" . $buttonName . "' value='submit'";
        $fieldHTML .= $this -> addFieldHTMLAttributes( $buttonHTMLAttributes );
        $fieldHTML .= ">{$buttonValue}</button>";
        $fieldHTML .= "</div>";

        $this -> formHTML .= $fieldHTML;
    }

    public function renderForm() {
        $this -> checkFormID();
        $this -> addHiddenInputField( '__form-id', '', '__form-id', '', $this -> formID, 'required:true' );

        $this -> formElement = "<form class='" . $this -> formClass . "' id='" . $this -> formID . "' action='" . $this -> formAction . "' method='" . $this -> formMethod . "'>";
        $this -> formString .= $this -> formElement;
        $this -> formString .= $this -> formHiddenFieldsHTML;
        $this -> formString .= $this -> formHTML;
        $this -> formString .= "</form>";

        if( $this -> formDebug ) {
            $this -> debug();
        }

        echo $this -> formString;
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
            $javaScriptChecksHTML = " data-form-js-check='true' data-form-js-checks='" . $javaScriptChecks . "'";
        } else {
            $javaScriptChecksHTML = " data-form-js-check='false'";
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

    private function getFieldClasses( $fieldClass, $fieldAdditionalClass ) {
        if( !empty( $fieldAdditionalClass ) ) {
            return $fieldClass . ' ' . $fieldAdditionalClass;
        } else {
            return $fieldClass;
        }
    }
    private function getFieldStatusHTML() {
        $fieldStatusHTML  = '';
        $fieldStatusHTML .= '<div class="form-standard__status-holder">';
        $fieldStatusHTML .= '<span class="form-standard__status-holder-tooltip"></span>';
        $fieldStatusHTML .= '<span class="form-standard__status-holder-icons"></span>';
        $fieldStatusHTML .= '</div>';
        return $fieldStatusHTML;
    }

    private function checkFieldValue( $fieldValue, $fieldName ) {
        if( !empty( $fieldValue ) ) {
            return $fieldValue;
        }
        if( !empty( $_POST[ $fieldName ] ) ) {
            return $_POST[ $fieldName ];
        }
        return "";
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
