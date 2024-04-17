@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
    <div class="login-form">
        <h2 class="login-form__heading">ログイン</h2>
        <div class="login-form__inner">
            <form class="login-form__form" action="{{ route('login') }}" method="post">
                @csrf
                <div class="login-form__group">
                    <input class="login-form__input" type="email" name="email" id="email" placeholder="メールアドレス">
                    <p class="error-message">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="login-form__group">
                    <input class="login-form__input" type="password" name="password" id="password" placeholder="パスワード">
                    <p class="error-message">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="login-form__group">
                    <input class="login-form__btn" type="submit" value="ログイン">
                </div>
            </form>
        </div>
        <span class="message">アカウントをお持ちでない方はこちらから</span>
        <div class="register__btn">
            <a class="register" href="{{ route('register') }}">会員登録</a>
        </div>
    </div>
@endsection
