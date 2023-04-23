@include('pages.admin.includes.header')
{{isset($slot)? $slot : ''}}
@yield('content')
@include('pages.admin.includes.footer')
@include('pages.admin.includes.edit-record-modal')
@include('pages.admin.includes.general-modal')
