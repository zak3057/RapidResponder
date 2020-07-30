@extends('common.master')
@section('title', 'ログイン')

@section('content')
<div class="container mt-5 mb-5">
    <h2>ログイン</h2>
    <p class="lead">ログイン情報を入力してください。</p>

    <form class="mt-4 form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="control-label">メールアドレス</label>
            <div>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="form-text text-danger">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="control-label">パスワード</label>

            <div>
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="form-text text-danger">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> ログイン情報を保存する
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">ログイン</button>
    </form>

    <div class="alert alert-primary mt-4" role="alert">
        パスワードを忘れた場合<a href="{{ route('password.request') }}" class="alert-link">こちら</a>からリセットしてください。
    </div>
</div>
@endsection