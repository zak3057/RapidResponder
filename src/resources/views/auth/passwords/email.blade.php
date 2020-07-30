@extends('common.master')
@section('title', 'パスワードをリセットする')

@section('content')
<div class="container mt-5 mb-5">
    <div class="panel panel-default">
        <h2>パスワードをリセットする</h2>

        <div class="panel-body mt-4">
            {{-- 「パスワードリセットの案内をメールで送信しました。」等のステータス --}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">メールアドレス</label>

                    <div>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        送信
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
