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
                                <li class="breadcrumb-item"><img src="{{asset('front/assets')}}/images/bread-arrow.png" alt=""></i></li>
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

                    <div class="col-lg-8 mt-4">
                        <div class="notif-card">
                            <h5 class="simler-add">{{$page_title}}</h5>
                            @foreach($notifications as $n)

                                <div class="comment-box mb-3"
                                    onclick="window.location.href='{{spark_getNotificationLink($n['data']['event_type'],$n['data']['subject_id'],$n->id)}}';"
                                    onmouseover="" style="cursor: pointer;"
                                >
                                    <h6><span class="day">{{$n->created_at}}</span></h6>
                                    <div class="comment-card border-active p-3 mb-3 rounded">
                                        <h6 class="float-start pt-3"><span class="badge @if(is_null($n->read_at)) bg-active @endif"> </span></h6>
                                        <div class="comment comment-2">
                                            <img style='width:50px;height:50px;' src="{{$n['data']['image']}}" alt="" class="float-end">
                                            <div class="pe-5">
                                                <h4>
                                                    <a href="{{spark_getNotificationLink($n['data']['event_type'],$n['data']['subject_id'],$n->id)}}">
                                                        {{$n['data']["content_".app()->getLocale()] }}
                                                    </a>
                                                </h4>
                                                <h3>{{$n['data']["subject"]["title_".app()->getLocale()] }}</h3>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                        {{$notifications->links()}}
                    </div>
                    <div class="col-lg-4 mt-4">
                        <h5 class="simler-add">@lang('site.recent_ads')</h5>
                        <x-recent-ads-sidebar/>
                    </div>

                </div>
            </div>
        </section>
@endsection
