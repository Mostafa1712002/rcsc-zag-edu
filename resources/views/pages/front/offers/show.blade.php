@php
    $title = $record->{"title_".app()->getLocale()};
    $whatsapp_meta = "
        <meta content='".$title."' property='og:title'/>
        <meta content='".$title."' property='og:description'/>
        <meta property='og:image' content='".$record->pic_url."'/>
        <meta property='og:url' content='".route('show_offer',$record->id)."'/>
    ";
@endphp

@extends('pages.front.master')
@section('content')

<section class="search">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9">
                <div class="row">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><img src="{{asset('front/assets')}}/images/bread-arrow.png" alt=""></i></li>

                            <li class="breadcrumb-item">
                                <a href="{{route('show_offers')}}">
                                    @lang('site.offers')
                                </a>
                            </li>
                            <li class="breadcrumb-item"><img src="{{asset('front/assets')}}/images/bread-arrow.png" alt=""></i></li>

                            <li class="breadcrumb-item active" aria-current="page">{{$page_title}}</li>
                        </ol>
                    </nav>
                    <div class="col-md-7">
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1"> </div>
            <div class="col-lg-2 col-md-2">
                <div class="d-grid gap-2">
                    <x-create-ad-button/>
                </div>

            </div>
        </div>
        <div class="row">

            <div class="col-lg-8 mt-4">
                <div class="advertise-card bg-card-dark">


                    <div class="search-card-box p-0">
                        <ul class="head-add-info">
                            <li class="float-start">{{$record->created_at->diffForHumans()}}</li>
                        </ul>
                        <h5>{{$page_title}}</h5>
                        <ul class="mt-3">
                            {{-- <li>
                                <span class="departed">
                                    <a href="{{route('show_offers')}}">
                                        @lang('site.offers')
                                    </a>
                                </span>
                            </li>
 --}}

                        </ul>
                        <ul class="pb-3 mt-3">
                            {{-- <li><img src="{{asset('front/assets')}}/images/dark-label.png" alt=""><span>@lang('validation.attributes.ad_type') : @lang('site.'.$record->ad_type)</span></li>                             --}}
                        </ul>
                    </div>
                    <div class="advertise-details">
                        <h6>@lang('site.offer_details')</h6>
                        <p>{{$record->{"content_".app()->getLocale()} }}</p>
                            <h6 class="my-3">@lang('site.offer_pic')</h6>
                            <div>
                                <img src="{{$record->pic_url}}" alt="" class="d-block w-100">
                            </div>
                    </div>
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

