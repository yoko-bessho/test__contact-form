@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')

<div class="container">
    <h2>Confirm</h2>
    <form action="/thanks" method="post">
    @csrf

    @foreach ($contact as $key => $value)
        @if ($key === 'category')
            <input type="hidden" name="category_id" value="{{ $value->id }}">
        @else
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach
    <input type="hidden" name="tel1" value="{{ $contact['tel1'] ?? '' }}">
    <input type="hidden" name="tel2" value="{{ $contact['tel2'] ?? '' }}">
    <input type="hidden" name="tel3" value="{{ $contact['tel3'] ?? '' }}">

    <div class="confirm-table">
        <table>
            <tr>
                <th>お名前</th>
                <td>{{ $contact['last_name'] }} {{ $contact['first_name'] }}
                </td>
            </tr>
            <tr>
                <th>性別</th>
                <td>{{ $contact['gender'] }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td> {{ $contact['email'] }}</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>{{ $contact['tel'] }}</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>{{ $contact['address'] }}</td>
            </tr>
            <tr>
                <th>建物名</th>
                <td>{{ $contact['building'] }}</td>
            </tr>
            <tr>
                <th>お問い合わせの種類</th>
                <td>{{ $contact['category']->content }}</td>
            </tr>
            <tr>
                <th>お問い合わせ内容</th>
                <td>{{ $contact['detail'] }}</td>
            </tr>
        </table>
    </div>
    <div class="form-buttons">
        <button type="submit" class="submit-btn">送信</button>
        <button type="button" onclick="history.back()" class="back-btn">修正</button>
    </div>
    </form>
</div>
@endsection