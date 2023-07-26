<?php

namespace App\Http\Controllers;

use App\Member;
use App\Product_category;
use App\Product_subcategory;
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
            $search->where('product_categories.id', $id);
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

    public function categoryEdit(Request $request)
    {
        $id = $request->id;

        $product_category = Product_category::where(['id' => $id, 'deleted_at' => null])->first();
        $product_subcategory = Product_subcategory::where(['product_category_id' => $id, 'deleted_at' => null])->get()->all();

        return view('admin.category_edit', ['product_category' => $product_category, 'product_subcategory' => $product_subcategory]);
    }

    public function categoryDetail(Request $request)
    {
        $id = $request->id;

        $product_category = Product_category::where(['id' => $id, 'deleted_at' => null])->first();

        return view('admin.category_detail', ['product_category' => $product_category]);
    }

    public function toCategoryConfirm(Request $request)
    {
        $inputs = $request->all();

        $this->categoryValidator($request->only('name', 'sub_name1', 'sub_name2', 'sub_name3', 'sub_name4', 'sub_name5', 'sub_name6', 'sub_name7', 'sub_name8', 'sub_name9', 'sub_name10'))->validate();

        return view('admin.category_confirm', ['inputs' => $inputs]);
    }

    public function categoryComplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();

        // DBに登録・更新
        if ($request->from == 'regist') {

            Product_category::create([
                'name' => $request->name
            ]);

            $main_category_id = Product_category::select('id')->where('name', $request->name)->first();

            for ($i = 1; $i <= 10; $i++) {
                $name = "sub_name$i";
                if (!empty($request->$name)) {
                    Product_subcategory::create([
                        'product_category_id' => $main_category_id->id,
                        'name' => $request->$name,
                    ]);
                }
            }
            
        } else {

            $main_category_id = Product_category::select('id')->where('name', $request->name)->first();

            Product_subcategory::query()->delete('product_category_id', $request->id);

            for ($i = 1; $i <= 10; $i++) {
                $name = "sub_name$i";
                if (!empty($request->$name)) {
                    Product_subcategory::create([
                        'product_category_id' => $main_category_id->id,
                        'name' => $request->$name,
                    ]);
                }
            }
        }

        return redirect()->route('admin.category_list');
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

    protected function categoryValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:20',
            'sub_name1' => 'required|max:20',
            'sub_name2' => 'max:20',
            'sub_name3' => 'max:20',
            'sub_name4' => 'max:20',
            'sub_name5' => 'max:20',
            'sub_name6' => 'max:20',
            'sub_name7' => 'max:20',
            'sub_name8' => 'max:20',
            'sub_name9' => 'max:20',
            'sub_name10' => 'max:20',
        ]);
    }
}
