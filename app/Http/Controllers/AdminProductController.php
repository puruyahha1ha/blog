<?php

namespace App\Http\Controllers;

use App\Member;
use App\Product;
use App\Product_category;
use App\Product_subcategory;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AdminProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function showProductList(Request $request)
    {
        $search = Product::query();
        $search->where('deleted_at', null);

        if ($request->id != '') {

            $id = $request->id;
            $search->where('id', $id);
        }

        if ($request->free_word != '') {
            $free_word = $request->free_word;
            $search->where(function ($search) use ($free_word) {
                $search->where('name', 'like', '%' . $free_word . '%')
                    ->orwhere('product_content', 'like', '%' . $free_word . '%');
            });
        }

        if (!empty($request->sort) && !empty($request->direction)) {
            $sort = $request->sort;
            $direction = $request->direction;
            $search->orderBy($sort, $direction);
        } else {
            $search->orderBy('id', 'desc');
        }

        $products = $search->paginate(10);

        return view('admin.product.list', ['products' => $products]);
    }

    public function productEdit(Request $request)
    {
        $id = $request->id;
        $product = Product::query()
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_subcategories', 'products.product_subcategory_id', '=', 'product_subcategories.id')
            ->select('products.*', 'product_categories.name as main_name', 'product_subcategories.name as sun_name')
            ->where('products.id', $id)
            ->first();

        $members = Member::query()->where('deleted_at', null)->get();
        $product_categories = Product_category::query()->where('deleted_at', null)->get();
        $product_subcategories = Product_subcategory::query()->where('deleted_at', null)->get();

        // dd(!empty($product));
        return view('admin.product.edit', ['product' => $product, 'members' => $members, 'product_categories' => $product_categories, 'product_subcategories' => $product_subcategories]);
    }

    public function toProductConfirm(Request $request)
    {
        $this->validator($request->only('member_id', 'name', 'product_category_id', 'product_subcategory_id', 'product_content'))->validate();

        $inputs = $request->all();
        $member_name = Member::query()->where('id', $inputs['member_id'])->first();
        $product_category_name = Product_category::query()->where('id', $inputs['product_category_id'])->first();
        $product_subcategory_name = Product_subcategory::query()->where('id', $inputs['product_subcategory_id'])->first();

        return view('admin.product.confirm', ['inputs' => $inputs, 'member_name' => $member_name, 'product_category_name' => $product_category_name, 'product_subcategory_name' => $product_subcategory_name]);
    }

    public function productComplete(Request $request)
    {

        // 二重送信防止
        $request->session()->regenerateToken();

        if ($request->from == 'regist') {
            Product::create([
                'member_id' => $request->member_id,
                'product_category_id' => $request->product_category_id,
                'product_subcategory_id' => $request->product_subcategory_id,
                'name' => $request->name,
                'image_1' => $request->image_1,
                'image_2' => $request->image_2,
                'image_3' => $request->image_3,
                'image_4' => $request->image_4,
                'product_content' => $request->product_content,
            ]);
        } else {
            Product::where('id', $request->id)->update([
                'member_id' => $request->member_id,
                'product_category_id' => $request->product_category_id,
                'product_subcategory_id' => $request->product_subcategory_id,
                'name' => $request->name,
                'image_1' => $request->image_1,
                'image_2' => $request->image_2,
                'image_3' => $request->image_3,
                'image_4' => $request->image_4,
                'product_content' => $request->product_content,
            ]);
        }

        return redirect()->route('admin.product.list');
    }

    public function toProductDetail(Request $request)
    {
        $id = $request->id;

        $product = Product::query()
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_subcategories', 'products.product_subcategory_id', '=', 'product_subcategories.id')
            ->join('members', 'products.member_id', '=', 'members.id')
            ->select('products.*', 'product_categories.name as main_name', 'product_subcategories.name as sub_name', 'members.name_mei')
            ->where('products.id', $id)
            ->first();

        $average = Review::query()->where('product_id', $id)->avg('evaluation');

        $reviews = Review::query()->leftjoin('members', 'reviews.member_id', '=', 'members.id')->select('reviews.*', 'members.name_sei', 'members.name_mei')->where('product_id', $id)->orderBy('id', 'asc')->paginate(3);

        return view('admin.product.detail', ['product' => $product, 'average' => $average, 'reviews' => $reviews]);
    }

    public function productDetailDelete(Request $request)
    {
        $id = $request->id;

        Product::query()->where('id', $id)->update(['deleted_at' => now()]);
        Review::query()->where('product_id', $id)->update(['deleted_at' => now()]);

        return redirect()->route('admin.product.list');
    }

    public function fetch(Request $request)
    {
        $product_category_id = $request['product_category_id'];
        $product_subcategories = Product_subcategory::query()->where('product_category_id', $product_category_id)->where('deleted_at', null)->get();
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'name' => ['required', 'string', 'max:100'],
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'product_subcategory_id' => ['required', 'integer', 'exists:product_subcategories,id'],
            'product_content' => ['required', 'string', 'max:500'],
        ]);
    }
}
