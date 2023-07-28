<?php

namespace App\Http\Controllers;

use App\Member;
use App\Product;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminReviewController extends Controller
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

    public function showReviewList(Request $request)
    {
        $search = Review::query();
        $search->where('deleted_at', null);

        if ($request->id != '') {

            $id = $request->id;
            $search->where('id', $id);
        }

        if ($request->free_word != '') {
            $free_word = $request->free_word;
            $search->where('comment', 'like', '%' . $free_word . '%');
        }

        if (!empty($request->sort) && !empty($request->direction)) {
            $sort = $request->sort;
            $direction = $request->direction;
            $search->orderBy($sort, $direction);
        } else {
            $search->orderBy('id', 'desc');
        }

        $reviews = $search->paginate(10);

        return view('admin.review.list', ['reviews' => $reviews]);

    }
    public function reviewEdit(Request $request)
    {
        $id = $request->id;
        $products = Product::query()->where('deleted_at', null)->get();
        $members = Member::query()->where('deleted_at', null)->get();
        $review = Review::query()->where('reviews.id', $id)->first();

        return view('admin.review.edit', ['products' => $products, 'members' => $members,'review' => $review]);

    }
    public function toReviewConfirm(Request $request)
    {

        $this->validator($request->only('name', 'member_id', 'evaluation', 'comment'))->validate();

        $product_id = $request->name;
        $member_id = $request->member_id;
        $id = $request->id;
        $inputs = $request->all();

        $product = Product::query()->where('id', $product_id)->first();

        $avg = Review::query()->selectRaw('AVG(evaluation) as avg')->where('product_id', $product_id)->first();
        $avg_evaluation = $avg->avg;

        $member = Member::query()->where('id', $member_id)->first();

        return view('admin.review.confirm', ['inputs' => $inputs, 'product' => $product, 'avg_evaluation' => $avg_evaluation, 'member' => $member]);
    }

    public function reviewComplete(Request $request)
    {
        // 二重送信防止
        $request->session()->regenerateToken();

        if ($request->from == 'regist') {
            Review::create([
                'member_id' => $request->member_id,
                'product_id' => $request->product_id,
                'evaluation' => $request->evaluation,
                'comment' => $request->comment,
            ]);
        } else {
            Review::where('id', $request->id)->update([
                'member_id' => $request->member_id,
                'product_id' => $request->product_id,
                'evaluation' => $request->evaluation,
                'comment' => $request->comment,
            ]);
        }

        return redirect()->route('admin.review.list');
    }

    public function toReviewDetail(Request $request)
    {
        $id = $request->id;

        $review = Review::query()->where('reviews.id', $id)->first();

        $product_id = $review->product_id;
        $member_id = $review->member_id;

        $product = Product::query()->where('id', $product_id)->first();

        $avg = Review::query()->selectRaw('AVG(evaluation) as avg')->where('product_id', $product_id)->first();
        $avg_evaluation = $avg->avg;

        $member = Member::query()->where('id', $member_id)->first();


        return view('admin.review.detail', ['review' => $review, 'product' => $product, 'avg_evaluation' => $avg_evaluation, 'member' => $member]);

    }

    public function reviewDetailDelete(Request $request)
    {
        $id = $request->id;

        Review::query()->where('id', $id)->update(['deleted_at' => now()]);

        return redirect()->route('admin.review.list');

    }

    public function fetch()
    {

    }

    public function upload()
    {

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'exists:products,id'],
            'member_id' => ['required', 'exists:members,id'],
            'evaluation' => ['required', 'in:1,2,3,4,5'],
            'comment' => ['required', 'string', 'max:500'],
        ]);
    }
}
