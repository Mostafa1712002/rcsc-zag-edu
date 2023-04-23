
@extends('pages.front.master')
@section('content')
<section class="search">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('site.home')</a></li>
                        <li class="breadcrumb-item"><img src="{{asset('front/assets')}}/images/bread-arrow.png" alt=""></i></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('site.my_ads') </li>
                    </ol>
                    </nav>
            </div>
            <div class="col-lg-3 col-md-2"> </div>
            <div class="col-lg-2 col-md-3">
                <div class="d-grid gap-2">
                    <x-create-ad-button/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-5 pt-3">
                <x-profile-sidebar/>
            </div>
            <div class="col-lg-9 col-md-7">
                @livewire('my-ads')
            </div><!-- col-lg-9 -->
        </div><!-- End row-->
    </div><!-- End container-->
</section>
@endsection
