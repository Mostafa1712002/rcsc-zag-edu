@extends('pages.front.master')
@section('content')
 <section class="search">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="#">@lang('site.home')</a></li>
                              <li class="breadcrumb-item"><img src="{{asset('front')}}/assets/images/bread-arrow.png" alt=""></i></li>
                              <li class="breadcrumb-item active">@lang('site.calculate_commission')</li>
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
                <div class="row"  x-data="{amount:0,percent:{{$commission_percent}} }">

                    <div class="col-lg-6 mt-4">
                        <div class="contact">
                            <h5>@lang('site.calculate_commission')</h5>
                            <p>@lang('site.fill_these_to_calculate_commission')</p>
                                <div class="col-md-12 mb-3">

                                    <label for="add-name" class="form-label">@lang('site.sell_price_in_sar')</label>
                                    <input type="text" class="form-control form-select-11" id="add-name" x-on:input="amount=$el.value"/>

                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="alert alert-warning" x-show="amount<{{config('app.min_ad_price_for_commission')}} && amount > 0">
                                        @lang('site.no_commission')
                                    </div>
                                    <div class="comm  rounded" x-show="amount>={{config('app.min_ad_price_for_commission')}}">
                                        <ul>
                                            <li class="float-start pri-float"><span id="commission-amount" x-text="Math.round((amount*(percent/100))*100)/100">0</span>  @lang('site.sar')</li>
                                            <li><img src="{{asset('images')}}/assets/images/comm.png" alt=""></li>
                                            <li>@lang('site.site_commission')</li>
                                        </ul>
                                    </div>



                                </div>

                                <hr class="seprator">



                            <div class="col-md-12 mt-3" x-show="amount>={{config('app.min_ad_price_for_commission')}}">
                                <div class="d-grid">
                                    <a href="{{route('customer.create_commission')}}" class="btn btn-2">@lang('site.upload_form')</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-2 col-md-1"></div>
                    <div class="col-lg-4 mt-4">
                        <h5 class="simler-add">@lang('site.recent_ads')</h5>
                        <x-recent-ads-sidebar/>
                    </div>

                </div>
            </div>
        </section>
@endsection
