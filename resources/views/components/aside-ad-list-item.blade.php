<div class="col-md-12">
    <div class="search-card-box bg-card-dark mb-3">
        <div class="row">
        <div class="w-75">
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
                <small class="{{$attributes['ad']->status=='active'? 'on' : 'off'}}">
                    @lang('site.'.$attributes['ad']->status)
                </small>
            @endisset


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

            {{-- @if(auth('customer')->user() && auth('customer')->user()->visits()->whereAdId($attributes['ad']->id)->exists())
                <li><img src="{{asset("front/assets")}}/images/visited.png" alt=""><span class="visited"> @lang('site.visited')</span></li>
            @endif --}}

            @if(auth('customer')->user() && auth('customer')->user()->favorites()->whereAdId($attributes['ad']->id)->exists())
                <li><img src="{{asset("front/assets")}}/images/favorit.png" alt=""> <span class="fav-red">@lang('site.i_like')</span></li>
            @endif
        </ul>
        </div>

        <div class="imge-card-top w-25 text-center">

            <img src="{{$attributes['ad']->image_url}}"  style='height:64px;width:64px' alt="">
            <div class=" mt-3 green-label-box">
                <p>{{$attributes['ad']->id}}</p>
                @if($attributes['ad']->price)
                <h6   style='font-size:12px;'>
                    <img src="{{asset("front/assets")}}/images/green-label.png" alt="" class="label-green">
                    {{$attributes['ad']->price}} @lang('site.sar_short')
                </h6>
                @endif
                <div class="clearfix"></div>
            </div>
        </div>
</div>

    </div>

</div>
