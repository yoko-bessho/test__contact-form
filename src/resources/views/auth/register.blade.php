@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-container">
    <div class="register-card">
        <h2>Register</h2>
        
        <form method="POST" action="">
            @csrf
            
            <div class="form-group">
                <label for="name">お名前</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="例: 山田 太郎" required autocomplete="name" autofocus>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com" required autocomplete="email">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password" placeholder="例: coachtech123" required autocomplete="new-password">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-button">
                <button type="submit" class="register-btn">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection