<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@lang('general.siteTitle')</title>
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
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Animal</b>Station</a>
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
      <p class="login-box-msg">@lang('general.enterEmail')</p>
      <form action="#" id='reset-password-form' method="post">

       {!! spark_alerts('reset-password')!!}


        <div class="input-group form-group mb-3">
          <input type="email" name = 'email' class="form-control" placeholder="@lang('general.enterEmail')">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <span class="invalid-feedback"></span>
        </div>
        <div class="row">
          <div class="col-12">
            <button 
             type="submit"
             id='send-reset-password-code-btn'
             class="btn btn-primary btn-block">
              @lang('general.send_reset_password_code')
             </button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="{{route('login')}}">@lang('general.login')</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
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

<script type='text/javascript'>
 $(document).ready(function(){

  $('body').delegate('#send-reset-password-code-btn','click',function(e){
   e.preventDefault();
   $.ajax({
    url:systemPath('send-reset-password-code'),
    type:'PUT',
    data:{
     email:$('[name=email]').val()
    },
    success:function(res){
       window.location.href=publicPath('forget-password-code');
     },
     error:function(res){              
        if(res.status==422){
          populateErrorMsgs(res.responseJSON.errors);
        }else{
          alertError('reset-password',res.responseJSON.msg);
        }
         
     }
   });
  });

 });
</script>
</body>
</html>
