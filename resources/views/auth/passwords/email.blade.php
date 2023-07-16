{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
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

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
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
@section('title', 'パスワード再設定画面')
@section('main')
    <p>パスワード再設定用のURLを記載したメールを送信します。</p>
    <p>ご登録されたメールアドレスを入力してください。</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="reset_email_form">
            {{-- メールアドレス --}}
            <div class="form_row" @error('email') @else style="margin: 100px 0"@enderror>
                <p>メールアドレス</p>
                <input type="text" name="email" value="{{ old('email') }}">
            </div>

            {{-- メールアドレスのエラーメッセージ --}}
            @error('email')
                <div class="error" style="margin-bottom: 100px">{{ $message }}</div>
            @enderror

            <div class="button">
                <input type="submit" value="送信する" class="submit">
            </div>
        </div>

    </form>

    <div class="button">
        <a href="/" class="submit_re" style="margin-top: 0px; margin-bottom: 20px;">トップに戻る</a>
    </div>

@endsection
