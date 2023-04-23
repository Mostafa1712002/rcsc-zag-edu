<div class="acc-tabs border rounded px-3 py-4">
    <div class="acc-name d-flex">
        <div class="acc-name-box ms-2">
            <img src="{{auth('customer')->user()->avatar_url}}" alt="">
        </div>
        <div class="">
            <h6 class="mb-0 mt-2 accc">
                {{
                    mb_strlen(auth('customer')->user()->full_name)>20?
                    mb_substr(auth('customer')->user()->full_name,0,20).'...':
                    auth('customer')->user()->full_name
                }}
            </h6>
            {!! auth('customer')->user()->rating_stars !!}
        </div>
    </div>
    <div class="acc-name-info">
        <ul>
            <li>
                <a href="{{route('customer.profile')}}">
                    <img src="{{asset('front/assets')}}/images/z1.png" alt="" class="ms-2">
                    <span>@lang('site.personal_info')</span>
                    <i class="fas fa-chevron-left float-start"></i>
                </a>
            </li>
            <li>
                <a href="{{route('customer.my_favorites')}}">
                    <img src="{{asset('front/assets')}}/images/z2.png" alt="" class="ms-2">
                    <span>@lang('site.favorite')</span>
                    <i class="fas fa-chevron-left float-start"></i>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="{{asset('front/assets')}}/images/z3.png" alt="" class="ms-2">
                    <span>@lang('site.change_password')</span>
                    <i class="fas fa-chevron-left float-start"></i>
                </a>
            </li>
            <li>
                <a href="{{route('customer.my_ads')}}">
                    <img src="{{asset('front/assets')}}/images/z4.png" alt="" class="ms-2">
                    <span>@lang('site.my_ads')</span>
                    <i class="fas fa-chevron-left float-start"></i>
                </a>
            </li>
            <li>
                <a href="{{route('customer.commission_history')}}"><img src="{{asset('front/assets')}}/images/z5.png" alt="" class="ms-2">
                    <span>@lang('site.commission_transfer_history')</span>
                    <i class="fas fa-chevron-left float-start"></i>
                </a>
            </li>
            <li>
                <a href="{{route('customer.logout')}}">
                    <img src="{{asset('front/assets')}}/images/z6.png" alt="" class="ms-2">
                    <span>@lang('general.logout')</span>
                    <i class="fas fa-chevron-left float-start"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
