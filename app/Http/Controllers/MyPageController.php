<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function toMyPage() {
        return view('mypages.mypage');
    }
}
