<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.admin_main');
    }
    public function showAdminLoginForm()
    {
        return view('admin.login');
    }


    public function showList(Request $request)
    {
        $search = Member::query();

        if ($request->id != '') {

            $id = $request->id;
            $search->where('id', $id);
        }

        if (!empty($request->man) && !empty($request->woman)) {

            $man = $request->man;
            $woman = $request->woman;
            $search->where(function ($search) use ($man, $woman) {
                $search->where('gender', $man)->orWhere('gender', $woman);
            });
        } elseif (!empty($request->man) && empty($request->woman)) {
            $man = $request->man;
            $search->where('gender', $man);
        } elseif (empty($request->man) && !empty($request->woman)) {

            $woman = $request->woman;
            $search->where('gender', $woman);
        }

        if ($request->free_word != '') {
            $free_word = $request->free_word;
            $search->where(function ($search) use ($free_word) {
                $search->where('name_sei', 'like', '%' . $free_word . '%')
                    ->orwhere('name_mei', 'like', '%' . $free_word . '%')
                    ->orwhere('email', 'like', '%' . $free_word . '%');
            });
        }

        if (!empty($request->sort) && !empty($request->direction)) {
            $sort = $request->sort;
            $direction = $request->direction;
            $search->orderBy($sort, $direction);
        } else {
            $search->orderBy('id', 'desc');
        }

        $members = $search->paginate(10);

        return view('admin.list', ['members' => $members]);
    }

    public function memberEdit(Request $request)
    {
        $id = $request->id;

        $member = Member::where('id', $id)->first();

        return view('admin.edit');
    }


    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'login_id' => 'required|min:7|max:10|regex:/^[a-zA-Z0-9]+$/',
            'password' => 'required|min:8|max:20|regex:/^[a-zA-Z0-9]+$/',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->intended('admin');
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request)
    {
        return Auth::guard('admin')->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'login_id' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
