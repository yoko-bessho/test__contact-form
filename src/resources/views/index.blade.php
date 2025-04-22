@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>Contact</h2>
    <form action="/confirm" method="POST" novalidate>
        @csrf

        <div class="form-group">
            <label for="last_name">お名前 <span class="required">※</span></label>
            <div class="name-inputs">
                <input
                type="text"
                id="last_name"
                name="last_name"
                placeholder="例: 山田"
                value="{{ old('last_name') }}">
                <input
                type="text"
                id="first_name"
                name="first_name"
                placeholder="例: 太郎"
                value="{{  old('first_name') }}">
            </div>
            @error('last_name')
                <span class="error-message">{{ $message }}</span>
            @enderror
            @error('first_name')
                <span class="error-message">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">
            <label>性別 <span class="required">※</span></label>
            <div class="radio-group">
                <label for="gender_male" class="radio-label">
                    <input
                    type="radio"
                    id="gender_male"
                    name="gender"
                    checked="checked"
                    value="男性"
                    {{ old('gender')  == '男性' ? 'checked' : '' }}>
                    <span class="radio-custom"></span>
                    男性
                </label>
                <label for="gender_female" class="radio-label">
                    <input
                    type="radio"
                    id="gender_female"
                    name="gender"
                    value="女性"
                    {{ old('gender') == '女性' ? 'checked' : ''}}>
                    <span class="radio-custom"></span>
                    女性
                </label>
                <label for="gender_other" class="radio-label">
                    <input
                    type="radio"
                    id="gender_other"
                    name="gender"
                    value="その他" {{ old('gender') == 'その他' ? 'checked' : ''}}>
                    <span class="radio-custom"></span>
                    その他
                </label>
            </div>
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
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="tel1">電話番号 <span class="required">※</span></label>
            <div class="phone-inputs">
                <input
                type="text"
                id="tel1"
                name="tel1"
                placeholder="例: 080"
                value="{{ old('tel1') }}">
                <span class="phone-separator">-</span>
                <input
                type="text"
                id="tel2"
                name="tel2"
                placeholder="例: 1234"
                value="{{ old('tel2') }}">
                <span class="phone-separator">-</span>
                <input
                type="text"
                id="tel3"
                name="tel3"
                placeholder="例: 5678"
                value="{{ old('tel3') }}">
            </div>
            @error('tel1')
                <span class="error-message">{{ $message }}</span>
            @enderror
            @error('tel2')
                <span class="error-message">{{ $message }}</span>
            @enderror
            @error('tel3')
                <span class="error-message">{{ $message }}</span>
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
            @error('building')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">お問い合わせの種類 <span class="required">※</span></label>
            <div class="select-wrapper">
                <select
                id="category_id"
                name="category_id">
                    <option value="" selected disabled>選択してください</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}" {{ old('category_id') == $category['id'] ? 'selected' : '' }}>
                        {{ $category['content'] }}</option>
                    @endforeach
                </select>
            </div>
            @error('category_id')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="detail">お問い合わせ内容 <span class="required">※</span></label>
            <textarea
            id="detail"
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