@extends('layouts.app')

@section('title', 'Login - Hotel Paradise')

@section('styles')
<style>
    .auth-container {
        max-width: 500px;
        margin: 120px auto 60px;
        padding: 0 5%;
    }

    .auth-card {
        background: var(--white);
        padding: 3rem;
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
    }

    .auth-card h1 {
        text-align: center;
        color: var(--secondary-color);
        margin-bottom: 2rem;
        font-size: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-color);
    }

    .form-group input {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        font-family: 'Poppins', sans-serif;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .btn-login {
        width: 100%;
        padding: 1rem;
        background: var(--primary-color);
        color: var(--secondary-color);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        background: var(--accent-color);
        transform: translateY(-2px);
    }

    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #eee;
    }

    .auth-footer p {
        color: var(--text-color);
    }

    .auth-footer a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }

    .error-list {
        list-style: none;
        padding: 0;
    }

    .error-list li {
        padding: 0.5rem 0;
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1><i class="fas fa-sign-in-alt"></i> Login</h1>

        @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>Login Gagal!</strong>
                <ul class="error-list" style="margin-top: 0.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="email@example.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan password">
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <div class="auth-footer">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
            <p style="margin-top: 1rem; font-size: 0.9rem; color: var(--accent-color);">
                Test Account:<br>
                Email: <strong>admin@hotelparadise.com</strong><br>
                Password: <strong>password</strong>
            </p>
        </div>
    </div>
</div>
@endsection
