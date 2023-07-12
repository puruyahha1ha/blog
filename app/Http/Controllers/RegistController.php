<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\RegistMail;
use Illuminate\Support\Facades\Mail;
use App\Member;
class RegistController extends Controller
{
    //
    public function check(Request $request)
    {
        if ($request->confirm == 'トップに戻る') {
            return view('top', ['inputs', $request]);
        }

        $validate_rule = [
            'name_sei' => 'bail|required|max:20',
            'name_mei' => 'bail|required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'bail|in:1,2|required',
            'password_a' => 'bail|required|min:8|max:20|regex:/^[a-zA-Z0-9]+$/',
            'password_check' => 'bail|required|min:8|max:20|regex:/^[a-zA-Z0-9]+$/|same:password_a',
            'email' => 'required|max:200|email|unique:members,email',
        ];

        $this->validate($request, $validate_rule);
        $inputs = $request->all();

        return view('regist.confirm', ['inputs' => $inputs]);
    }

    public function regist(Request $request)
    {
        if ($request->confirm === '前に戻る') {
            $inputs = $request->all();
            return view('regist.member_regist')->withInput($inputs);
        }

        // 二重送信防止
        $request->session()->regenerateToken();

        // パスワードのハッシュ化
        $password = $request->password_a;

        $hash_password = bcrypt($password);

        // DBに登録
        $member = new Member();
        $member->name_sei = $request->name_sei;
        $member->name_mei = $request->name_mei;
        $member->nickname = $request->nickname;
        $member->gender = $request->gender;
        $member->password = $hash_password;
        $member->email = $request->email;
        $member->save();

        // 送信メール
        Mail::to($request->email)->send(new RegistMail([
            'name_sei' => $request->name_sei,
            'name_mei' => $request->name_mei,
            'nickname' => $request->nickname,
            'gender' => $request->gender,
            'email' => $request->email,
        ]));

        return view('regist.complete');
    }
}
