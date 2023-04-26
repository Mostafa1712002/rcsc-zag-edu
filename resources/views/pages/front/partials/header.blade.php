<!DOCTYPE html>
<html lang="en">
    <!-- Start head -->
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@lang('site.site_title') {{isset($page_title)? ' - '.$page_title : '';}}</title>
        <!-- bootstrap included -->
        <link rel="stylesheet" href="{{asset("front/assets")}}/css-{{app()->getLocale()}}/bootstrap.min.css" />
        <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
        <!-- start css file -->
        <link rel="stylesheet" href="{{asset("front/assets")}}/css-{{app()->getLocale()}}/style.css" />
        <!-- media Query for multi screens -->
        <link rel="stylesheet" href="{{asset("front/assets")}}/css-{{app()->getLocale()}}/responsive.css" />
        <!-- font Awesome  library-->
        <link rel="stylesheet" href="{{asset("front/assets")}}/css-{{app()->getLocale()}}/all.min.css" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

        <link rel="stylesheet" href="{{asset("front/assets")}}/font-awesome/css/font-awesome.min.css" />

        <link rel="stylesheet" href="{{asset("front/assets")}}/css/easyzoom.css" />

        <link rel="stylesheet" href="{{asset("front/assets")}}/css/newStyles.css" />

        @stack('styles')
        {!! isset($whatsapp_meta)? $whatsapp_meta : '' !!}
        <style>
            .invalid-msg{
                color:red;
            }
        </style>
        @livewireStyles
        <script defer src="//unpkg.com/alpinejs"></script>

        <script src='{{asset('js/app.js')}}'></script>

        <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=6277a2a99d3f9e001262d485&product=inline-share-buttons" async="async"></script>
    </head>
    <!-- start body -->
    <body class="d-flex justify-content-between flex-column">
        <!-- start header -->

        <header>
            <!-- start navbar -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-lg navbar-dark bg-light">
                            <div class="container-fluid">
                                <a class="navbar-brand" href="{{route('home')}}">
                                    {{-- <img src="{{asset("front/assets")}}/images/site-logo-{{app()->getLocale()}}.png" alt="" class='d-sm-none' style='width:150px;'>
                                    <img src="{{asset("front/assets")}}/images/site-logo-{{app()->getLocale()}}.png" alt="" class='d-none d-sm-block' /> --}}
                                </a>





                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                              </button>
                              <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                                <ul class="navbar-nav justify-content-end">
                                    <li class="nav-item">
                                        <ul class="dropdown-menu dropdown-menu-size nav-list" aria-labelledby="navbarDropdown">
                                            @auth('student')
                                                <li>
                                                    <a class="dropdown-item user-avatar" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img
                                                            style='width:35px;height:35px;border-color:white;border-style:solid;border-width:1px;'
                                                            src="#"
                                                            alt=""
                                                            class="avtar-top"/>
                                                        {{
                                                            mb_strlen(auth('student')->user()->full_name)>20?
                                                            mb_substr(auth('student')->user()->full_name,0,20).'...':
                                                            auth('student')->user()->full_name
                                                        }}
                                                    </a>

                                                </li>
                                            @endauth
                                            <li><a class="dropdown-item" href="{{route('home')}}"> <img src="{{asset("front/assets")}}/images/list-1.png" alt=""> @lang('site.home')</a></li>
                                        </ul>
                                    </li>

                                  @guest('student')
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{route('student.login')}}">
                                            @lang('site.login')
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{route('student.register')}}">
                                            @lang('site.register')
                                        </a>
                                    </li>
                                  @endguest

                                  <li class="nav-item d-flex mb-3">
                                    <a class="nav-link {{app()->getLocale()=='en'? 'lang-badg' : '' }} mx-2" href="{{ LaravelLocalization::getLocalizedURL('en') }}">E</a>
                                    <a class="nav-link {{app()->getLocale()=='ar'? 'lang-badg' : '' }} mx-2" href="{{ LaravelLocalization::getLocalizedURL('ar') }}"><img src="{{asset("front/assets")}}/images/ع.png" alt=""></a>
                                  </li>

                                </ul>

                              </div>
                            </div>
                          </nav>
                    </div>
                </div>
            </div>
        </header>
        <!-- start main -->

