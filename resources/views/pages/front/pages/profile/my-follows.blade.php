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
            <div class="col-lg-3 col-md-1"> </div>
            <div class="col-lg-2 col-md-3">
                <div class="d-grid gap-2">
                    <x-create-ad-button/>
                </div>

            </div>
        </div>
        <div class="row">

            <div class="col-lg-10 m-auto mt-4">
                <div class="following">
                    <h5 class="simler-add">{{$page_title}}</h5>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link @if(request('tab','ads')=='ads') active @endif"
                                id="home-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#home"
                                type="button"
                                role="tab"
                                aria-controls="home"
                                aria-selected="true">@lang('site.ads')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link @if(request('tab','ads')=='customers') active @endif"
                                id="profile-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#profile"
                                type="button"
                                role="tab"
                                aria-controls="profile"
                                aria-selected="false">@lang('site.customers')</button>
                        </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">

                        <!-- Ads tab -->
                        <div class="tab-pane fade show @if(request('tab','ads')=='ads') active @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="float-end add-neww">{{$records_count}} @lang('site.result')</h4>
                                    <div class="buttons col-md-12 mt-3" dir="ltr">
                                        <button class="btn" id="showdiv2" aria-hidden="true"> <i class="fa fa-th-large"></i></button>
                                        <button class="btn" id="showdiv1"   aria-hidden="true"><i class="fa fa-th-list"></i> </button>
                                    </div>


                                    <!--ads List-->
                                    <div id="div1" @if(request('display','list')=='grid') display:none; @endif>
                                        <section class="section-list">
                                            <div class="row">
                                                @foreach ($records as $record)
                                                    <x-ad-list-item :ad="$record"/>
                                                @endforeach
                                            </div>
                                        </section>
                                        {{$records->withQueryString()->appends(['tab'=>'ads','display'=>'list'])->links()}}
                                    </div>


                                    <!--ads Grid-->
                                    <div id="div2" style="@if(request('display','list')=='list') display:none; @endif">
                                        <section class="section-grid">
                                            <div class="grid-prod row">
                                                @foreach ($records as $record)
                                                    <x-ad-grid-item :ad="$record"/>
                                                @endforeach
                                            </div>
                                        </section>
                                        {{$records->withQueryString()->appends(['tab'=>'ads','display'=>'grid'])->links()}}
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!-- Customers tab -->
                        <div class="tab-pane fade @if(request('tab','ads')=='customers') active @endif" " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="float-end add-neww">{{$customers_count}} @lang('site.result')</h4>
                                    <div class="buttons col-md-12 mt-3" dir="ltr">
                                        <button class="btn" id="showdiv11" aria-hidden="true"> <i class="fa fa-th-large"></i></button>
                                        <button class="btn" id="showdiv22"   aria-hidden="true"><i class="fa fa-th-list"></i> </button>
                                    </div>
                                    <!--Product List-->
                                    <div id="div22">
                                        <section class="section-list">
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    @foreach($customers as $customer)
                                                        <div class="search-card-box bg-card-dark search-card-box-22">
                                                            <div class="imge-card-top">
                                                                {!! spark_starsRating($customer->ratings_on_avg_value) !!}
                                                            </div>
                                                            <div class="follow-box">
                                                                <div class="follow-img-box">
                                                                    <img src="{{$customer->avatar_url}}" alt="">
                                                                </div>
                                                                <div class="">
                                                                    <h5 title="{{$customer->full_name}}">
                                                                        {{
                                                                            mb_strlen($customer->full_name)>25?
                                                                            mb_substr($customer->full_name,0,25).'...':
                                                                            $customer->full_name
                                                                        }}
                                                                    </h5>
                                                                    <a href="{{route('show_customer',$customer->id)}}">@lang('site.customer_profile')</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </section>
                                        {{$customers->withQueryString()->appends(['tab'=>'customers','display'=>'list'])->links()}}
                                    </div>

                                    <!--Product Grid-->
                                    <div id="div11"  style="display:none;">
                                        <section class="section-grid">
                                            <div class="grid-prod row">
                                                @foreach($customers as $customer)
                                                    <div class="col-md-4">
                                                        <div class="following-card bg-card-dark rounded pt-2 px-3 pb-4">
                                                            <div class="following-card-img">
                                                            <img src="{{$customer->avatar_url}}" alt=""/>
                                                            </div>
                                                            <div class="following-card-info">
                                                                <h4 title="{{$customer->full_name}}">
                                                                        {{
                                                                            mb_strlen($customer->full_name)>20?
                                                                            mb_substr($customer->full_name,0,20).'...':
                                                                            $customer->full_name
                                                                        }}
                                                                </h4>
                                                                {!! spark_starsRating($customer->ratings_on_avg_value) !!}
                                                                <a href="{{route('show_customer',$customer->id)}}">
                                                                    @lang('site.customer_profile')
                                                                    <img src="{{asset('front')}}/assets/images/go.png" alt="" class="float-start">
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                {{$customers->withQueryString()->appends(['tab'=>'customers','display'=>'grid'])->links()}}
                                            </div>
                                        </section>
                                    </div>

                                </div>
                            </div>
                        </div>
                        </div>

                </div>

            </div>
{{--            <div class="col-lg-4 mt-4">--}}
{{--                <h5 class="simler-add">@lang('site.recent_ads')</h5>--}}
{{--                <x-recent-ads-sidebar/>--}}
{{--            </div>--}}

        </div>
    </div>
</section>
@endsection
