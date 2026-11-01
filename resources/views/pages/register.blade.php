@extends('layouts.app')
@section('title', 'Create an Account | Luxora Yachts')
@section('body-class', 'dark')

@section('content')
<section class="auth">
    <div class="auth__image auth__image--register" style="background-image:url('{{ asset('images/island.jpg') }}')">
        <p>MAKE SPACE FOR THE EXTRAORDINARY</p>
    </div>
    <div class="auth__content">
        <small>YOUR JOURNEY STARTS HERE</small>
        <h1>CREATE AN ACCOUNT</h1>
        <p class="auth__intro">Join Luxora for considered inspiration and a more personal yachting experience.</p>
        <form method="POST" action="{{ route('register.store') }}" class="form auth__form">
            @csrf
            <label for="name">FULL NAME</label>
            <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" required autofocus>
            @error('name')<em>{{ $message }}</em>@enderror
            <label for="email">EMAIL ADDRESS</label>
            <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required>
            @error('email')<em>{{ $message }}</em>@enderror
            <label for="password">PASSWORD</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required>
            @error('password')<em>{{ $message }}</em>@enderror
            <label for="password_confirmation">CONFIRM PASSWORD</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
            <button type="submit">CREATE ACCOUNT</button>
        </form>
        <p class="auth__switch">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
    </div>
</section>
@endsection
