@extends('layouts.app')
@section('title', 'Sign In | Luxora Yachts')
@section('body-class', 'dark')

@section('content')
<section class="auth">
    <div class="auth__image" style="background-image:url('{{ asset('images/charter-hero.jpg') }}')">
        <p>THE WORLD IS YOURS TO DISCOVER</p>
    </div>
    <div class="auth__content">
        <small>WELCOME BACK</small>
        <h1>SIGN IN</h1>
        <p class="auth__intro">Access your Luxora account and continue planning your time on the water.</p>
        <form method="POST" action="{{ route('login.authenticate') }}" class="form auth__form">
            @csrf
            <label for="email">EMAIL ADDRESS</label>
            <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required autofocus>
            @error('email')<em>{{ $message }}</em>@enderror
            <label for="password">PASSWORD</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
            @error('password')<em>{{ $message }}</em>@enderror
            <label class="auth__remember"><input name="remember" type="checkbox" value="1"> Keep me signed in</label>
            <button type="submit">SIGN IN</button>
        </form>
        <p class="auth__switch">New to Luxora? <a href="{{ route('register') }}">Create an account</a></p>
    </div>
</section>
@endsection
