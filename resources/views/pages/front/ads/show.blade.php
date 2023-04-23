@php
    $ad_title = $record->title_ar;
    $whatsapp_meta = "
        <meta content='".$ad_title."' property='og:title'/>
        <meta content='".$ad_title."' property='og:description'/>
        <meta property='og:image' content='".$record->image_url."'/>
        <meta property='og:url' content='".route('show_ad',$record->id)."'/>
    ";
@endphp

@extends('pages.front.master')
@section('content')

<section class="search">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9">
                <div class="row">
                    <nav class='col-md-8' style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><img src="{{asset('front/assets')}}/images/bread-arrow.png" alt=""></i></li>
                            <li class="breadcrumb-item">
                                <a href="{{route('show_department',$record->department_id)}}">
                                    {{$record->department->{"title_".app()->getLocale()} }}
                                </a>
                            </li>
                            <li class="breadcrumb-item"><img src="{{asset('front/assets')}}/images/bread-arrow.png" alt=""></i></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$page_title}}</li>
                        </ol>
                    </nav>
                    <div class="col-md-3 ad-view-btn">
                        <ul class="float-start" style='display:flex;'>
                            @if(auth('customer')->id() == $record->customer_id)
                                @if($record->status=='active')
                                    <li style='margin:2px;'>
                                        <a href="{{route('customer.renew_ad',$record->id)}}" class="show-ad-btn renew-btn btn btn-outline-success">
                                            @lang('site.renew_ad')
                                        </a>
                                    </li>
                                @endif

                                @if($record->deleted_at==null)
                                    <li style='margin:2px;'>
                                        <a href="{{route('customer.edit_ad',$record->id)}}" class="show-ad-btn btn btn-outline-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </li>
                                    <li style='margin:2px;' x-data="{show_delete_form:@if($errors->has('delete_reason')) true @else false @endif }">
                                        <a data-bs-toggle="modal" data-bs-target="#deleteModal" href="#" class="show-ad-btn btn btn-outline-danger">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>

                                    </li>
                                @endif
                            @endif
                        </ul>
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

                    @if(session('success_message'))
                        <div class="alert alert-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                            {{session('success_message')}}
                        </div>
                    @endif

                    @if(session('error_message'))
                        <div class="alert alert-danger" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                            {{session('error_message')}}
                        </div>
                    @endif

                    <div class="search-card-box p-0">
                        <div class="head-add-info">
                            <p style="margin:0px;color:gray;">@lang('site.ad_number') {{$record->id}}</p>
                            <p style="margin:0px;color:gray">{{$record->created_at->diffForHumans()}}</p>
                        </div>
                        <h5>{{$page_title}}</h5>
                        <ul class="mt-3">
                            {{-- <li>
                                <span class="departed">
                                <a href="{{route('show_department',$record->department_id)}}">
                                    {{$record->department->{"title_".app()->getLocale()} }}
                                </a>
                                </span>
                            </li>
                            <li>
                                <span class="departed">
                                <a href="{{route('show_category',$record->parent_category_id)}}">
                                    {{$record->parentCategory->{"title_".app()->getLocale()} }}
                                </a>
                                </span>
                            </li>
                            <li>
                                <span class="departed">
                                    <a href="{{route('show_category',$record->sub_category_id)}}">
                                        {{$record->subCategory->{"title_".app()->getLocale()} }}
                                    </a>
                                </span>
                            </li> --}}


                        </ul>
                        <ul class="pb-3 mt-3">
                            <li><img src="{{asset('front/assets')}}/images/person-icon.png" alt=""><span>
                                <a href="{{route('show_customer',$record->customer_id)}}" style='word-break:break-all;'>
                                    {{$record->customer->full_name}}
                                </a>
                            </span></li>
                            @if($record->ad_type)
                                <li><img src="{{asset('front/assets')}}/images/dark-label.png" alt=""><span>@lang('validation.attributes.ad_type') : @lang('site.'.$record->ad_type)</span></li>
                            @endif
                            <li><img src="{{asset('front/assets')}}/images/location.png" alt=""><span>{{optional($record->city)->{"name_".app()->getLocale()} }}</span></li>
                            @if(!is_null($record->admodel_id))
                                <li><img src="{{asset('front/assets')}}/images/sm-car.png" alt=""><span>@lang('site.admodel') : {{$record->admodel->{"title_".app()->getLocale()} }}</span></li>
                            @endif
                        </ul>
                    </div>
                    <div class="advertise-details">
                        <h6>@lang('site.ad_details')</h6>

                        @if($record->is_cars_ad || $record->department_id==config('app.trucks_department_id'))
                            <p> - @lang('validation.attributes.is_double'): {{$record->is_double? __('site.yes') : __('site.no')}}</p>
                            <p> - @lang('validation.attributes.gear_type'): @lang('site.'.$record->gear_type)</p>
                            <p> - @lang('validation.attributes.fuel_type'): @lang('site.'.$record->fuel_type)</p>
                            <p> - {{__($record->is_cars_ad? 'general.car_status': 'general.truck_status')}}: @lang('general.'.$record->ad_status)</p>
                        @endif

                        @if($record->department_id==config('app.hardWare_department_id'))
                            <p> - @lang('general.device_status'): @lang('general.'.$record->ad_status)</p>
                        @endif

                        @if($record->department_id==config('app.real_steal_department_id'))
                            <p> - @lang('general.district'): {{$record->district}}</p>
{{--                            <p> - @lang('validation.attributes.is_guaranteed'): {{$record->is_guaranteed? __('site.yes') : __('site.no')}}</p>--}}
{{--                            <p> - @lang('validation.attributes.factory_year'): {{$record->factory_year}}</p>--}}
                        @endif

                        <hr>

                        @if($record->price)
                            <h4 class="green-label">
                                <img src="{{asset('front/assets')}}/images/green-label.png" alt="">
                                {{$record->price}} @lang('site.sar')
                            </h4>
                        @endif

                        <p>{!! nl2br($record->{"content_".app()->getLocale()}) !!}</p>

                        @if($record->pics)
                            <h6 class="my-3">@lang('site.ad_pics')</h6>
                            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @foreach($record->pics as $k=>$pic)
                                        <button
                                            type="button"
                                            data-bs-target="#carouselExampleCaptions"
                                            data-bs-slide-to="{{$loop->index}}"
                                            class="@if($loop->first) active @endif"
                                            aria-current="true"
                                            aria-label="@lang('general.picture') {{$loop->index}}">
                                        </button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner">
                                    @foreach($record->pics as $k=>$pic)
                                        <div class="carousel-item @if($loop->first) active @endif">
                                            <div class="car-banner">
                                                <img
                                                    onclick="$('#ad-pic-{{$loop->index}}').trigger('click');"
                                                    src="{{ url('uploads/pics/'.$pic)}}"
                                                    data-image="{{'#ad-image_'.($loop->index+1)}}"
                                                    class="d-block w-100 adImagePopUp" data-bs-toggle="modal" data-bs-target="#imagePopUp"/>
                                            </div>

                                            <div class="carousel-caption d-none d-md-block">
                                                {{-- <img src="{{ url('uploads/pics/'.$pic)}}" alt=""> --}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">@lang('site.previous')</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">@lang('site.next')</span>
                                </button>
                            </div>

                        @endif

{{--                        <x-commission-agreement :ad="$record"/>--}}

                            @if($record->show_mobile)
                                <h6 class="mt-5">@lang('site.for_contact')</h6>
                                <a href="tel://+966{{$record->mobile_number}}" class="btn btn-5"><img src="{{asset('front/assets')}}/images/call.png" alt=""> {{$record->mobile_number}} </a>
                            @endif
                            @if ($next_ad = $record->next_ad)
                                <a href="{{route('show_ad',$next_ad->id)}}" class="float-start next">
                                    @lang('site.next_ad')
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                    </div>
                </div>

                <div class="badge-filter">

                        @if(auth('customer')->id() == $record->customer_id)
                            <ul class="social-2 social-22 social-33">
                                <li class="float-start">
                                    <a href="#" class="eyedark">
                                        <img src="{{asset('front')}}/assets/images/A1.png" alt="">
                                    </a>
                                </li>
                                <li class="like">
                                    <a href="#" class="btn btn-outline-success d-flex mb-1">
                                        <i class="bi bi-hand-thumbs-up"></i>
                                        <p class="mb-0">{{$likes_count}}</p>
                                    </a>
                                </li>
                                <li class="dislike">
                                    <a href="#" class="btn btn-outline-danger d-flex mb-1">
                                        <i class="bi bi-hand-thumbs-down"></i>
                                        <p class="mb-0">{{$dislikes_count}}</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="eyedark">
                                        <img src="{{asset('front')}}/assets/images/eye.png" alt="">
                                        <span>{{$record->views_count}}</span>
                                    </a>
                                </li>
                            </ul>
                        @else
                            <ul class="social-1 float-start">

                                @if($record->show_mobile)
                                    <li>
                                        <a href="https://api.WhatsApp.com/send?phone=966{{$record->mobile_number}} &text=محتوي الرساله">
                                            <img src="{{asset('front/assets')}}/images/A4.png" style='width:25px;'>
                                        </a>
                                    </li>
                                @endif

                                @auth('customer')
                                    <li>@livewire('favorite-button',['ad'=>$record])</li>
                                @endauth

                                <li><a data-bs-toggle="modal" data-bs-target="#shareModal" href="#"><img src="{{asset('front/assets')}}/images/A1.png" alt=""></a></li>
                                @auth('customer')
                                    @if(auth('customer')->id() != $record->customer_id)
                                    <li>
                                        {{-- <a href="mailto:?subject={{urlencode($record->{"title_".app()->getLocale()} . "\n" .route('show_ad',$record->id)) }}"> --}}
                                        <a class="btn_warning" href='{{route('customer.chat_index')}}?customer_id={{$record->customer_id}}'>
                                            <i class="bi bi-chat-dots-fill"></i>
                                        </a>
                                    </li>
                                    @endif
                                @endauth


                                @auth('customer')
                                    <li>
                                        <a class="report btn btn-light" data-bs-toggle="modal" data-bs-target="#abuseModal">
                                            <i class="bi bi-flag-fill"></i>
                                            @lang('site.report')
                                        </a>
                                    </li>
                                @endauth

                            </ul>

                            <ul class="social-2" style='display:flex;justify-content:end'>
                                @auth('customer')
                                    <livewire:like-button :ad="$record">
                                @endauth
                                <li><a href="#"><img src="{{asset('front/assets')}}/images/eye.png" alt=""> {{$record->views_count}}</a></li>
                                @auth('customer')
                                    <li>
                                        @livewire(
                                        'follow-button',[
                                            'followable_id'=>$record->id,
                                            'followable_type'=>$followable_type,
                                            'can_follow'=>$can_follow,
                                            'is_following'=>$is_following
                                        ])
                                    </li>
                                @endauth
                            </ul>
                        @endif


                </div>
                <div class="comment-box pt-5">
                    @livewire('ad-comments', ['ad' => $record])
                    {{-- <div class="clearfix"></div> --}}
                    <div class="mb-3"><x-warning-ad-footer/></div>
                </div>
            </div>

            <!-- Recent ads -->
            <div class="col-lg-4 mt-4">
                <h5 class="simler-add">@lang('site.similar_ads')</h5>
                <x-recent-ads-sidebar :ad="$record->id"/>

            </div><!-- Recent ads-->

        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="abuseModal" tabindex="-1" aria-labelledby="abuseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

        <div class="modal-body">
            <div class="report-box p-5 text-center">
            <img src="{{asset('front/assets')}}/images/report.png" alt="" class="mb-3">
            <h4>@lang('site.report_ad')</h4>
            <p>@lang('site.please_enter_reason_to_report_that_ad')</p>

            {!! spark_alerts('abuse')!!}

            <form action="" class="mt-4">
                <textarea class="form-control mb-3" name='abuse-content' rows="5" placeholder="@lang('site.write_report_text_here')"></textarea>
                <span style='color:red;display:none' class='invalid-feedback' id='abuse-error'></span>
                <div class="d-grid">
                    <button type="button" id='send-abuse-btn' class="btn btn-2 px-4"> @lang('site.agree') </button>
                </div>
            </form>
            </div>
        </div>

        </div>
    </div>
</div>




 <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('site.delete_ad')</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          {!! spark_alerts('delete-ad')!!}
            <textarea name="delete_reason" rows="5" class="form-control" placeholder='@lang('site.enter_delete_reason')'></textarea>
            <span id="delete-error" class="invalid-feedback" style='color:red'></span>
        </form>
      </div>
      <div class="modal-footer">
        <button type='button' id='delete-ad-btn' class="btn btn-sm btn-danger">@lang('site.delete')</button>
      </div>
    </div>
  </div>
</div>


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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@if($record->pics)

<div class="modal fade adResultPopup" id="imagePopUp" tabindex="-1" aria-labelledby="imagePopUpLabel" aria-hidden="true">
    <i class="btn-close" data-bs-dismiss="modal" aria-label="Close"></i>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content w-100">
            <div class="modal-body w-100">
                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($record->pics as $k=>$pic)
                            <div id="ad-image_{{$loop->index+1}}" class="carousel-item">
                                <img id="image" src="{{ url('uploads/pics/'.$pic) }}" class="d-block w-100" alt="{{$pic}}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
{{--                <img id="adResultPopup" src="" alt="">--}}
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')

<script>

    $('.adImagePopUp').on('click', function (){
        let imgId = $(this).data('image'),
            src   = $(this).attr('src'),
            img   = $(imgId);

        img.attr('src', src);
        img.addClass('active').siblings().removeClass('active');

    });

    $(document).ready(()=>{
        @auth('customer')
            $('#send-abuse-btn').click(e=>{
                e.preventDefault();
                let that = $(this);

                $.ajax({
                    url:"{{route('customer.store_abuse',$record->id)}}",
                    dataType:'JSON',
                    type:'POST',
                    data:{
                        content:$('[name=abuse-content]').val()
                    },
                    success:function(res){
                        that.fadeOut();
                            $('#abuse-alert-ok').find('span').text(res.message);
                            $('#abuse-alert-ok').fadeIn();
                            setTimeout(()=>{
                                $('#abuse-alert-ok').fadeOut();
                                $('#abuseModal').modal('hide');
                            },2500);
                    },
                    error(res){
                        if(res.status==422){
                            $('#abuse-error').show().text(res.responseJSON.errors.content[0]);
                        }else if(res.status == 400){
                            $('#abuse-alert-error').find('span').text(res.responseJSON.message);
                            $('#abuse-alert-error').fadeIn();
                            setTimeout(()=>{
                                $('#abuse-alert-error').fadeOut();
                            },2500);
                        }
                    }
                });
            });


            $('#delete-ad-btn').click(e=>{
                e.preventDefault();
                let that = $(this);

                $.ajax({
                    url:"{{route('customer.delete_ad',$record->id)}}",
                    dataType:'JSON',
                    type:'DELETE',
                    data:{
                        delete_reason:$('[name=delete_reason]').val()
                    },
                    success:function(res){
                        that.fadeOut();
                            $('#delete-ad-alert-ok').find('span').text(res.message);
                            $('#delete-ad-alert-ok').fadeIn();
                            setTimeout(()=>{
                                $('#delete-ad-alert-ok').fadeOut();
                                window.location.href= '{{route('customer.my_ads')}}';
                            },2500);
                    },
                    error(res){
                        if(res.status==422){
                            $('#delete-error').show().text(res.responseJSON.errors.delete_reason[0]);
                        }else if(res.status == 400){
                            $('#delete-ad-alert-error').find('span').text(res.responseJSON.message);
                            $('#delete-ad-alert-error').fadeIn();
                            setTimeout(()=>{
                                $('#delete-ad-alert-error').fadeOut();
                            },2500);
                        }
                    }
                });
            });

        @endauth
    });

</script>

@endpush

