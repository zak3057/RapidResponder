@extends('common.master')

@section('content')
<div class="container mt-5 mb-5">

    <div class="panel panel-default">
        <h2>ログインに成功しました</h2>

        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection