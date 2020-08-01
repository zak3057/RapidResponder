@extends('common.master')
@section('title', 'お問い合わせ一覧')

@section('content')
<div class="container mt-5 mb-5">
    <h2>お問い合わせ一覧</h2>

    <ul class="nav nav-pills mt-4">
        <li class="nav-item">
            <a class="nav-link @if($status===NULL or $status==='未対応') active @endif" href="/contact/archive?status=未対応&page=1">未対応</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($status==='対応中') active @endif" href="/contact/archive?status=対応中&page=1">対応中</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($status==='対応済み') active @endif" href="/contact/archive?status=対応済み&page=1">対応済み</a>
        </li>
    </ul>



    <div class="scrollbar mt-4" id="scrollbar"><div class="inner"></div></div>
    <div class="table-responsive-xl scroll-table mb-4 contact-archive-table">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">対応状況</th>
                    <th scope="col">氏名</th>
                    <th scope="col">電話番号</th>
                    <th scope="col">製品種別</th>
                    <th scope="col" class="contact-archive-table--body">問い合わせ内容</th>
                    <th scope="col">問い合わせ日時</th>
                </tr>
            </thead>
            <tbody>
                @if($record === false)
                    <tr class="hover-none">
                        <th class="text-center" colspan="7">レコードが存在しません。</th>
                    </tr>
                @else
                    @foreach ($contacts as $contact)
                    <tr>
                        <th>{{$contact->id}}</th>
                        <th>{{$contact->status}}</th>
                        <th>{{$contact->name}}</th>
                        <th>{{$contact->tel}}</th>
                        <th>{{$contact->item}}</th>
                        <th class="contact-archive-table--body">{{mb_substr($contact->body, 0, 100)}}</th>
                        <th>{{$contact->created_at}}</th>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>



    <!-- <nav aria-label="Page navigation example mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">前へ</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
            <li class="page-item"><a class="page-link" href="#">10</a></li>
            <li class="page-item">
                <a class="page-link" href="#">次へ</a>
            </li>
        </ul>
    </nav> -->


    <nav aria-label="Page navigation example mt-4">
        {{ $contacts->links('vendor/pagination/pagination_view') }}
    </nav>

</div>
@endsection


@section('script')
@parent
<script src="/js/contact/archive/script.js"></script>
@endsection


@section('style')
@parent
<link rel="stylesheet" href="/css/contact/archive/style.css">
@endsection