<div
    class="col-md-4 mb-4"
    onclick="window.location.href='{{route('show_ad',$attributes['ad']->id)}}';"
    onmouseover="" style="cursor: pointer;"
    >
    <div class="car-card-box bg-card-dark p-2 rounded">
        <div class="car-card-img">
            <img src="{{$attributes['ad']->image_url}}" style='width:354px;height:168px;'>
            <div class="car-box-layer">
                <ul>
                    @if($attributes['ad']->price)
                    <li class="float-start">
                        <img src="{{asset("front/assets")}}/images/white-label.png" alt="" class="white-label">{{$ad->price}} @lang('site.sar')
                    </li>
                    @endif
                    <li class="pt-1">{{$attributes['ad']->id}}</li>
                </ul>
            </div>
        </div>
        <div class="p-2 mt-2">
            <h5 class="productName">
                    <a
                    @if(auth('customer')->user() && $attributes['ad']->visits_count)
                        style='color:RGB(102,79,194)'
                    @endif
                    href="{{route('show_ad',$attributes['ad']->id)}}"  title='{{$attributes['ad']->{"title_".app()->getLocale()} }}'>
                        {{ mb_strlen($attributes['ad']->{"title_".app()->getLocale()})>50? mb_substr($attributes['ad']->{"title_".app()->getLocale()},0,50).'...' : $attributes['ad']->{"title_".app()->getLocale()} }}

                        @if($attributes['ad']->ad_type)
                            <small>(@lang('site.'.$attributes['ad']->ad_type))</small>
                        @endif

                        @isset($attributes['my_ads'])
                            <small class="{{$attributes['ad']->status=='active'? 'on' : 'off'}}">
                                @lang('site.'.$attributes['ad']->status)
                            </small>
                        @endisset

                    </a>
                    {{-- <span class="departed float-start">
                        <a href="{{route('show_department',$attributes['ad']->department_id)}}" title="{{$attributes['ad']->department->{"title_".app()->getLocale()} }}">
                            {{
                                mb_strlen($attributes['ad']->department->{"title_".app()->getLocale()})>25?
                                    mb_substr($attributes['ad']->department->{"title_".app()->getLocale()},0,25).'...' :
                                    $attributes['ad']->department->{"title_".app()->getLocale()}
                            }}
                        </a>
                    </span> --}}

            </h5>
            <div class="card-box-info">
                <p>
                    <a href="{{route('show_customer',$attributes['ad']->customer_id)}}" title="{{$attributes['ad']->customer->full_name}}">
                        <img src="{{asset("front/assets")}}/images/person-icon.png" alt="">
                        <span>
                            {{
                                mb_strlen($attributes['ad']->customer->full_name)>25?
                                    mb_substr($attributes['ad']->customer->full_name,0,25).'...' :
                                    $attributes['ad']->customer->full_name
                            }}
                        </span>
                    </a>
                </p>
                <p><img src="{{asset("front/assets")}}/images/location.png" alt=""><span> {{optional($attributes['ad']->city)->{"name_".app()->getLocale()} }} </span></p>
                <p><img src="{{asset("front/assets")}}/images/eye-dark.png" alt=""><span> {{$attributes['ad']->views_count}}</span></p>
                <p><img src="{{asset("front/assets")}}/images/time-icon.png" alt=""><span> {{$attributes['ad']->created_at->diffForHumans()}}</span></p>
                {{-- @if(auth('customer')->user() && $attributes['ad']->visits_count)
                   <p><img src="{{asset("front/assets")}}/images/visited.png" alt=""><span class="visited"> @lang('site.visited')</span></p>
                @endif --}}

                @if(auth('customer')->user() && auth('customer')->user()->favorites()->whereAdId($attributes['ad']->id)->exists())
                    <p><img src="{{asset("front/assets")}}/images/favorit.png" alt=""> <span class="fav-red">@lang('site.i_like')</span></p>
                @endif
            </div>

        </div>
    </div>
</div>
