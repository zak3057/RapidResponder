@extends('common.master')
@section('title', 'お問い合わせ内容確認')

@section('content')
<div class="container mt-5 mb-5">
    <h1>お問い合わせ内容確認</h1>
    <p class="lead">入力内容をご確認ください。</p>

    <form class="mt-4" method="POST" action="{{ route('contact.send') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="exampleInputName1">氏名 <small class="text-danger">(必須/16文字以下)</small></label>
            <input type="text" class="form-control" id="exampleInputName1" aria-describedby="" required readonly value="{{ $inputs['name'] }}" name="name">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">メールアドレス <small class="text-danger">(必須/200文字以下)</small></label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="" required readonly value="{{ $inputs['mail'] }}" name="mail">
        </div>

        <div class="form-group">
            <label for="exampleInputTell1">電話番号 <small class="text-danger">(必須/12文字以下)</small></label>
            <input type="tel" class="form-control" id="exampleInputTell1" aria-describedby="" required readonly value="{{ $inputs['tel'] }}" name="tel">
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect1">製品種別 <small class="text-danger">(必須)</small></label>
            <select class="form-control" id="exampleFormControlSelect1" required name="item" style="background-color: #e9ecef;">
                <option selected value="{{ $inputs['item'] }}">{{ $inputs['item'] }}</option>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">問い合わせ内容 <small class="text-danger">(必須/2000文字以下)</small></label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" required readonly name="body">{{ $inputs['body'] }}</textarea>
        </div>

        <button type="button" onclick="history.back()" class="btn btn-secondary" tabindex="1">修正する</button>
        <button type="submit" class="btn btn-primary" tabindex="2">送信する</button>
    </form>

</div>



@endsection