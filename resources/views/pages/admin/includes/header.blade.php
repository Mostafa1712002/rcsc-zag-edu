<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@lang('site.site_title') - {{$page_title}} </title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="accept-language" content="{{ app()->getLocale() }}">
  <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('front/jquery-confirm/css/jquery-confirm.css')}}"/>
  @if(app()->getLocale()=='ar')
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="{{asset('dist/css/custom.css')}}">

  @endif

  <style>
      .rating .checked {
        color: #EDCA1D;
    }
    td{
        word-break: break-all;
    }
  </style>
  @stack('page-styles')
    @livewireStyles()
</head>
<body class="sidebar-mini layout-fixed sidebar-collapse sidebar-closed">
<div class="wrapper">

  <!-- Preloader -->
  {{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('dist/img/AdminLTELogo.png')}}" alt="@lang('site.site_title')" height="60" width="60">
  </div> --}}

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('admin.home')}}" class="nav-link">@lang('general.home')</a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav {{app()->getLocale() == 'ar'? 'mr-auto-navbav' : 'ml-auto'}} ">

      <li class="nav-item">
        @if (app()->getLocale()!='ar')
          <a class ='nav-link' href="{{ LaravelLocalization::getLocalizedURL('ar') }}">
            <img src="{{asset('icons/ar-lang.png')}}"/>
            @lang('general.arabic')
          </a>
        @else
        <a class ='nav-link' href="{{ LaravelLocalization::getLocalizedURL('en') }}">
          <img src="{{asset('icons/en-lang.png')}}" alt="">
          @lang('general.english')
        </a>
        @endif
      </li>


      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="{{route('admin.getProfile')}}" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> @lang('general.profile')
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{route('logout')}}" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> @lang('general.logout')
          </a>
        </div>
      </li>


    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 right-side stretch">
    <!-- Brand Logo -->
    <a href="{{route('admin.home')}}" class="brand-link">
      <img
        src="{{asset('dist/img/AdminLTELogo.png')}}"
        alt="@lang('site.site_title')"
        class="brand-image img-circle elevation-3"
        style="opacity: .8"
      />
      <span class="brand-text font-weight-light">@lang('site.site_title')</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img style='width:100%;height:100%' src="{{auth('admin')->user()->avatar_url}}" class="img-circle elevation-2" alt="{{auth('admin')->user()->name}}"/>
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ucfirst(auth('admin')->user()->name)}}</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        {{-- @can('users_index') --}}
            <li class="nav-item">
                <a href="{{route('admin.user.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>@lang('site.users')</p>
                </a>
            </li>
        {{-- @endcan --}}
        {{-- @can('students_index') --}}
            <li class="nav-item">
                <a href="{{route('admin.student.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>@lang('site.students')</p>
                </a>
            </li>
        {{-- @endcan --}}

        {{-- @can('questions_index') --}}
            <li class="nav-item">
                <a href="{{route('admin.question.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>@lang('site.questions')</p>
                </a>
            </li>
        {{-- @endcan --}}

        <li class="nav-item">
            <a href="{{route('admin.course.index')}}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>@lang('site.course')</p>
            </a>
        </li>


          {{-- <li class="nav-item">
            <a href="{{route('admin.setting.index')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>@lang('site.settings')</p>
            </a>
          </li> --}}






        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">

          {{-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.home')}}">@lang('general.dashboard')</a></li>
              <li class="breadcrumb-item active">{{isset($pageTitle)? $pageTitle : ''}}</li>
            </ol>
          </div><!-- /.col --> --}}
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class='row'>
