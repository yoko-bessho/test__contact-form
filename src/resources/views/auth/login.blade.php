@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        <h2>Login</h2>
        
        <form method="POST" action="">
            @csrf
            
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com" required autocomplete="email" autofocus>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password" placeholder="例: coachtech123" required autocomplete="current-password">
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