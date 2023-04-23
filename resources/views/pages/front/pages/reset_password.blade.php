@extends('pages.front.master')
@section('content')
    <!-- start main -->
        <section class="sign-in">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <p class="sign-head"><i class="fas fa-arrow-right"></i>@lang('site.forget_password')</p>
                        <div class="sign-card bg-card-dark p-5 rounded">
                             <form class="l-custom" method="POST" action="{{route('customer.save_reset_password')}}">
                                @csrf
                                @if (session('error_message'))
                                    <div class="alert alert-danger">
                                        {{session('error_message')}}
                                    </div>
                                @endif
                                 @if (session('success_message'))
                                    <div class="alert alert-success">
                                        {{session('success_message')}}
                                    </div>
                                @endif

                                <div class="mb-2">
                                    <label for="password-field" class="form-label float-end">@lang('validation.attributes.new_password') </label>
                                    <div class="form-group">
                                        <input id="password-field" type="password" class="form-control form-control-3 @error('password') is-invalid @enderror" name="password"/>
                                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                    @if($errors->has('password'))
                                        <p class="text-danger">{{$errors->first('password')}}</p>
                                    @endif
                                </div>

                                <div class="mb-2">
                                    <label for="password-field0" class="form-label float-end">@lang('validation.attributes.new_password_confirmation') </label>
                                    <div class="form-group">
                                        <input id="password-field0" type="password" class="form-control form-control-3 @error('password_confirmation') is-invalid @enderror" name="password_confirmation"/>
                                        <span toggle="#password-field0" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                    @if($errors->has('password_confirmation'))
                                        <p class="text-danger">{{$errors->first('password_confirmation')}}</p>
                                    @endif
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

