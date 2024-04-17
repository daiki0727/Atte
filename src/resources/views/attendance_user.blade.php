@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance_user.css') }}">
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
    <div class="search-form">
        <div class="search-form__inner">
            <form class="user-search" action="{{ route('attendance.user.search') }}" method="get">
                @csrf
                <input class="user-search__input" type="text" name="keyword" placeholder="名前を入力してください">
                <button class="user-search__btn">検索</button>
                <button class="reset-search__btn"type="submit" name="reset">元に戻す</button>
            </form>
        </div>

        <table class="user__table">
            <tr class="user__row">
                <th class="user__label">名前</th>
                <th class="user__label">メールアドレス</th>
                <th class="user__label">勤怠表</th>
            </tr>
            @foreach ($users as $user)
                <tr class="user__row">
                    <td class="user__data">{{ $user->name }}</td>
                    <td class="user__data">{{ $user->email }}</td>
                    <td class="user-detail__data">
                        <a class="user-detail" href="{{ route('user.detail', ['id' => $user->id]) }}">詳細</a>
                    </td>
                </tr>
            @endforeach
        </table>

        <div>
            {{ $users->appends(request()->query())->links('vendor.pagination.attendance') }}
        </div>
    </div>
@endsection
