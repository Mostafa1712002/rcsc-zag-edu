<div class="col-md-4 mb-4">
    <div class="car-card-box bg-card-dark p-2 rounded">
        <div class="car-card-img">
            <img src="{{$attributes['offer']->pic_url}}" style='width:354px;height:168px;'>
            <div class="car-box-layer">
                <ul>
                    <li class="pt-1">{{$attributes['offer']->id}}</li>
                </ul>
            </div>
        </div>
        <div class="p-2 mt-2">
            <h5 class="productName">
                    <a href="{{route('show_offer',$attributes['offer']->id)}}"  title='{{$attributes['offer']->{"title_".app()->getLocale()} }}'>
                        {{ mb_strlen($attributes['offer']->{"title_".app()->getLocale()})>50? mb_substr($attributes['offer']->{"title_".app()->getLocale()},0,50).'...' : $attributes['offer']->{"title_".app()->getLocale()} }}
                    </a>
                    <span class="departed float-start">
                        <a href="{{route('show_offers')}}">
                            @lang('site.offers')
                        </a>
                    </span>

            </h5>
            <div class="card-box-info">

            </div>

        </div>
    </div>
</div>
