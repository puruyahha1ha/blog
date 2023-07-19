<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function toList()
    {
        $product_categories = DB::table('product_categories')->orderBy('id')->get();

        return view('list', ['product_categories' => $product_categories]);
    }
}
