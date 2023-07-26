<?php

namespace App\Http\Controllers;

use App\Member;
use App\Product_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
        $search->where('deleted_at', null);

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

    public function showCategoryList(Request $request)
    {
        $search = Product_category::query();
        $search->leftjoin('product_subcategories', 'product_categories.id', '=', 'product_subcategories.product_category_id')
        ->select('product_categories.id', 'product_categories.name', 'product_categories.created_at', 'product_subcategories.name as sub_name')    
        ->where('product_categories.deleted_at', null);

        if ($request->id != '') {

            $id = $request->id;
            $search->where('product_subcategories.id', $id);
        }

        if ($request->free_word != '') {
            $free_word = $request->free_word;
            $search->where(function ($search) use ($free_word) {
                $search->where('product_categories.name', 'like', '%' . $free_word . '%')
                    ->orwhere('product_subcategories.name', 'like', '%' . $free_word . '%');
            });
        }

        if (!empty($request->sort) && !empty($request->direction)) {
            $sort = $request->sort;
            $direction = $request->direction;
            $search->orderBy($sort, $direction);
        } else {
            $search->orderBy('id', 'desc');
        }

        $categories = $search->groupBy('product_categories.id')->paginate(10);

        return view('admin.category_list', ['categories' => $categories]);
    }

    public function memberEdit(Request $request)
    {
        $id = $request->id;

        $member = Member::where(['id' => $id, 'deleted_at' => null])->first();

        return view('admin.edit', ['member' => $member]);
    }

    public function memberDetail(Request $request)
    {
        $id = $request->id;

        $member = Member::where(['id' => $id, 'deleted_at' => null])->first();

        return view('admin.detail', ['member' => $member]);
    }

    public function toMemberConfirm(Request $request)
    {
        dd($request->from);
        $inputs = $request->all();
        if ($request->from == 'regist') {
            $this->registValidator($request->only('name_sei', 'name_mei', 'nickname', 'gender', 'password', 'password_confirmation', 'email'))->validate();
        } else {
            $this->editValidator($request->only('id', 'name_sei', 'name_mei', 'nickname', 'gender', 'password', 'password_confirmation', 'email'))->validate();
        }

        return view('admin.confirm', ['inputs' => $inputs]);
    }

    public function memberComplete(Request $request)
    {
        $form = $request->from;

        // 二重送信防止
        $request->session()->regenerateToken();

        // パスワードのハッシュ化
        if ($request->password != null) {
            $hash_password = bcrypt($request->password);
        }

        // DBに登録・更新
        if ($request->from == 'regist') {
            Member::create([
                'name_sei' => $request->name_sei,
                'name_mei' => $request->name_mei,
                'nickname' => $request->nickname,
                'gender' => $request->gender,
                'password' => $hash_password,
                'email' => $request->email
            ]);
        } else {
            if (!empty($hash_password)) {
                Member::where('id', $request->id)
                    ->update([
                        'name_sei' => $request->name_sei,
                        'name_mei' => $request->name_mei,
                        'nickname' => $request->nickname,
                        'gender' => $request->gender,
                        'password' => $hash_password,
                        'email' => $request->email
                    ]);
            } else {
                Member::where('id', $request->id)
                    ->update([
                        'name_sei' => $request->name_sei,
                        'name_mei' => $request->name_mei,
                        'nickname' => $request->nickname,
                        'gender' => $request->gender,
                        'email' => $request->email
                    ]);
            }
        }

        return redirect()->route('admin.list');
    }

    public function memberDetailDelete(Request $request)
    {
        $id = $request->id;

        Member::where('id', $id)->update(['deleted_at' => now()]);

        return redirect()->route('admin.list');
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

    protected function registValidator(array $data)
    {
        return Validator::make($data, [
            'name_sei' => 'required|max:20',
            'name_mei' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|in:1,2',
            'password' => 'required|min:8|max:20|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'password_confirmation' => 'required|min:8|max:20|regex:/^[a-zA-Z0-9]+$/',
            'email' => 'required|max:200|email|unique:members,email',
        ]);
    }

    protected function editValidator(array $data)
    {
        return Validator::make($data, [
            'name_sei' => 'required|max:20',
            'name_mei' => 'required|max:20',
            'nickname' => 'required|max:10',
            'gender' => 'required|in:1,2',
            'password' => 'nullable|min:8|max:20|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'password_confirmation' => 'nullable|min:8|max:20|regex:/^[a-zA-Z0-9]+$/',
            'email' => 'required|max:200|email|unique:members,email,' . $data['id'] . ',id',
        ]);
    }
}
