<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class ListController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'evaluation' => ['required', 'integer', 'in:1,2,3,4,5'],
            'comment' => ['required', 'string', 'max:500'],
        ]);
    }

    protected function searchProduct($id)
    {
        $product = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_subcategories', 'products.product_subcategory_id', '=', 'product_subcategories.id')
            ->select('products.*', 'product_categories.name as main_name', 'product_subcategories.name as sub_name')
            ->where('products.id', $id)
            ->first();

        return $product;
    }

    protected function searchReviews($id)
    {
        $reviews = DB::table('reviews')
            ->join('members', 'reviews.member_id', '=', 'members.id')
            ->select('reviews.*', 'members.nickname as member_name')
            ->where('reviews.product_id', $id)
            ->orderBy('reviews.id' ,'desc')
            ->paginate(5);

        return $reviews;
    }

    protected function avgEvaluation($id)
    {
        $avgEvaluation = DB::table('reviews')
        ->where('product_id', $id)
        ->avg('evaluation');

        return $avgEvaluation;
    } 

    public function toList()
    {
        $product_categories = DB::table('product_categories')->orderBy('id')->get();

        $products = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_subcategories', 'products.product_subcategory_id', '=', 'product_subcategories.id')
            ->select('products.*', 'product_categories.name as main_name', 'product_subcategories.name as sub_name')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $avg_evaluation = DB::table('reviews')->selectRaw('product_id, AVG(evaluation) as avg')->groupBy('product_id')->get()->all();
        $avgs = [];
        foreach ($avg_evaluation as $val) {
            $avgs["$val->product_id"] = ceil($val->avg);
        }

        return view('list.list', ['product_categories' => $product_categories, 'products' => $products, 'avgs' => $avgs]);
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

    public function toDetail(Request $request)
    {
        $id = $request->id;

        $product = $this->searchProduct($id);
        $avg_evaluation = $this->avgEvaluation($id);


        return view('list.detail', ['product' => $product, 'avg_evaluation' => $avg_evaluation]);
    }

    public function listBack()
    {
        return redirect()->route('list');
    }

    public function toRegister(Request $request)
    {
        $id = $request->id;

        $product = $this->searchProduct($id);
        $avg_evaluation = $this->avgEvaluation($id);

        return view('list.register', ['product' => $product, 'avg_evaluation' => $avg_evaluation]);
    }

    public function toReview(Request $request)
    {
        $id = $request->id;
        $product = $this->searchProduct($id);
        $reviews = $this->searchReviews($id);
        $avg_evaluation = $this->avgEvaluation($id);

        return view('list.review_list', ['product' => $product, 'reviews' => $reviews, 'avg_evaluation' => $avg_evaluation]);
    }

    public function toConfirmForm(Request $request)
    {

        $inputs = $request->all();

        $this->validator($request->only('evaluation', 'comment'))->validate();

        $id = $request->id;

        $product = $this->searchProduct($id);
        $avg_evaluation = $this->avgEvaluation($id);

        return view('list.confirm', ['inputs' => $inputs, 'product' => $product, 'avg_evaluation' => $avg_evaluation]);
    }

    public function complete(Request $request)
    {

        $inputs = $request->all();

        // DBに登録
        $review = new Review();
        $review->member_id = Auth::id();
        $review->product_id = $inputs['id'];
        $review->evaluation = $inputs['evaluation'];
        $review->comment = $inputs['comment'];
        $review->save();

        // 二重送信防止
        $request->session()->regenerateToken();

        return view('list.complete', ['id' => $inputs['id']]);
    }
}
