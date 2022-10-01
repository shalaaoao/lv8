<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="description" content="Julyaoao的小窝" />
    <meta name="keywords" content="Julyaoao的小窝" />
    <title>@yield('title','Julyaoao的小窝')</title>

    <link rel="stylesheet" href="{{asset('css/common.css')}}">

    @yield('head_css')

    <script src="{{asset("plugins/login_boot/js/jquery-1.11.1.min.js")}}"></script>
    <script src="{{asset("js/common.js")}}"></script>

    <!--百度统计-->
    <script src="{{asset("js/baidu_statistics.js")}}"></script>

</head>
@yield('body_before')
<body>
@yield('content')

<!-- 底部 -->
@yield('footer_before')

@include('global_footer')
