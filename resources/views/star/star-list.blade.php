<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>🐷小饱饱是最棒的</title>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        table tr {
            height: 30px;
        }

        .t_left{
            text-align: left;
        }

        .t_center{
            text-align: center;
        }
    </style>
</head>
<body>
<div class="position-ref full-height">
    <div class="content" style="margin: 50px">
        <h2 class="t_center">🐷小饱饱的✨✨日志</h2>
        <h4 class="t_center">所有累计的✨✨总数：<span style="font-size: 32px">{{$sum_num}}</span></h4>
        <h4 class="t_center">可使用的✨✨总数：<span style="font-size: 32px">{{$usable_num}}</span></h4>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>日期</th>
                    <th>原因</th>
                    <th>星星</th>
                </tr>
                @foreach($data as $star)
                    <tr>
                        <td>{{$star->created_at}}</td>
                        <td>{{$star->star_desc}}</td>
                        <td>
                            @if($star->star_num > 0)
                                @for($i=0;$i<$star->star_num;$i++)
                                    ✨
                                @endfor
                            @elseif ($star->star_num < 0)
                                @for($i=0;$i<$star->star_num;$i++)
                                    ※
                                @endfor
                            @else
                                这里没有✨呢
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
</body>
</html>
