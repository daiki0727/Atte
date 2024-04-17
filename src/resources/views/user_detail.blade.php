@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user_detail.css') }}">
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
    <div class="user-detail__group">
        <div class="user-detail__inner">
            <a class="back__btn" href="{{ route('attendance.user') }}">戻る</a>
            <span class="user-name">{{ $user->name }}さんの勤怠表</span>
            <div>{{ $works->links() }}</div>
        </div>
        <table class="user__table">
            <tr class="user__row">
                <th class="user__label">日付</th>
                <th class="user__label">勤務開始</th>
                <th class="user__label">勤務終了</th>
                <th class="user__label">休憩時間</th>
                <th class="user__label">勤務時間</th>
            </tr>
            @foreach ($works->sortBy('date') as $work)
                {{-- sortByを使用し日付を順番に表示 --}}
                <tr class="user__row">
                    <td class="user__data">{{ $work->date }}</td>
                    <td class="user__data">{{ $work->work_start }}</td>
                    <td class="user__data">{{ $work->work_end }}</td>
                    <td class="user__data">{{ $work->restTime }}</td>
                    <td class="user__data">{{ $work->workTime }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
