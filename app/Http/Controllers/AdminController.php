<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index() {
        return view('admin.admin_main');
    }
    public function showAdminLoginForm()
    {
        return view('admin.login');
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

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login_id' => 'required|min:7|max:10',
            'password' => 'required|min:8|max:20',
        ]);
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
