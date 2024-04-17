@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
    <div class="register-form">
        <h2 class="register-form__heading">会員登録</h2>
        <div class="register-form__inner">
            <form class="register-form__form" action="/register" method="post">
                @csrf
                <div class="register-form__group">
                    <input class="register-form__input" type="text" name="name" id="name" placeholder="名前"
                        value="{{ old('name') }}">
                    <p class="error-message">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="register-form__group">
                    <input class="register-form__input" type="email" name="email" id="email" placeholder="メールアドレス"
                        value="{{ old('email') }}">
                    <p class="error-message">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="register-form__group">
                    <input class="register-form__input" type="password" name="password" id="password" placeholder="パスワード">
                    <p class="error-message">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="register-form__group">
                    <input class="register-form__input" type="password" name="password_confirmation"
                        id="password_confirmation" placeholder="確認用パスワード">
                    <p class="error-message">
                    </p>
                </div>
                <div class="register-form__group">
                    <input class="register-form__btn" type="submit" value="会員登録">
                </div>
            </form>
        </div>
        <span class="message">アカウントをお持ちの方はこちらから</span>
        <div class="login__btn">
            <a class="login" href="{{ route('login') }}">ログイン</a>
        </div>
    </div>
@endsection
