@extends('pages.front.master')
@section('content')
<section class="search">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('site.home')</a></li>
                        <li class="breadcrumb-item"><img src="{{asset('front')}}/assets/images/bread-arrow.png" alt=""></i></li>
                        <li class="breadcrumb-item"><a href="{{route('customer.profile')}}">@lang('site.account')</a></li>
                        <li class="breadcrumb-item"><img src="{{asset('front')}}/assets/images/bread-arrow.png" alt=""></i></li>
                        <li class="breadcrumb-item"><a href="{{route('customer.commission_history')}}">@lang('site.commission_transfer_history')</a></li>
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
            <div class="col-lg-12 mt-4">
                <div class="modal-cards">
                    <div class="card-box-1 bg-card-dark rounded p-3 mb-3">
                        <h6 class="pt-3">
                            <span class="badge @if($record->status=='received') bg-active @endif"> </span>
                            @lang('site.'.$record->status)
                        </h6>

                        <h4 class="">@lang('site.form_number') {{$record->id}}</h4>
                        <ul class="card-box-list">
                            <li><a href="#"><img src="{{asset('front')}}/assets/images/c1.png" alt=""><span>@lang('site.ad_number')</span><p>{{$record->ad_id}}</p></a></li>
                            <li><a href="#"><img src="{{asset('front')}}/assets/images/c2.png" alt=""><span> @lang('site.commission_amount')</span><p class="green-price">{{$record->commission_amount}} @lang('site.sar')</p></a></li>
                            <li><a href="#"><img src="{{asset('front')}}/assets/images/c3.png" alt=""><span> @lang('site.full_name')</span><p>{{$record->full_name}}</p></a></li>
                            <li>
                                <a href="#"><img src="{{asset('front')}}/assets/images/c4.png" alt="">
                                    <span> @lang('site.transfer_model_created_at')</span>
                                    <p>{{$record->created_at->translatedFormat('l j F Y')}}</p>
                                </a>
                            </li>

                        </ul>

                    </div>
                    <div class="card-box-1 bg-card-dark rounded p-3 mb-3">
                        <h5>@lang('site.account_data')</h5>
                        <ul class="card-box-list">
                            <li>
                                <a href="#">
                                    <img src="{{asset('front')}}/assets/images/c5.png" alt="">
                                    <span> @lang('site.transfer_bank_to')</span>
                                    <p>
                                        {{$record->bank->{"title_".app()->getLocale()} }}
                                    </p>
                                </a>
                            </li>
                            <li><a href="#"><img src="{{asset('front')}}/assets/images/c3.png" alt=""><span> @lang('validation.attributes.transfer_name')</span><p>{{$record->transfer_name}}</p></a></li>
                            <li>
                                <a href="#">
                                    <img src="{{asset('front')}}/assets/images/c4.png" alt=""><span>
                                    @lang('site.transfer_date')</span>
                                    <p>{{$record->transfer_date->translatedFormat('l j F Y')}}</p>
                                </a>
                            </li>
                            <li><a href="#"><img src="{{asset('front')}}/assets/images/c6.png" alt=""><span> @lang('validation.attributes.mobile_related_to_your_account')</span><p>{{$record->mobile}}</p></a></li>

                        </ul>

                    </div>
                    <div class="card-box-1 bg-card-dark rounded p-3 mb-3">
                        <ul class="card-box-list mt-0">

                            <li><a href="#"><img src="{{asset('front')}}/assets/images/c7.png" alt=""><span> @lang('site.notes')</span><p>{{$record->notes}}</p></a></li>

                        </ul>

                    </div>
                    <div class="card-box-1 bg-card-dark rounded p-3 mb-3">
                        <h5>@lang('validation.attributes.transfer_receipt')</h5>
                        <ul class="card-box-list">
                            <li>
                                <a href="#">
                                    <img src="{{asset('front')}}/assets/images/c8.png" alt="">
                                    <a href='{{$record->receipt_url}}' target='_blank'>@lang('site.transfer_receipt_image')</a>
                            </a>
                        </li>


                        </ul>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
