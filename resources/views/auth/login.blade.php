@inject('logInForm', \App\Helpers\FormBuilder )
@extends( 'templates.account-page' )

@section( 'content' )
    <main>
        <div class="textblock textblock--small-margin-bottom">
            <h1>{{ __('Login') }}</h1>
        </div>
        {{ $logInForm -> setFormID( 'form-login' ) }}
        {{ $logInForm -> setFormAction( route( 'login' ) ) }}
        {{ $logInForm -> addCSRFField( csrf_token() ) }}
        {{ $logInForm -> addTextInputField( ) }}
        {{ $logInForm -> renderForm() }}
        <form class="form form--default form--login" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form__field form__text-field form__field--email">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" name="email"
                       value="{{ old( 'email' ) }}" required autocomplete="email" autofocus>
                <span class="form__icon"></span>
                @error( 'email' )
                <span class="form__error-message" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__field form__text-field form__field--password">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password"
                       name="password" required autocomplete="current-password">
                <span class="form__icon"></span>
                @error( 'password' )
                <span class="form__error-message" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__field form__checkbox-field form__field--remember">
                <input type="checkbox" name="remember"
                       id="remember" {{ old( 'remember' ) ? 'checked' : '' }}>
                <label for="remember">{{ __('Remember Me') }}</label>
            </div>

            <div class="form__field form__button-field form__field--submit">
                <button type="submit" class="button button--default button--with-icon"><i class="fas fa-key icon-holder"></i>{{ __( 'Login' ) }}</button>
                    @if (Route::has( 'password.request' ))
                        <a href="{{ route( 'password.request' ) }}">{{ __( 'Forgot your password?' ) }}</a>
                    @endif
            </div>

        </form>
    </main>
@endsection
