@extends('main')

@section('head_css')
<!-- CSS -->
<link rel="stylesheet" href="{{asset('plugins/login_boot/bootstrap/css/bootstrap.css')}}">
{{--<link rel="stylesheet" href="{{asset('plugins/login_boot/font-awesome/css/font-awesome.min.css')}}">--}}
<link rel="stylesheet" href="{{asset('plugins/login_boot/css/form-elements.css')}}">
<link rel="stylesheet" href="{{asset('plugins/login_boot/css/style.css')}}">

@stop

@section('body_before')

@stop
@section('content')

<!-- Top content -->
<div class="top-content">

    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><strong>添加小✨✨</strong></h1>
                    <div class="description">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">

                    <div class="form-bottom">
                        <form role="form" action="/star/add" method="post" class="login-form">
                            {{csrf_field()}}
                            <div class="form-group">
                                <select name="star_type" class="form-control" required>
                                    <option value="">--请选择--</option>
                                    @foreach ($star_types as $star_type => $t )
                                        <option value="{{$star_type}}">{{$t}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="star_num" placeholder="✨✨数量">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="star_desc" placeholder="手动填写理由">
                            </div>
                            <input type="submit" class="btn" value="添加!">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Javascript -->
{{--<script src="{{asset("plugins/login_boot/bootstrap/js/bootstrap.min.js")}}"></script>--}}
<script src="{{asset("plugins/login_boot/js/jquery.backstretch.min.js")}}"></script>
<script src="{{asset("plugins/login_boot/js/scripts.js")}}"></script>
{{--<script src="{{asset("plugins/login_boot/js/placeholder.js")}}"></script>--}}

<script>

        @if(\Illuminate\Support\Facades\Session::has('star_alert'))
        console.log(12312312);
        alert("{{\Illuminate\Support\Facades\Session::pull('star_alert')}}");
    @endif
</script>

@stop
