@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>Admin</h2>
    
    <div class="search-form">
        <form action="{{--{{ route('admin.contacts.index') }}--}}" method="GET">
            <div class="search-row">
                <input type="text" name="name_email" placeholder="名前やメールアドレスを入力してください" value="{{--{{ request('name_email') }}--}}">
                
                <div class="select-wrapper">
                    <select name="gender">
                        <option value="">性別</option>
                        <option value="男性" {{--{{ request('gender') == '男性' ? 'selected' : '' }}--}}>男性</option>
                        <option value="女性" {{--{{ request('gender') == '女性' ? 'selected' : '' }}--}}>女性</option>
                        <option value="その他" {{--{{ request('gender') == 'その他' ? 'selected' : '' }}--}}>その他</option>
                    </select>
                </div>
                
                <div class="select-wrapper">
                    <select name="inquiry_type">
                        <option value="">お問い合わせの種類</option>
                        <option value="商品の交換について" {{--{{ request('inquiry_type') == '商品の交換について' ? 'selected' : '' }}--}}>商品の交換について</option>
                        <option value="商品の返品について" {{--{{ request('inquiry_type') == '商品の返品について' ? 'selected' : '' }}--}}>商品の返品について</option>
                        <option value="商品について" {{--{{ request('inquiry_type') == '商品について' ? 'selected' : '' }}--}}>商品について</option>
                        <option value="その他" {{--{{ request('inquiry_type') == 'その他' ? 'selected' : '' }}--}}>その他</option>
                    </select>
                </div>
                
                <div class="date-wrapper">
                    <select name="date">
                        <option value="">年/月/日</option>
                        <!-- 日付オプションはJavaScriptで動的に生成するか、Bladeで生成 -->
                    </select>
                </div>
                <div class="button-wrapper">
                    <button type="submit" class="search-btn">検索</button>
                    <button type="button" class="reset-btn" onclick="">リセット</button>
                </div>
            </div>
        </form>
    </div>

    <div class="search-form__utility">
        <div class="export-section">
            <a href="{{--{{ route('admin.contacts.export') }}--}}" class="export-btn">エクスポート</a>
        </div>
        <div class="pagination-top">
            <div class="pagination">
                <a href="#" class="prev">&lt;</a>
                <a href="#" class="page active">1</a>
                <a href="#" class="page">2</a>
                <a href="#" class="page">3</a>
                <a href="#" class="page">4</a>
                <a href="#" class="page">5</a>
                <a href="#" class="next">&gt;</a>
            </div>
        </div>
    </div>

    <div class="contacts-table">
        <table>
            <thead>
                <tr>
                    <th>お名前</th>
                    <th>性別</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせの種類</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <!-- <tr>
                    <td>{{--{{ $contact->name }}--}}</td>
                    <td>{{--{{ $contact->gender }}--}}</td>
                    <td>{{--{{ $contact->email }}--}}</td>
                    <td>{{--{{ $contact->inquiry_type }}--}}</td>
                    <td><a href="{{--{{ route('admin.contacts.show', $contact) }}--}}" class="detail-btn">詳細</a></td>
                </tr> -->

            </tbody>
        </table>
    </div>
</div>
@endsection