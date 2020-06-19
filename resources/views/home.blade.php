@extends( 'templates.home-page' )

@section( 'content' )
    <div class="textblock textblock--default">
        <h1>Dashboard</h1>
        <p>Your ID is: {{ Auth::user() -> id }}</p>
        <p>Your name is: {{ Auth::user() -> name }}</p>
        <p>Your password is: {{ Auth::user() -> password }}</p>
    </div>
@endsection
