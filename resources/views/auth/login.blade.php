{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
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
@section('title', 'ログイン画面')
@section('main')
    <h1>ログイン</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        {{-- メールアドレス（ID） --}}
        <div class="form_row">
            <p>メールアドレス（ID）</p>
            <input type="text" name="email" value="{{ old('email') }}">
        </div>

        {{-- パスワード --}}
        <div class="form_row">
            <p>パスワード</p>
            <input type="password" name="password" value="">
        </div>

        {{-- パスワード再設定画面のリンク --}}
        <div class="form_row">
            <p></p>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forget_pass">パスワードを忘れた方はこちら</a>
            @endif
        </div>

        {{-- エラーメッセージ --}}
        @if (count($errors) > 0)
            <div class="error">※IDもしくはパスワードが間違っています</div>
        @endif
        {{-- ログイン・戻る --}}
        <div class="button">
            <input type="submit" name="confirm" value="ログイン" class="submit">
        </div>
    </form>

    <div class="button">
        <a href="/" class="submit_re" style="margin-top: 0px">トップに戻る</a>
    </div>

@endsection
