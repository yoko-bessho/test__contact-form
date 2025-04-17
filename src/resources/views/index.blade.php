@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>Contact</h2>
    <form action="/contacts/confirm" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">お名前 <span class="required">※</span></label>
            <div class="name-inputs">
                <input
                type="text"
                id="name"
                name="first_name"
                placeholder="例: 山田"
                value="{{ old('first_name') }}">
                <input
                type="text"
                name="last_name"
                placeholder="例: 太郎">
            </div>
            @error('name')
                <span class="error-message">名前エラーメッセージ</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label>性別 <span class="required">※</span></label>
            <div class="radio-group">
                <label class="radio-label">
                    <input
                    type="radio"
                    name="gender"
                    value="男性"
                    checked="checked">
                    <span class="radio-custom"></span>
                    男性
                </label>
                <label class="radio-label">
                    <input
                    type="radio"
                    name="gender"
                    value="女性">
                    <span class="radio-custom"></span>
                    女性
                </label>
                <label class="radio-label">
                    <input
                    type="radio"
                    name="gender"
                    value="その他">
                    <span class="radio-custom"></span>
                    その他
                </label>
            </div>
            @error('gender')
                <span class="error-message">性別エラーメッセージ</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="email">メールアドレス <span class="required">※</span></label>
            <input
            type="email"
            id="email"
            name="email"
            placeholder="例: test@example.com"
            value="{{ old('email') }}">
            @error('email')
                <span class="error-message">メールエラーメッセージ</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="phone">電話番号 <span class="required">※</span></label>
            <div class="phone-inputs">
                <input
                type="text"
                id="tel"
                name="tel1"
                placeholder="例: 080"
                value="{{ old('tel1') }}">
                <span class="phone-separator">-</span>
                <input
                type="text"
                name="tel2"
                placeholder="例: 1234"
                value="{{ old('tel2') }}">
                <span class="phone-separator">-</span>
                <input
                type="text"
                name="tel3"
                placeholder="例: 5678"
                value="{{ old('tel3') }}">
            </div>
            @error('tel')
                <span class="error-message">phineエラーメッセージ</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="address">住所 <span class="required">※</span></label>
            <input
            type="text"
            id="address"
            name="address"
            placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3"
            value="{{ old('address') }}">
            @error('address')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="building">建物名</label>
            <input
            type="text"
            id="building"
            name="building"
            placeholder="例: 千駄ヶ谷マンション101"
            value="{{ old('building') }}">
        </div>
        
        <div class="form-group">
            <label for="content">お問い合わせの種類 <span class="required">※</span></label>
            <div class="select-wrapper">
                <select
                id="content"
                name="category_id">
                    <option value="" selected disabled>選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['content'] }}</option>
                    @endforeach

                </select>
            </div>
            @error('content')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="inquiry_content">お問い合わせ内容 <span class="required">※</span></label>
            <textarea
            id="inquiry_content"
            name="detail"
            placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
            @error('detail')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-button">
            <button type="submit" class="confirm-btn">確認画面</button>
        </div>
    </form>
</div>
@endsection