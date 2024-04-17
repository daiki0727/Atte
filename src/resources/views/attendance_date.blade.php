@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance_date.css') }}">
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
    <div class="date-form">
        <div class="date-form__inner">
            <form class="date-form__form" action="{{ route('attendance.date') }}" method="get">
                @csrf
                <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">
                <button class="yesterday" type="submit" name="previous_date"
                    value="{{ $date->copy()->subDay()->format('Y-m-d') }}"><</button>
                        <span class="today">{{ $date->format('Y/m/d') }}</span>
                        <button class="tomorrow" type="submit" name="next_date"
                            value="{{ $date->copy()->addDay()->format('Y-m-d') }}">></button>
            </form>
        </div>

        <table class="user__table">
            <tr class="user__row">
                <th class="user__label">名前</th>
                <th class="user__label">勤務開始</th>
                <th class="user__label">勤務終了</th>
                <th class="user__label">休憩時間</th>
                <th class="user__label">勤務時間</th>
            </tr>
            @foreach ($users as $user)
                <tr class="user__row">
                    <td class="user__data">{{ $user->name }}</td>
                    @if ($user->works->isNotEmpty())
                        <td class="user__data">{{ $user->works->first()->work_start }}</td>
                        <td class="user__data">{{ $user->works->first()->work_end }}</td>
                        <td class="user__data">{{ $user->restTime }}</td>
                        <td class="user__data">
                            {{ gmdate('H:i:s', strtotime($user->workTime) - strtotime($user->restTime)) }}
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
        <div>
            {{ $users->links('vendor.pagination.attendance') }}
        </div>
    </div>
@endsection