
@extends('pages.front.master')
@section('content')
<section class="search">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('site.home')</a></li>
                              <li class="breadcrumb-item"><img src="{{asset('front/assets')}}/images/bread-arrow.png" alt=""></i></li>
                              <li class="breadcrumb-item active" aria-current="page">@lang('general.profile') </li>
                            </ol>
                          </nav>
                    </div>
                    <div class="col-lg-3 col-md-2"> </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="d-grid gap-2">
                            <x-create-ad-button/>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-5 pt-3">
                        <x-profile-sidebar/>
                    </div>
                    <div class="col-lg-9 col-md-7">
                        <form action="{{route('customer.profile')}}" method="POST" enctype="multipart/form-data">
                            @if (session('success_message'))
                                <div class="alert alert-success">
                                    {{session('success_message')}}
                                </div>
                            @endif
                            @csrf
                            <div class="account-edit">
                                <h5 class="simler-add">@lang('site.personal_info')</h5>
                                <div class="edite-box mb-3">
                                    <div class="form-group col-md-3 ">
                                        <label for="picture" class="attachment">
                                        <div class="row btn-file">
                                            <div id='avatar-preview' class="btn-file__preview"></div>
                                            <div class="btn-file__actions">
                                            <div class="btn-file__actions__item col-xs-12 text-center position-relative">
                                                <div class="btn-file__actions__item--shadow ">
                                                    <div class="visible-xs-block"></div>
                                                    <img src="{{auth('customer')->user()->avatar_url}}"/>
                                                    <div class="edit-layer">
                                                        <p>@lang('site.edit')</p>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <input name="picture" type="file" id="picture">
                                        @error('picture')
                                            <p class="text-danger">{{$errors->first('picture')}}</p>
                                        @enderror
                                        </label>
                                    </div>
                                </div>
                                <div class="evaluat-box bg-card-dark rounded mb-3">
                                    <span>@lang('site.join_date')</span>
                                    <span class="float-start">{{auth('customer')->user()->created_at }}</span>
                                </div>
                                <div class="evaluat-box bg-card-dark rounded mb-3">
                                    <span>@lang('site.rating')</span>
                                    {!! auth('customer')->user()->rating_stars !!}
                                </div>
                                <form action="" class="contac-form row contac-form-2">

                                    <div class="col-md-12 mb-3">
                                        <input value='{{auth('customer')->user()->first_name}}' type="text" class="form-control form-select-11 form-select-transpernt @error('first_name') is-invalid @enderror" id="add-fname" name='first_name' placeholder="@lang('validation.attributes.full_name')">
                                        @error('first_name')
                                            <p style='color:red'>{{$message}}</p>
                                        @enderror
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text-2" id="basic-addon1">+966</span>
                                            <input name='mobile' value='{{auth('customer')->user()->mobile}}' type="text" class="form-control form-select-11 @error('mobile') is-invalid @enderror form-select-transpernt" id="add-phone" placeholder="@lang('validation.attributes.mobile_number')">
                                        </div>
                                        @error('mobile')<p style='color:red'>{{$message}}</p>@enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <input name='email' value='{{auth('customer')->user()->email}}' class="form-control @error('email') is-invalid @enderror form-select-11 form-select-transpernt" id="uEmail" placeholder="@lang('validation.attributes.email')">
                                        @error('email')<p style='color:red'>{{$message}}</p>@enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <button id='save-profile-btn' type="submit" class="btn btn-2 float-start px-5">@lang('site.save')</button>
                                    </div>


                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
@endsection
@push('scripts')
    <script>
        // $(document).ready(function(){
        //     $('[name=picture]').change(function(e){
        //         const fileSize = document.getElementById('picture').files[0].size / 1024 / 1024;
        //         if (fileSize > 10) {
        //             $('')
        //             $('#avatar-preview').css('background-image','');

        //         }
        //     });
        // });
    </script>
@endpush
