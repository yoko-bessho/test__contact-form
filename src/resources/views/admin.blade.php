@extends('layouts.admin-app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header-nav')
@if (Auth::check())
<form action="/logout" method="post">
    @csrf
    <button class="header-nav__button">
        logout
    </button>
</form>
@endif
@endsection

@section('content')
<div class="container">
    <h2>Admin</h2>
    <div class="search-form">
        <form action="/search" method="GET">
        @csrf
            <div class="search-row">
                <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">
                <div class="select-wrapper">
                    <select name="gender">
                        <option disabled selected>性別</option>
                        <option value="1" @if( request('gender')==1 ) selected @endif>男性</option>
                        <option value="2" @if( request('gender')==2 ) selected @endif>女性</option>
                        <option value="3" @if( request('gender')==3 ) selected @endif>その他</option>
                    </select>
                </div>
                <div class="select-wrapper">
                    <select name="category_id">
                        <option disabled selected>お問い合わせの種類</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if( request('category_id')==$category->id ) selected @endif>{{ $category->content }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="date-wrapper">
                    <input class="serch-form__date" type="date" name="date" value="{{request('date')}}"  >
                </div>
                <div class="button-wrapper">
                    <button type="submit" class="search-btn">検索</button>
                    <input class="reset-btn" type="submit" value="リセット" name="reset">
                </div>
            </div>
        </form>
    </div>

    <div class="export-form">
        <form action="{{ '/export?
        ' .http_build_query(request()->query()) }}" method="post">
            @csrf
            <input class="export__btn btn" type="submit" value="エクスポート">
        </form>
        {{ $contacts->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>



    <div class="contacts-table">
        <table>
            <thead class="contact-table__header">
                <tr>
                    <th class="header-name">お名前</th>
                    <th class="header-gender">性別</th>
                    <th class="header-mail">メールアドレス</th>
                    <th class="header-detail">お問い合わせの種類</th>
                    <th class="header-modal"></th>
                </tr>
            </thead>
            @foreach($contacts as $contact)
            <tbody>
                <tr>
                    <td>{{  $contact->first_name }} {{ $contact->last_name  }}</td>
                    <td>{{ $contact->getGenderLabelAttribute() }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->category->content }}</td>
                    <td><a href="#{{ $contact->id }}" class="modal-open">詳細</a></td>
                </tr>
                <div class="modal" id="{{ $contact->id }}">
                <a href="#!" class="modal-overlay"></a>
                <div class="modal__inner">
                    <div class="modal__content">
                        <form class="modal__delete-form" action="/delete" method="post">
                            @method('DELETE')
                            @csrf
                            <div class="modal-form__group">
                                <label class="modal-form__label">お名前</label>
                                <p>{{ $contact->first_name }} {{ $contact->last_name }}</p>
                            </div>
                            <div class="modal-form__group">
                                <label class="modal-form__label">性別</label>
                                <p>{{ $contact->getGenderLabelAttribute() }}</p>
                            </div>
                            <div class="modal-form__group">
                                <label class="modal-form__label">メールアドレス</label>
                                <p>{{ $contact->email }}</p>
                            </div>
                            <div class="modal-form__group">
                                <label class="modal-form__label">電話番号</label>
                                <p>{{ $contact->tell }}</p>
                            </div>
                            <div class="modal-form__group">
                                <label class="modal-form__label">住所</label>
                                <p>{{ $contact->address }}</p>
                            </div>
                            <div class="modal-form__group">
                                <label class="modal-form__label">お問い合わせの種類</label>
                                <p>{{ $contact->category->content }}</p>
                                
                            </div>
                            <div class="modal-form__group">
                                <label class="modal-form__label">お問い合わせの内容</label>
                                <p>{{ $contact->detail }}</p>
                            </div>
                            <input type="hidden" name="id" value="{{ $contact->id }}">
                            <input class="modal-form__delete-btn btn" type="submit" value="削除">

                        </form>
                    </div>
                    <a href="#" class="modal__close-btn">✖️</a>
                </div>
                </div>
            </tbody>
            @endforeach
        </table>
    </div>
</div>
@endsection
