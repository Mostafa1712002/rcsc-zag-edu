
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@lang('site.site_title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1">RCSC</a>
      <div class="row">
        @if (app()->getLocale()!='ar')
          <img src="{{asset('icons/ar-lang.png')}}"/>
          <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}">@lang('general.arabic')</a>
        @else
        <img src="{{asset('icons/en-lang.png')}}"/>
          <a href="{{ LaravelLocalization::getLocalizedURL('en') }}">@lang('general.english')</a>
        @endif
      </div>
    </div>
    <div class="card-body">
      <p class="login-box-msg">@lang('general.signinToContinue')</p>

      @if (session('error_message'))
          <div class='alert alert-danger'>
            {{session('error_message')}}
        </div>
      @elseif (session('success_message'))
        <div class='alert alert-success'>
            {{session('success_message')}}
        </div>
      @endif

      <form action="{{route('login')}}" id='login-form' method="post">

        @csrf
        @if($errors->has('login_failed'))
            {{spark_alertError($errors->first('login_failed')) }}
        @endif

        <div class="form-group mb-3">
            <input type="text" placeholder="Email" id="email" class="form-control" name="email"
                autofocus>
            @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-group mb-3">
            <input type="password" placeholder="Password" id="password" class="form-control" name="password" >
            @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                @lang('general.remember_me')
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" id='login-btn' class="btn btn-primary btn-block">@lang('general.login')</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="#">@lang('general.didYouForgotPassword')</a>
      </p>
      <p class="mb-0">

      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>

<script src='{{ asset('generalAssets/'.app()->getLocale().'/paths.js')}}'></script>
<script src='{{ asset('generalAssets/general.js')}}'></script>
<script src='{{ asset('generalAssets/ajaxGeneral.js')}}'></script>
<script src='{{ asset('generalAssets/crud.js')}}'></script>

</body>
</html>
