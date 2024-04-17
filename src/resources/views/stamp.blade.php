@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
@endsection

@section('link')
    <nav class="link-group">
        <a class="link-home" href="{{ route('stamp') }}">ホーム</a>
        <a class="link-index__attendance-date" href="{{ route('attendance.date') }}">日付一覧</a>
        <a class="link-index__attendance-user"href="{{ route('attendance.user') }}">ユーザー一覧</a>
        <form class="logout-form" action="/logout" method="post">
            @csrf
            <button class="link-index__logout">ログアウト</button>
        </form>
    </nav>
@endsection

@section('content')
    <div class="stamp-form">
        <span class="today">{{ $today }}</span>
        <span class="god-job__message">{{ $user->name }}さんお疲れ様です！</span>

        <div class="stamp-form__inner">
            <form class="stamp-form__form" action="{{ route('punch') }}" method="post">
                @csrf
                <div class="stamp-form__group">
                    <input class="stamp-form__input" type="submit" name="work_start" id="work_start" value="勤務開始"
                        {{ $buttonStatus['work_start'] ? '' : 'disabled' }}>
                </div>
                <div class="stamp-form__group">
                    <input class="stamp-form__input" type="submit" name="work_end" id="work_end" value="勤務終了"
                        {{ $buttonStatus['work_end'] ? '' : 'disabled' }}>
                </div>
                <div class="stamp-form__group">
                    <input class="stamp-form__input" type="submit" name="rest_start" id="rest_start" value="休憩開始"
                        {{ $buttonStatus['rest_start'] ? '' : 'disabled' }}>
                </div>
                <div class="stamp-form__group">
                    <input class="stamp-form__input" type="submit" name="rest_end" id="rest_end" value="休憩終了"
                        {{ $buttonStatus['rest_end'] ? '' : 'disabled' }}>
                </div>
            </form>
        </div>

    </div>
@endsection