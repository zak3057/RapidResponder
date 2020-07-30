@extends('common.master')
@section('title', 'お問い合わせ')

@section('content')
<div class="container mt-5 mb-5">
    <h2>お問い合わせ</h2>
    <p class="lead">以下の項目への入力をお願いいたします。</p>

    <form class="mt-4" method="POST" action="{{ route('contact.confirm') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="exampleInputName1">氏名 <small class="text-danger">(必須/16文字以下)</small></label>
            <input type="text" class="form-control" id="exampleInputName1" aria-describedby="" placeholder="山田　太郎" required name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
                <small class="form-text text-danger">{{ $errors->first('name') }}</small>
            @endif
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">メールアドレス <small class="text-danger">(必須/200文字以下)</small></label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="hogehoge@example.com" required name="mail" value="{{ old('mail') }}">
            @if ($errors->has('mail'))
                <small class="form-text text-danger">{{ $errors->first('mail') }}</small>
            @endif
        </div>

        <div class="form-group">
            <label for="exampleInputTell1">電話番号 <small class="text-danger">(必須/12文字以下)</small></label>
            <input type="tel" class="form-control" id="exampleInputTell1" aria-describedby="" placeholder="090xxxxxxxx" required name="tel" value="{{ old('tel') }}">
            @if ($errors->has('tel'))
                <small class="form-text text-danger">{{ $errors->first('tel') }}</small>
            @endif
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect1">製品種別 <small class="text-danger">(必須)</small></label>
            <select class="form-control" id="exampleFormControlSelect1" required name="item">
                <option disabled selected>選択してください</option>
                <option value="A001" @if(old('item')=='A001') selected  @endif>A001</option>
                <option value="A002" @if(old('item')=='A002') selected  @endif>A002</option>
                <option value="A003" @if(old('item')=='A003') selected  @endif>A003</option>
                <option value="A004" @if(old('item')=='A004') selected  @endif>A004</option>
                <option value="A005" @if(old('item')=='A005') selected  @endif>A005</option>
                <option value="A006" @if(old('item')=='A006') selected  @endif>A006</option>
                <option value="A007" @if(old('item')=='A007') selected  @endif>A007</option>
                <option value="A008" @if(old('item')=='A008') selected  @endif>A008</option>
                <option value="A009" @if(old('item')=='A009') selected  @endif>A009</option>
                <option value="A010" @if(old('item')=='A010') selected  @endif>A010</option>
                <option value="A011" @if(old('item')=='A011') selected  @endif>A011</option>
                <option value="A012" @if(old('item')=='A012') selected  @endif>A012</option>
                <option value="A013" @if(old('item')=='A013') selected  @endif>A013</option>
                <option value="A014" @if(old('item')=='A014') selected  @endif>A014</option>
                <option value="A015" @if(old('item')=='A015') selected  @endif>A015</option>
                <option value="A016" @if(old('item')=='A016') selected  @endif>A016</option>
            </select>
            @if ($errors->has('item'))
                <small class="form-text text-danger">{{ $errors->first('item') }}</small>
            @endif
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">問い合わせ内容 <small class="text-danger">(必須/2000文字以下)</small></label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" required name="body">{{ old('body') }}</textarea>
            @if ($errors->has('body'))
                <small class="form-text text-danger">{{ $errors->first('body') }}</small>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">入力確認画面へ</button>
    </form>
</div>
@endsection