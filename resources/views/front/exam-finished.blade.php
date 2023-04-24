@extends('pages.front.master')
@section('content')
<section x-data class="sign-in d-flex" style='min-height:500px;'>
    <div class="container my-auto">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="alert alert-success">
                    @lang('site.exam_finished_message')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
