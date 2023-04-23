@extends('pages.front.master')
@section('content')
    <!-- start main -->
        <section class="sign-in">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <p class="sign-head"><i class="fas fa-arrow-right"></i>@lang('site.forget_password')</p>
                        <div class="sign-card bg-card-dark p-5 rounded">
                             <form class="l-custom" method="POST" action="{{route('customer.request_forget_password_code')}}">
                                @csrf
                                @if (session('error_message'))
                                    <div class="alert alert-danger">
                                        {{session('error_message')}}
                                    </div>
                                @endif






                                <label for="phoneNumber" class="form-label float-end">@lang('validation.attributes.mobile_number')</label>

                                <div class="input-group mb-3">
                                    <input type="text" name='mobile' class="form-control form-control-3" id="phoneNumber" aria-describedby="basic-addon1"/>
                                    <span class="input-group-text input-group-text-2" id="basic-addon1">+966</span>

                                    @error('mobile')
                                            <p style='color:red'>{{$errors->first('mobile')}}</p>
                                    @enderror

                                  </div>
                                 <div class="d-grid gap-2">
                                    <button type="submit" id='proceed-btn' class="btn btn-2 px-5">@lang('site.proceed')</button>
                                </div>


                              </form>

                        </div>


                    </div>
                </div>
            </div>
        </section>

@endsection

