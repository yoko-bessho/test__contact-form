@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>Confirm</h2>
    <form action="/contacts" method="post">
    @csrf
    @foreach ($contact as $key => $value)
        @if ($key === 'category')
            <input type="hidden" name="category_id" value="{{ $value->id }}">
        @elseif ($key === 'gender')
            @php
                $genderMap = ['男性' => 1, '女性' => 2, 'その他' => 3];
            @endphp
            <input type="hidden" name="gender" value="{{ $genderMap[$value] }}">
        @else
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach
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
        <button type="button" class="back-btn">修正</button>
    </div>
    </form>
</div>
@endsection