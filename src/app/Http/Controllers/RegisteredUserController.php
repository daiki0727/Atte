<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;


class RegisteredUserController extends Controller
{
    //新規ユーザー登録処理
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // メール認証のためにイベントを発行し、メールを送信
        event(new Registered($user));

        // 再送信機能を追加
        if ($request->has('resend')) {
            $user->sendEmailVerificationNotification();
        }

        // ビューにデータを渡す
        return view('auth.verify-email');
    }
}
