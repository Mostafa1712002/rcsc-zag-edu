<div
    class="col-md-12"
    onclick="window.location.href='{{route('show_ad',$attributes['ad']->id)}}';"
    onmouseover="" style="cursor: pointer;"
>
    <div class="search-card-box bg-card-dark mb-3">
        <div class="imge-card-top">
            <div class="float-end ms-3 mt-3 green-label-box">
                <p>@lang('site.ad_number') {{$attributes['ad']->id}}</p>
                @if($attributes['ad']->price)
                <h6>
                    <img src="{{asset("front/assets")}}/images/green-label.png" alt="" class="label-green">
                    {{$attributes['ad']->price}} @lang('site.sar')
                </h6>
                @endif
            </div>
            <img src="{{$attributes['ad']->image_url}}" alt="">

    </div>
        <h5>
            <a
                @if(auth('customer')->user() && $attributes['ad']->visits_count)
                    style='color:RGB(102,79,194)'
                @endif
                href="{{route('show_ad',$attributes['ad']->id)}}" title='{{$attributes['ad']->{"title_".app()->getLocale()} }}'>
                {{ mb_strlen($attributes['ad']->{"title_".app()->getLocale()})>50? mb_substr($attributes['ad']->{"title_".app()->getLocale()},0,25).'...' : $attributes['ad']->{"title_".app()->getLocale()} }}
            </a>
            @if($attributes['ad']->ad_type)
                <small>(@lang('site.'.$attributes['ad']->ad_type))</small>
            @endif

            @isset($attributes['my_ads'])
                <small class="{{$attributes['ad']->status=='active' && is_null($attributes['ad']->deleted_at)? 'on' : 'off'}}">
                    @if ($attributes['ad']->deleted_at)
                        @lang('site.deleted')
                    @else
                        @lang('site.'.$attributes['ad']->status)
                    @endif
                </small>
            @endisset
            {{-- <span class="departed">
                <a href="{{route('show_department',$attributes['ad']->department_id)}}" title="{{$attributes['ad']->department->{"title_".app()->getLocale()} }}">
                    {{
                        mb_strlen($attributes['ad']->department->{"title_".app()->getLocale()})>25?
                            mb_substr($attributes['ad']->department->{"title_".app()->getLocale()},0,25).'...' :
                            $attributes['ad']->department->{"title_".app()->getLocale()}
                    }}
                </a>
            </span> --}}

        </h5>
        <ul>
            <li>
                <a href="{{route('show_customer',$attributes['ad']->customer_id)}}"  title="{{$attributes['ad']->customer->full_name}}">
                    <img src="{{asset("front/assets")}}/images/person-icon.png" alt="">
                    <span>
                        {{
                            mb_strlen($attributes['ad']->customer->full_name)>25?
                            mb_substr($attributes['ad']->customer->full_name,0,25).'...' :
                            $attributes['ad']->customer->full_name
                        }}
                    </span>
                </a>
            </li>
            <li><img src="{{asset("front/assets")}}/images/location.png" alt=""><span>{{optional($attributes['ad']->city)->{"name_".app()->getLocale()} }}</span></li>
            <li><img src="{{asset("front/assets")}}/images/time-icon.png" alt=""><span>{{($attributes['ad']->created_at)->diffForHumans()}}</span></li>
                <li><img src="{{asset("front/assets")}}/images/eye-dark.png" alt=""><span> {{$attributes['ad']->visits_sum_visits?? 0 }}</span></li>

            {{-- @if(auth('customer')->user() && $attributes['ad']->visits_count)
                <li><img src="{{asset("front/assets")}}/images/visited.png" alt=""><span class="visited"> @lang('site.visited')</span></li>
            @endif --}}

            @if(auth('customer')->user() && auth('customer')->user()->favorites()->whereAdId($attributes['ad']->id)->exists())
                <li><img src="{{asset("front/assets")}}/images/favorit.png" alt=""> <span class="fav-red">@lang('site.i_like')</span></li>
            @endif



        </ul>
    </div>

</div>
