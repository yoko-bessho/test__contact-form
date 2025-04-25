@extends('layouts.admin-app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('header-nav')
<button class="header-nav__button">
    <a class="nav-link" href="/register">register</a>
</button>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        <h2>Login</h2>
        
        <form method="POST" action="/login">
            @csrf
            
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com" autofocus>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password" placeholder="例: coachtech123">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-button">
                <button type="submit" class="login-btn">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection