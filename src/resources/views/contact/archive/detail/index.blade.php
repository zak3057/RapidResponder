@extends('common.master')
@section('title', 'お問い合わせ詳細')

@section('content')
<div class="container mt-5 mb-5">
    <h1>お問い合わせ詳細</h1>

    <div class="mt-4">
        @if($contact->status === '未対応')
            <a class="btn btn-primary" href="{{ route('contact.archive.detail.start', ['id' => $param_id]) }}" role="button">対応開始</a>
        @elseif($contact->status === '対応中')
            <a class="btn btn-success" href="{{ route('contact.archive.detail.complete', ['id' => $param_id]) }}" role="button">処理済み</a>
            <a class="btn btn-secondary" href="{{ route('contact.archive.detail.return', ['id' => $param_id]) }}" role="button">未対応に戻す</a>
        @else
            <a class="btn btn-secondary" href="{{ route('contact.archive.detail.start', ['id' => $param_id]) }}" role="button">対応中に戻す</a>
        @endif
    </div>

    <div class="container mt-3">
        <div class="row border">
            <div class="col-12 col-sm-6 border p-2">
                <span class="pr-2" style="display: inline-block;">対応状況：</span>
                <span style="display: inline-block;">{{$contact->status}}</span>
            </div>
            <div class="col-12 col-sm-6 border p-2">
                <span class="pr-2" style="display: inline-block;">氏名：</span>
                <span style="display: inline-block;">{{$contact->name}}</span>
            </div>
            <div class="col-12 col-sm-6 border p-2">
                <span class="pr-2" style="display: inline-block;">電話番号：</span>
                <span style="display: inline-block;">{{$contact->tel}}</span>
            </div>
            <div class="col-12 col-sm-6 border p-2">
                <span class="pr-2" style="display: inline-block;">製品種別：</span>
                <span style="display: inline-block;">{{$contact->item}}</span>
            </div>
            <div class="col-12 border p-2">
                <span class="pr-2" style="display: inline-block;">問い合わせ日時：</span>
                <span style="display: inline-block;">{{$contact->created_at}}</span>
            </div>
            <div class="col-12 border p-2">
                <span class="pr-2" style="display: inline-block;">対応者：</span>
                <span style="display: inline-block;">
                @if($contact->user_id === NULL)
                    -
                @else
                    {{$contact->email}}
                @endif
                </span>
            </div>
            <div class="col-12 border p-2">
                <div>問い合わせ内容：</div>
                <div class="mt-2">
                    {{$contact->body}}
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row border">
            <div class="col-12 border p-2">
                <div class="mt-2">送信メッセージ：</div>
                <div class="mt-3 mb-2">
                    <div>
                        @foreach ($messages as $message)
                        <div class="border p-2 mb-3">
                            <div class="border-bottom">
                                <span>送信日：</span>
                                <span>{{ $message->created_at }}</span>
                            </div>
                            <div class="mt-1 border-bottom">
                                <span>送信者：</span>
                                <span>{{ $message->email }}</span>
                            </div>
                            <div class="mt-1 border-bottom">
                                <div>タイトル：</div>
                                <div>
                                    {{ $message->title }}
                                </div>
                            </div>
                            <div class="mt-1">
                                <div>本文：</div>
                                <div>
                                    {{ $message->body }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($contact->status === '対応中')
                    <form class="mt-5 border p-2" method="POST" action="{{ route('contact.archive.detail.message') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputTitle1">タイトル <small class="text-danger">(必須/200文字以下)</small></label>
                            <input type="text" class="form-control" id="exampleInputTitle1" required name="title" value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputBody1">本文 <small class="text-danger">(必須/4000文字以下)</small></label>
                            <textarea class="form-control" id="exampleInputBody1" rows="10" required name="body">{{ old('body') }}</textarea>
                        </div>

                        <input type="hidden" value="{{$contact->id}}" name="id">

                        <button type="submit" class="btn btn-primary">メールを送信</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row border">
            <div class="col-12 border p-2">
                <div class="mt-2">コメント：</div>
                <div class="mt-2 mb-2">
                    <div>
                        @foreach ($comments as $comment)
                        <div class="border p-2 mb-3">
                            <div class="border-bottom">
                                <span>登録日：</span>
                                <span>{{ $comment->created_at }}</span>
                            </div>
                            <div class="mt-1 border-bottom">
                                <span>登録者：</span>
                                <span>{{ $comment->email }}</span>
                            </div>
                            <div class="mt-1">
                                <div>コメント：</div>
                                <div>
                                    {{ $comment->body }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($contact->status === '対応中')
                    <form class="border mt-5 p-2">
                        <div class="form-group">
                            <label for="exampleInputComment1">本文(4000文字以下)</label>
                            <textarea class="form-control" id="exampleInputComment1" rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">コメントを登録</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
@parent
@endsection


@section('style')
@parent
@endsection