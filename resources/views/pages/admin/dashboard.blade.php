@extends('pages.admin.master')
@section('content')

<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            <a class="info-box-text" href='{{route('admin.user.index')}}'>@lang('site.users')</a>
            <span class="info-box-number">{{$admins_count}} @lang('site.active')</span>
        </div>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            <a class="info-box-text" href='{{route('admin.student.index')}}'>@lang('site.students')</a>
            <span class="info-box-number">{{$students_count}} @lang('site.active')</span>
        </div>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
        <div class="info-box-content">
            <a class="info-box-text" href='{{route('admin.question.index')}}'>@lang('site.questions')</a>
            <span class="info-box-number">{{$questions_count}} @lang('site.active')</span>
        </div>
    </div>
</div>







@endsection

@push('scripts')
  {{-- <script src='{{asset('js/admin/admins/index.js')}}'></script>     --}}
@endpush
