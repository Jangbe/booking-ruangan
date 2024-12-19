@extends('layouts.auth')

@section('content')
    <!-- Signup Form -->
    <form id="signupForm" action="{{ route('register') }}" method="POST">
        @csrf

        <label for="name">Nama</label>
        <input type="text" id="name" name="name" placeholder="Input Nama" value="{{ old('name') }}"
            class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Input email" value="{{ old('email') }}"
            class="form-control @error('email') is-invalid @enderror">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Input password"
            class="form-control @error('password') is-invalid @enderror">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Input password again"
            class="form-control">

        <button type="submit" class="button mt-4">DAFTAR</button>
    </form>

    <p>Punya akun? <a href="/login">Login</a></p>
@endsection
