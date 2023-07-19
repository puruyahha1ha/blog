<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'product_category_id' => ['required', 'integer', 'in:1,2,3,4,5'],
            'product_subcategory_id' => ['required', 'integer', 'in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25'],
            'product_content' => ['required', 'string', 'max:500'],
        ]);
    }

    /**
     * 商品登録フォーム
     *
     * @return void
     */
    public function showRegistProductForm()
    {
        $product_categories = DB::table('product_categories')->orderBy('id')->get();
        return view('products.product_regist', ['product_categories' => $product_categories]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function fetch(Request $request)
    {
        $product_category_id = $request['product_category_id'];
        $product_subcategories = DB::table('product_subcategories')->where('product_category_id', $product_category_id)->get();
        return $product_subcategories;
    }

    public function upload(Request $request)
    {
        $file_name = $request->file('upload')->getClientOriginalName();
        $path = $request->file('upload')->storeAs('public', $file_name);
        return response()->json([
            'file_name' => $file_name
        ]);
    }

    public function toConfirmForm(Request $request)
    {
        $inputs = $request->all();

        $this->validator($request->only('name', 'product_category_id', 'product_subcategory_id', 'product_content'))->validate();

        $category_name = DB::table('product_categories')->select('name')->where('id', $inputs['product_category_id'])->get()->toArray();

        $subcategory_name = DB::table('product_subcategories')->select('name')->where('id', $inputs['product_subcategory_id'])->get()->toArray();

        return view('products.product_confirm', ['inputs' => $inputs, 'category_name' => $category_name, 'subcategory_name' => $subcategory_name]);
    }

    public function complete(Request $request)
    {
        $inputs = $request->all();

        if (!empty($inputs['back'])) {
            return redirect()->route('product')->withInput();
        }

        // DBに登録
        $product = new Product();
        $product->member_id = Auth::id();
        $product->product_category_id = $inputs['product_category_id'];
        $product->product_subcategory_id = $inputs['product_subcategory_id'];
        $product->name = $inputs['name'];
        for ($i = 1; $i <= 4; $i++) {
            $culum_name = "image_$i";
            if (!empty($inputs["image_$i"])) {
                $product->$culum_name = $inputs["image_$i"];
            }
        }
        $product->product_content = $inputs['product_content'];
        $product->save();

        // 二重送信防止
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
