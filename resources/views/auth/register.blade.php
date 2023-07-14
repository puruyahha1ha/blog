{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
@extends('layouts.templete')
@section('title', '会員登録画面')
@section('main')
    <h1>会員情報登録</h1>

    <form method="POST" action="{{ route('register.confirm') }}">
        @csrf
        <div id="regist_form">

            {{-- 氏名 --}}
            <div class="name">
                <p>氏名</p>
                <span>姓</span>
                <input type="text" name="name_sei" value="{{ old('name_sei') }}">
                <span>名</span>
                <input type="text" name="name_mei" value="{{ old('name_mei') }}">
            </div>

            {{-- 姓のエラーメッセージ --}}
            @error('name_sei')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- 名のエラーメッセージ --}}
            @error('name_mei')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- ニックネーム --}}
            <div class="form_row">
                <p>ニックネーム</p>
                <input type="text" name="nickname" value="{{ old('nickname') }}">
            </div>

            {{-- ニックネームのエラーメッセージ --}}
            @error('nickname')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- 性別 --}}
            <div class="gender">
                <p>性別</p>
                @foreach (Config('master.gender') as $key => $value)
                    <input type="radio" name="gender" value="{{ $key }}" id="{{ $value }}"
                        {{ old('gender') == $key ? 'checked' : '' }}><label
                        for="{{ $value }}">{{ $value }}</label>
                @endforeach
            </div>

            {{-- 性別のエラーメッセージ --}}
            @error('gender')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- パスワード --}}
            <div class="form_row">
                <p>パスワード</p>
                <input type="password" name="password" value="{{ old('password') }}">
            </div>

            {{-- パスワードのエラーメッセージ --}}
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- パスワード確認 --}}
            <div class="form_row">
                <p>パスワード確認</p>
                <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
            </div>

            {{-- パスワード確認のエラーメッセージ --}}
            @error('password_confirmation')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- メールアドレス --}}
            <div class="form_row">
                <p>メールアドレス</p>
                <input type="text" name="email" value="{{ old('email') }}">
            </div>

            {{-- メールアドレスのエラーメッセージ --}}
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

        </div>

        <div class="button">
            <input type="submit" name="confirm" value="確認画面へ" class="submit">
        </div>
    </form>

    <div class="button">
        <a href="/" class="submit_re" style="margin-top: 0px">トップに戻る</a>
    </div>

@endsection
