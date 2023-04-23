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

                </div>
{{--            <div class="col-lg-4 mt-4">--}}
{{--                <h5 class="simler-add">@lang('site.recent_ads')</h5>--}}
{{--                <x-recent-ads-sidebar/>--}}
{{--            </div>--}}

        </div>
    </div>
</section>
@endsection
