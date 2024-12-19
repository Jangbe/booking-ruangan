@extends('layouts.auth')

@section('content')
    <!-- Login Form -->
    <form id="loginForm" class="form" method="POST" action="{{ route('login') }}">
        @csrf
        <label for="loginEmail">Email</label>
        <input type="email" name="email" id="loginEmail" value="{{ old('email') }}"
            class="form-control @error('email') is-invalid @enderror" placeholder="Input email">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="loginPassword">Password</label>
        <input type="password" name="password" id="loginPassword"
            class="form-control @error('password') is-invalid @enderror" placeholder="Input password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Lupa Katasandi?') }}
            </a>
        @endif

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label mt-0" for="remember">
                {{ __('Ingat Saya') }}
            </label>
        </div>

        <button type="submit" class="button">LOGIN</button>
    </form>
    
    <p>Belum punya akun? <a href="/register">Daftar</a></p> <!-- New Link Added Here -->
@endsection
