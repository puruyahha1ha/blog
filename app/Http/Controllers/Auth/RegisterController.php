<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Member;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'gender' => ['required', 'in:1,2'],
            'password' => ['required', 'string', 'min:8', 'max:20', 'regex:/^[a-zA-Z0-9]+$/', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:20', 'regex:/^[a-zA-Z0-9]+$/'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:members,email'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Member
     */
    protected function create(array $data)
    {
        return Member::create([
            'name_sei' => $data['name_sei'],
            'name_mei' => $data['name_mei'],
            'nickname' => $data['nickname'],
            'gender' => $data['gender'],
            'password' => bcrypt($data['password']),
            'email' => $data['email']
        ]);
    }

    public function toConfirmForm(Request $request)
    {
        $inputs = $request->all();

        $this->validator($request->all())->validate();

        return view('auth.register_confirm', ['inputs'=> $inputs]);
    }

    public function showRegistCompleteForm()
    {
        return view('auth.register_complete');
    }
}
