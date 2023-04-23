@include('pages.front.partials.header')
{{isset($slot)? $slot : ''}}
@yield('content')
@include('pages.front.partials.footer')
