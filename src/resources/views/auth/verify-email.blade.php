@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')
    <div class="verify-form">
        <h2 class="verify-form__heading">本人確認メールを送信しました！</h2>
        <div class="verify-form__inner">
            <span class="verify__message">確認用メールを送信しました。</span>
            <span class="verify__message">メールをご確認いただき、メールに記載されたボタンをクリックして登録を完了してください。</span>
            <span class="verify__message--resend">メールが届かない方は以下のボタンを再度クリックしてください。</span>
            <form class="verify-form" action="{{ route('verification.send') }}" method="post">
                @csrf
                <button class="resend-btn">メール再送信</button>
            </form>
            <div class="register__btn">
                <a class="register" href="{{ route('register') }}">会員登録画面へ戻る</a>
            </div>
        </div>
    </div>
@endsection
