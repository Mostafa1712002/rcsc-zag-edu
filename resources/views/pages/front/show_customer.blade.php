@extends('pages.front.master')
@section('content')
<section class="search">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('site.home')</a></li>
                              <li class="breadcrumb-item"><img src="{{asset('front')}}/assets/images/bread-arrow.png" alt=""></i></li>
                              <li class="breadcrumb-item active">
                                  <a href="#" title='{{$page_title}}'>
                                      {{ mb_strlen($page_title)>50? mb_substr($page_title,0,50).'...' : $page_title }}
                                  </a>

                               </li>
                            </ol>
                          </nav>
                    </div>

                    <div class="col-lg-8">
                        <div class="profile-card p-3 bg-card-dark rounded">
                            <div class="profile-card-info row mb-3">
                                <div class="col-lg-7">
                                    <div class="d-flex">
                                        <div class="pro-img-box">
                                            <img src="{{$customer->avatar_url}}" alt="" class="pro-img">
                                        </div>
                                        <div class="text-center pro-img-box-text mt-3">
                                            <h3 title='{{$page_title}}' style='font-size:1.4rem'>
                                                {{ mb_strlen($page_title)>25? mb_substr($page_title,0,25).'...' : $page_title }}
                                            </h3>
                                            {{-- <p>@Ahmedsleman</p> --}}
                                            <h5>
                                                <span class="departed departed-5" style='font-size:14px;'>
                                                    <img src="{{asset('front')}}/assets/images/sm-calender.png" alt="">
                                                    @lang('site.joined_since') {{$customer->created_at->format('Y-m-d')}}
                                                </span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="cancel-follow float-start pt-4 ps-2">
                                        <div class="rating" style="display: flex;">
                                            {!! $customer->rating_stars !!}
                                            @if($can_rate)
                                                <a data-bs-toggle="modal" data-bs-target="#rating-modal">@lang('site.rate_user')</a>
                                            @endif
                                        </div>
                                        <ul class="mt-4">
                                            <li>
                                                <a data-bs-toggle="modal" data-bs-target="#shareModal" class="btn btn-13">
                                                    <img src='{{asset('front/assets')}}/images/A1.png' alt="">
                                                </a>
                                            </li>
                                            @if(auth('customer')->id() && auth('customer')->id() != $customer->id)
                                                <li>
                                                    <a href="{{route('customer.chat_index')}}?customer_id={{$customer->id}}" class="btn btn-13">
                                                        <img src="{{asset('front')}}/assets/images/hh-chat.png" alt="">
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                @livewire(
                                                'follow-button',[
                                                    'followable_id'=>$customer->id,
                                                    'followable_type'=>$followable_type,
                                                    'can_follow'=>$can_follow,
                                                    'is_following'=>$is_following
                                                ])
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-advertis">
                                <h5 class="simler-add">@lang('site.ads')</h5>
                                @if(!count($ads))
                                    <div class="alert alert-warning">
                                        @lang('site.no_ads_available')
                                    </div>
                                @else
                                    @foreach($ads as $ad)
                                        <x-ad-list-item :ad="$ad"/>
                                    @endforeach
                                    {{$ads->withQueryString()->links()}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-4">
                        <h5 class="simler-add">@lang('site.recent_ads')</h5>
                       <x-recent-ads-sidebar/>
                    </div>
                </div>

            </div>
        </section>


        @if(auth('customer')->id() )
            <div
                x-data="{show_alert:false}"
                x-on:hide-modal.window="
                    show_alert=true;
                    setTimeout(()=>{
                        $($el).modal('hide');
                        window.location.reload();
                    },2000);"
                    class="modal fade" id="rating-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">

                        <div class="modal-body">

                            <div class="report-box p-5 text-center">
                                <h4>@lang('site.rate_user')</h4>
                                <p>@lang('site.rate_user_accoring_to_your_last_interactions_with_him')</p>
                                <div class="alert alert-success" x-show="show_alert">@lang('site.rated_successfully')</div>
                                <div class="mt-4">
                                    <livewire:rate-customer :customer='$customer'>
                                        {{-- @livewire('rate-customer',compact('customer')) --}}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif


         <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                <div class="modal-body">
                    <div class="text-center">
                        <div class="sharethis-inline-share-buttons"></div>
                    </div>

                </div>

                </div>
            </div>
        </div>
@endsection
