<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class AttendanceController extends Controller
{
    //ホーム画面表示
    public function attend()
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i:s');

        $buttonStatus = [
            'work_start' => true,
            'work_end' => false,
            'rest_start' => false,
            'rest_end' => false,
        ];

        session()->put('buttonStatus', $buttonStatus);

        return view('stamp', compact('user', 'today', 'time', 'buttonStatus'));
    }

    //打刻機能
    public function punch(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');
        // セッションからボタンの状態を取得
        $buttonStatus = session('buttonStatus');

        // 勤務開始
        if ($request->has('work_start')) {
            $work = Work::where('user_id', $user->id)->where('date', $today)->first();
            if (!$work) {
                Work::create([
                    'user_id' => $user->id,
                    'date' => $today,
                    'work_start' => Carbon::now()->format('H:i:s'),
                    'work_started' => true,
                ]);
            }
            $buttonStatus['work_start'] = false;
            $buttonStatus['work_end'] = true;
            $buttonStatus['rest_start'] = true;
            $buttonStatus['rest_end'] = false;
            $request->session()->put('buttonStatus', $buttonStatus);
        }

        // 勤務終了
        if ($request->has('work_end')) {
            $work = Work::where('user_id', $user->id)->where('date', $today)->first();
            if ($work && !$work->work_end) {
                $work->update([
                    'work_end' => Carbon::now()->format('H:i:s'),
                ]);
            }
            $buttonStatus['work_start'] = false;
            $buttonStatus['work_end'] = false;
            $buttonStatus['rest_start'] = false;
            $buttonStatus['rest_end'] = false;
            $request->session()->put('buttonStatus', $buttonStatus);
        }

        // 休憩開始
        if ($request->has('rest_start')) {
            $work = Work::where('user_id', $user->id)->where('date', $today)->first();
            if ($work && $work->work_end === null) {
                $rest = Rest::where('work_id', $work->id)->latest()->first();
                if (!$rest || $rest->rest_end) {
                    Rest::create([
                        'work_id' => $work->id,
                        'rest_start' => Carbon::now()->format('H:i:s'),
                    ]);
                }
            }
            $buttonStatus['work_start'] = false;
            $buttonStatus['work_end'] = false;
            $buttonStatus['rest_start'] = false;
            $buttonStatus['rest_end'] = true;
            $request->session()->put('buttonStatus', $buttonStatus);
        }

        // 休憩終了
        if ($request->has('rest_end')) {
            $work = Work::where('user_id', $user->id)->where('date', $today)->first();
            if ($work) {
                $rest = Rest::where('work_id', $work->id)->latest()->first();
                if ($rest && $rest->rest_start !== null && !$rest->rest_end)
                    $rest->update([
                        'rest_end' => Carbon::now()->format('H:i:s'),
                    ]);
            }
            $buttonStatus['work_start'] = false;
            $buttonStatus['work_end'] = true;
            $buttonStatus['rest_start'] = true;
            $buttonStatus['rest_end'] = false;
            $request->session()->put('buttonStatus', $buttonStatus);
        }

        // stamp ビューにセッションに保存されている状態、今日の日付、ユーザー情報を渡して表示
        return view('stamp')->with(['buttonStatus' => $buttonStatus, 'today' => $today, 'user' => $user]);
    }

    // 日付一覧画面表示
    public function indexDate(Request $request)
    {
        // セッションから日付を取得するか、リクエストから取得するかを判定
        $date = $request->session()->get('date') ? Carbon::parse($request->session()->get('date')) : Carbon::today();

        // 前日の日付を取得
        if ($request->has('previous_date')) {
            $date = Carbon::parse($request->input('previous_date'));
        }

        // 翌日の日付を取得
        if ($request->has('next_date')) {
            $date = Carbon::parse($request->input('next_date'));
        }

        // 日付をセッションに保存
        $request->session()->put('date', $date);

        // 日付に紐づくユーザーの一覧を取得
        $users = User::whereHas('works', function ($query) use ($date) {
            $query->whereDate('date', $date);
        })->with(['works' => function ($query) use ($date) {
            $query->whereDate('date', $date);
        }, 'works.rests'])
        ->orderBy('id', 'asc')
        ->paginate(5);
        
        foreach ($users as $user) {
            if ($user->works->isNotEmpty()) {
                $work = $user->works->first();

                // 休憩時間を計算
                $restTime = DB::table('rests')
                    ->where('work_id', $work->id)
                    ->sum(DB::raw('TIME_TO_SEC(TIMEDIFF(rest_end, rest_start))'));

                // 勤務時間と休憩時間をフォーマットして保存
                $user->workTime = $work->work_end && $work->work_start ? gmdate('H:i:s', strtotime($work->work_end) - strtotime($work->work_start)) : '00:00:00';
                $user->restTime = gmdate('H:i:s', $restTime);
            } else {
                $user->workTime = '00:00:00';
                $user->restTime = '00:00:00';
            }
        }

        return view('attendance_date', compact('users', 'date'));
    }


    //ユーザー一覧ページの表示
    public function indexUser(Request $request)
    {
        $keyword = $request->session()->get('keyword');

        if ($keyword) {
            $users = User::where('name', 'like', "%$keyword%")->paginate(5);
        } else {
            $users = User::paginate(5);
        }

        return view('attendance_user', compact('users'));
    }

    //ユーザー検索機能
    public function search(Request $request)
    {
        if ($request->has('reset')) {
            $request->session()->forget('keyword'); // キーワードをセッションから削除
            return redirect()->route('attendance.user');
        }
        $keyword = $request->input('keyword');

        // 検索キーワードをセッションに保存
        $request->session()->put('keyword', $keyword);  

        $users = User::where('name', 'like', "%$keyword%")->paginate(5);

        return view('attendance_user', compact('users'));
    }

    //該当ユーザー情報の取得
    public function userDetail($id)
    {
        //ユーザー取得、見つからない場合はエラー発生
        $user = User::findOrFail($id);

        // ページネーションを適用したユーザーの勤怠情報取得
        $works = $user->works()->paginate(5);

        foreach ($works as $work) {
            $restTime = DB::table('rests')
                ->where('work_id', $work->id)
                ->sum(DB::raw('TIME_TO_SEC(TIMEDIFF(rest_end, rest_start))'));

            // 休憩時間の計算
            $work->restTime = gmdate('H:i:s', $restTime);

            // 勤務時間の計算を修正
            $work->workTime = $work->work_end && $work->work_start ? gmdate('H:i:s', strtotime($work->work_end) - strtotime($work->work_start) - $restTime) : '00:00:00';
        }

        return view('user_detail', compact('user', 'works'));
    }
}
