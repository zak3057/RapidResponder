@extends('common.master')

@section('content')
<div class="container mt-5 mb-5">

    <div class="panel panel-default">
        <div class="panel-heading">ログインに成功しました。</div>

        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <p><a href="">お問い合わせ一覧</a></p>
        </div>
    </div>

</div>
@endsection