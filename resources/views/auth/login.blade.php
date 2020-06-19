@inject('logInForm', \App\Helpers\FormBuilder )
@extends( 'templates.account-page' )

@section( 'content' )
    <main>

        <div class="textblock textblock--small-margin-bottom">
            <h1>{{ __('Login') }}</h1>
        </div>

        {{ $logInForm -> setFormID( 'form-login' ) }}
        {{ $logInForm -> setFormFieldIDAddPrefix( true ) }}
        {{ $logInForm -> setFormAction( route( 'login' ) ) }}
        {{ $logInForm -> addCSRFField( csrf_token() ) }}
        {{ $logInForm -> addEmailInputField( 'email', '', '', 'email', 'autofocus', old( 'email' ), 'E-mail', 'email', true, __('E-Mail Address'), 'required:true' ) }}
        {{ $logInForm -> addPasswordInputField( 'password', '', '', 'password', '', '', 'Wachtwoord', 'password', true, __('Password'), 'required:true' ) }}
        {{ $logInForm -> addCheckboxInputField( 'remember', '', '', 'remember', '', '', true, __('Remember Me'), '' ) }}
        {{ $logInForm -> addSubmitButton( 'submit', '', '', 'submit', '', __( 'Login' ) ) }}
        @if( Route::has( 'password.request' ) )
            {{ $logInForm -> addHTML( '<a href="' . route( 'password.request' ) . '">' . __( 'Forgot your password?' ) . '</a>' ) }}
        @endif
        {{ $logInForm -> renderForm() }}
        {{-- toevoegen error optie --}}

    </main>
@endsection
