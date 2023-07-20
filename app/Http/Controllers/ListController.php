<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function toList()
    {
        $product_categories = DB::table('product_categories')->orderBy('id')->get();

        $products = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_subcategories', 'products.product_subcategory_id', '=', 'product_subcategories.id')
            ->select('products.*', 'product_categories.name as main_name', 'product_subcategories.name as sub_name')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('list.list', ['product_categories' => $product_categories, 'products' => $products]);
    }

    public function search(Request $request)
    {

        $product_categories = DB::table('product_categories')->orderBy('id')->get();

        $inputs = $request->all();
        if (!empty($inputs['product_category_id'])) {
            $product_category_id = $inputs['product_category_id'];
        }
        if (!empty($inputs['product_subcategory_id'])) {
            $product_subcategory_id = $inputs['product_subcategory_id'];
        }
        $free_word = $inputs['free_word'];

        $query = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_subcategories', 'products.product_subcategory_id', '=', 'product_subcategories.id')
            ->select('products.*', 'product_categories.name as main_name', 'product_subcategories.name as sub_name');

        if (!empty($product_category_id)) {
            $query->where('products.product_category_id', '=', $product_category_id);
        }
        if (!empty($product_subcategory_id)) {
            $query->where('products.product_subcategory_id', '=', $product_subcategory_id);
        }
        if (!empty($free_word)) {
            $query->where(function ($query) use ($free_word) {
                $query->where('products.name', 'like', '%' . $free_word . '%')
                    ->orwhere('products.product_content', 'like', '%' . $free_word . '%');
            });
        }

        $products = $query->orderBy('id', 'desc')
            ->paginate(10);

        return view('list.list', ['product_categories' => $product_categories, 'products' => $products]);
    }

    public function toDetail() {
        return view('list.detail');
    }
}
