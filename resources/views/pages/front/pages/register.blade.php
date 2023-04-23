@extends('pages.front.master')
@section('content')
<section class="sign-in">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <p class="sign-head"><i class="fas fa-arrow-right"></i>@lang('site.register')</p>
                        <div class="sign-card bg-card-dark p-5 rounded">
                            <form class="l-custom" action='{{route('customer.register')}}' method='post'>
                                @csrf
                                <div class="mb-2">
                                    <label for="Fname" class="form-label float-end">@lang('site.full_name')</label>
                                    <input type="text" value="{{old('first_name')}}" class="form-control form-control-3  @error('first_name') is-invalid @enderror" name='first_name'/>
                                    @if($errors->has('first_name'))
                                        <p class="text-danger">{{$errors->first('first_name')}}</p>
                                    @endif
                                </div>

                                <div class="mb-2">
                                    <label for="phoneNumber" class="form-label float-end">@lang('site.mobile')</label>
                                    <div class="input-group @error('mobile') has-error @enderror">
                                        <input type="text" placeholder="@lang('site.enter_your_mobile_number')" value="{{old('mobile')}}" class="form-control form-control-3 " name='mobile'  aria-describedby="basic-addon1">
                                        <input type="hidden" name="country_code" value='sa'/>
                                        <span class="input-group-text input-group-text-2" id="basic-addon1">+966</span>

                                    </div>
                                    @if($errors->has('mobile'))
                                        <p class="text-danger">{{$errors->first('mobile')}}</p>
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <label for="password-field" class="form-label float-end">@lang('site.password') </label>
                                    <div class="form-group">
                                        <input id="password-field" type="password" class="form-control form-control-3 @error('password') is-invalid @enderror" name="password"/>
                                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                    @if($errors->has('password'))
                                        <p class="text-danger">{{$errors->first('password')}}</p>
                                    @endif
                                </div>

                                <div class="mb-2">
                                    <label for="password-field0" class="form-label float-end">@lang('site.password_confirmation') </label>
                                    <div class="form-group">
                                        <input id="password-field0" type="password" class="form-control form-control-3 @error('password_confirmation') is-invalid @enderror" name="password_confirmation"/>
                                        <span toggle="#password-field0" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                    @if($errors->has('password_confirmation'))
                                        <p class="text-danger">{{$errors->first('password_confirmation')}}</p>
                                    @endif
                                </div>


                                <div class="form-check mt-2  form-check-2 p-0 text-{{app()->getLocale()=='ar' ? 'end' : 'start'}}">
                                    <input name='terms_accepted' class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault" style='margin:0; margin-{{app()->getLocale()=='ar' ? 'right' : 'left'}}:{{app()->getLocale()=='ar' ? '30' : '10'}}px'>
                                        @lang('site.i_accept_all')
                                        <a  href="{{route('terms_and_conditions')}}" class="terms-link"> @lang('general.termsAndConditions')</a>
                                        @if($errors->has('terms_accepted'))
                                            <p class="text-danger">{{$errors->first('terms_accepted')}}</p>
                                        @endif
                                    </label>
                                  </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-2 px-3 mt-2">@lang('site.register')</button>
                                </div>
                                <div class="mt-3">
                                    <a href="{{route('home')}}" class="new-acc new-acc-2">@lang('general.cancel')</a>
                                </div>
                              </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
