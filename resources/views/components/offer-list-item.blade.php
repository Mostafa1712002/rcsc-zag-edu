<div class="col-md-12">
    <div class="search-card-box bg-card-dark mb-3">
        <div class="imge-card-top">
            <div class="float-end ms-3 mt-3 green-label-box">
                <p>{{$attributes['offer']->id}}</p>
            </div>
            <img src="{{$attributes['offer']->pic_url}}" alt="">

    </div>
        <h5>
            <a href="{{route('show_offer',$attributes['offer']->id)}}" title='{{$attributes['offer']->{"title_".app()->getLocale()} }}'>
                {{ mb_strlen($attributes['offer']->{"title_".app()->getLocale()})>50? mb_substr($attributes['offer']->{"title_".app()->getLocale()},0,25).'...' : $attributes['offer']->{"title_".app()->getLocale()} }}
            </a>

            {{-- <span class="departed">
                <a href="{{route('show_offers')}}">
                    @lang('site.offers')
                </a>
            </span> --}}

        </h5>

    </div>

</div>
