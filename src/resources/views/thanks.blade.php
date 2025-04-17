@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks-container">
    <div class="thanks-content">
        <h2>お問い合わせありがとうございました</h2>
        <a href="/" class="home-btn">HOME</a>
    </div>
</div>
@endsection