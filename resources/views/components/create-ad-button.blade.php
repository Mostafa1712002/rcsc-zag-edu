<a
    class="btn btn-2 mb-4"
    href='{{auth('customer')->user()? route('customer.create_ad') : route('customer.login')}}'>
        <i class="fas fa-plus ps-1"></i>
        @lang('site.create_ad')
</a>
