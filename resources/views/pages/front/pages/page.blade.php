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
                        <li class="breadcrumb-item active" aria-current="page">{{$record->{"title_".app()->getLocale()} }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-3 col-md-1"> </div>
            <div class="col-lg-2 col-md-3">
                <div class="d-grid gap-2">
                    <x-create-ad-button/>
                </div>

            </div>
        </div>
        <div class="row">

            <div class="col-lg-8 mt-4">
               <div class="terms" style="word-break: break-all;">
                        <div class="head-term">
                            <h5 class="simler-add">{{$record->{"title_".app()->getLocale()} }}</h5>
                        </div>

                        {!! $record->{"content_".app()->getLocale()} !!}
                </div>
            </div>

            <!-- Recent ads -->
            <div class="col-lg-4 mt-4">
                <h5 class="simler-add">@lang('site.recent_ads')</h5>
                <x-recent-ads-sidebar/>

            </div><!-- Recent ads-->

        </div>
    </div>
</section>


@endsection

