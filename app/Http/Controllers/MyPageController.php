<?php

namespace App\Http\Controllers;

use App\Mail\UpdateMail;
use App\Member;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function toMyPage()
    {
        return view('mypages.mypage');
    }

    public function toWithdrawal()
    {
        return view('mypages.withdrawal');
    }

    public function completeWithdrawal(Request $request)
    {
        DB::table('members')->where('id', Auth::user()->id)->update(['deleted_at' => now()]);

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    public function toInfoUpdate()
    {
        return view('mypages.info_update');
    }

    public function toPasswordUpdate()
    {
        return view('mypages.pass_update');
    }

    public function toEmailUpdate()
    {
        return view('mypages.email_update');
    }

    public function toInfoUpdateConfirm(Request $request)
    {

        $inputs = $request->all();

        $this->validator($request->only('name_sei', 'name_mei', 'nickname', 'gender'))->validate();

        return view('mypages.info_confirm', ['inputs' => $inputs]);
    }

    public function infoUpdateComplete(Request $request)
    {
        // 更新処理
        Member::where('id', Auth::user()->id)
            ->update(['name_sei' => $request->name_sei, 'name_mei' => $request->name_mei, 'nickname' => $request->nickname, 'gender' => $request->gender]);

        return redirect()->route('mypage');
    }

    public function passwordUpdateComplete(Request $request)
    {
        $this->passwordValidator($request->only('password', 'password_confirmation'))->validate();

        $password = bcrypt($request->password);
        // パスワード更新処理
        Member::where('id', Auth::user()->id)->update(['password' => $password]);

        return redirect()->route('mypage');
    }

    public function emailUpdateConfirm(Request $request)
    {
        $this->emailValidator($request->only('email'))->validate();

        $auth_code = random_int(100000, 999999);
        Member::where('id', Auth::user()->id)->update(['auth_code' => $auth_code]);

        // 送信メール
        Mail::to($request->email)->send(new UpdateMail([
            'auth_code' => $auth_code
        ]));

        return redirect()->route('mypages.showEmail', ['email' => $request->email]);
    }

    public function showEmail(Request $request)
    {
        return view('mypages.email_confirm', ['email' => $request->email]);
    }
    public function emailUpdateComplete(Request $request)
    {
        $this->authCodeValidator($request->only('auth_code'))->validate();

        $email = $request->email;
        Member::where('id', Auth::user()->id)->update(['email' => $email]);
        return redirect()->route('mypage');
    }

    public function toReviewControl()
    {
        $product_ids = DB::table('reviews')->select('product_id')->where(['member_id' => Auth::user()->id, 'deleted_at' => null])->get()->all();
        $ids = [];
        foreach ($product_ids as $key => $val) {
            foreach ($val as $val_k => $val_v) {
                array_push($ids, $val_v);
            }
        }

        $reviews = DB::table('reviews')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_subcategories', 'products.product_subcategory_id', '=', 'product_subcategories.id')
            ->select('reviews.*', 'products.product_category_id', 'products.product_subcategory_id', 'products.name', 'products.image_1', 'products.image_2', 'products.image_3', 'products.image_4', 'product_categories.name as main_name', 'product_subcategories.name as sub_name')
            ->where(['reviews.member_id' => Auth::user()->id, 'reviews.deleted_at' => null])
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('mypages.review_control', ['reviews' => $reviews]);
    }

    public function toReviewUpdate(Request $request)
    {
        $id = $request->id;
        $product_id = $request->product_id;

        $product = $this->searchProduct($product_id);
        $avg_evaluation = $this->avgEvaluation($product_id);
        $review = DB::table('reviews')->where('id', $id)->first();

        return view('mypages.review_update', ['product' => $product, 'avg_evaluation' => $avg_evaluation, 'review' => $review]);
    }

    public function toReviewConfirm(Request $request)
    {
        $inputs = $request->all();

        $this->reviewValidator($request->only('evaluation', 'comment'))->validate();

        $product_id = $request->product_id;

        $product = $this->searchProduct($product_id);
        $avg_evaluation = $this->avgEvaluation($product_id);

        return view('mypages.review_confirm', ['inputs' => $inputs, 'product' => $product, 'avg_evaluation' => $avg_evaluation]);
    }

    public function reviewComplete(Request $request)
    {
        Review::where('id', $request->id)->update(['evaluation' => $request->evaluation, 'comment' => $request->comment]);
        return redirect()->route('mypage.control');
    }
    public function toReviewDelete(Request $request)
    {
        $id = $request->id;
        $product_id = $request->product_id;

        $product = $this->searchProduct($product_id);
        $avg_evaluation = $this->avgEvaluation($product_id);
        $review = DB::table('reviews')->where('id', $id)->first();

        return view('mypages.review_delete', ['product' => $product, 'avg_evaluation' => $avg_evaluation, 'review' => $review]);
    }
    public function reviewDeleteComplete(Request $request)
    {
        Review::where('id', $request->id)->update(['deleted_at' => now()]);
        
        return redirect()->route('mypage.control');
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
            'name_sei' => ['required', 'string', 'max:20'],
            'name_mei' => ['required', 'string', 'max:20'],
            'nickname' => ['required', 'string', 'max:10'],
            'gender' => ['required', 'integer', 'in:1,2'],
        ]);
    }
    protected function passwordValidator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'max:20', 'regex:/^[a-zA-Z0-9]+$/', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:20', 'regex:/^[a-zA-Z0-9]+$/'],
        ]);
    }

    protected function emailValidator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'max:200', 'email', 'unique:members'],
        ]);
    }

    protected function authCodeValidator(array $data)
    {
        $auth_code = $data['auth_code'];

        return Validator::make($data, [
            'auth_code' => ['required', 'integer', 'exists:members,auth_code'],
        ]);
    }

    protected function reviewValidator(array $data)
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

    protected function avgEvaluation($id)
    {
        $avgEvaluation = DB::table('reviews')
            ->where('product_id', $id)
            ->avg('evaluation');

        return $avgEvaluation;
    }
}
