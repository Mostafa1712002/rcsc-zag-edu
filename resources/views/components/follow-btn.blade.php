@if($attributes['can_follow'])
    <a
        href="#"
        class="btn btn-{{($attributes['is_following'])? 1 : 2}} btn-20 follow-btn"
        data-followable-id="{{$attributes['followable_id']}}"
        data-followable-type="{{$attributes['followable_type']}}"
    >
        <img src="{{asset('front/assets')}}/images/wifi.png">
        {{$attributes['is_following']? __('site.unfollow') : __('site.follow')}}
    </a>

@endif
