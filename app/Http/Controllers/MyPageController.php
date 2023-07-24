<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MyPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toMyPage()
    {
        return view('mypages.mypage');
    }

    public function toWithdrawal()
    {
        return view('mypages.withdrawal');
    }

    public function completeWithdrawal(Request $request)
    {
        DB::table('members')->where('id', Auth::user()->id)->update(['deleted_at' => now()]);

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    public function toInfoUpdate()
    {
        return view('mypages.info_update');
    }

    public function toPasswordUpdate()
    {
        return view('mypages.pass_update');
    }

    public function toEmailUpdate()
    {
        return view('mypages.emial_update');
    }

    public function toInfoUpdateConfirm(Request $request)
    {

        $inputs = $request->all();

        $this->validator($request->only('name_sei', 'name_mei', 'nickname', 'gender'))->validate();

        return view('mypages.info_confirm', ['inputs' => $inputs]);
    }

    public function infoUpdateComplete(Request $request)
    {
        // 更新処理
        Member::where('id', Auth::user()->id)
            ->update(['name_sei' => $request->name_sei, 'name_mei' => $request->name_mei, 'nickname' => $request->nickname, 'gender' => $request->gender]);

        return redirect()->route('mypage');
    }

    public function passwordUpdateComplete(Request $request)
    {
        // パスワード更新処理
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name_sei' => ['required', 'string', 'max:20'],
            'name_mei' => ['required', 'string', 'max:20'],
            'nickname' => ['required', 'string', 'max:10'],
            'gender' => ['required', 'integer', 'in:1,2'],
        ]);
    }
}
