@extends('layouts.app')

@section('content')
<div class="login-container">
    <h2>Login ORMAWA</h2>

    @if(session('error'))
        <p style="color: yellow; text-align:center;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Login</button>
    </form>
</div>
@endsection
