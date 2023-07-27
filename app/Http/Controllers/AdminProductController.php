<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

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

        return view('admin.product.edit', ['product' => $product]);
    }

    public function toProductConfirm()
    {
    }

    public function productComplete()
    {
    }

    public function toProductDetail()
    {
    }

    public function productDetailDelete()
    {
    }
}
