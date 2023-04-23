@extends('pages.front.master')
@section('content')
<!-- start main -->
<section class="search">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('site.home')</a></li>
                        <li class="breadcrumb-item"><img src="{{asset('front')}}/assets/images/bread-arrow.png" alt=""></i></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$page_title}}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-3 col-md-2"> </div>
            <div class="col-lg-2 col-md-3">
                <div class="d-grid gap-2">
                   <x-create-ad-button/>
                </div>
            </div>
            <div class="col-lg-12  mt-4">
                <div class="row">
                    <div class="col-lg-3 pt-3">
                        <x-profile-sidebar/>
                    </div>
                    <div class="col-lg-9">
                        @livewire('commission-history')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
