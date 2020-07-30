<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>〇〇社 | @yield('title', 'Home')</title>

    @section('style')
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    @show
</head>
<body>

    @include('common.header')

    @yield('content')

    @section('script')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="/js/bootstrap.min.js"></script>
    @show
</body>
</html>