@extends('pages.front.master')
@section('content')
 <!-- start main -->

        <section class="sign-in">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <p class="sign-head">@lang('site.login')</p>
                        <div class="sign-card bg-card-dark p-5 rounded">
                            @if(session('error_message'))
                                <div class="alert alert-danger">
                                    {{session('error_message')}}
                                </div>
                            @elseif(session('success_message'))
                                <div class="alert alert-success">
                                    {{session('success_message')}}
                                </div>
                            @endif
                            <form class="" method="post" action='{{route('customer.login')}}'>
                                @csrf
                                <input type="hidden" name="country_code" value='sa'/>
                                <div class="form-group">
                                    <label for="" class="form-label text-capitalize">@lang('site.mobile_number')</label>
                                    <div class="input-group mb-3" style="direction: ltr;">
                                        <input type="text" id="mobile_input" class="form-control form-control-3" name='mobile' aria-describedby="basic-addon1" autocomplete="off"/>
                                        <span class="input-group-text input-group-text-2" id="basic-addon1" style="border-right: 1px solid #ccc;">+966</span>
                                    </div>
                                    @if($errors->has('mobile'))
                                        <p class="invalid-msg">{{$errors->first('mobile')}}</p>
                                    @endif
                                </div>

                                <hr>

                                <div class="mb-3">

                                    <div class="form-group">
                                        <label for="" class="form-label">@lang('site.password')</label>
                                        <input id="password-field" type="password" class="form-control form-control-3" name="password"/>
                                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        @error('password')
                                            <p class="invalid-msg">{{$errors->first('password')}}</p>
                                        @enderror
                                    </div>

                                </div>

                                <div class="mb-3 mb-555 row">
                                    <div class="col-md-6">

                                        <div class="form-check form-check-2 p-0 text-{{app()->getLocale()=='ar' ? 'end' : 'start'}}">
                                            <input class="form-check-input" type="checkbox" name='remember' value="" id="flexCheckDefault" >
                                            <label class="form-check-label" for="flexCheckDefault"  style='margin:0; margin-{{app()->getLocale()=='ar' ? 'right' : 'left'}}:{{app()->getLocale()=='ar' ? '30' : '10'}}px'>
                                                @lang('general.remember_me')
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{route('customer.forget_password')}}" class="forgot-pass float-start">@lang('general.didYouForgotPassword')</a>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-2 px-3 mt-4 btn-222">@lang('site.login')</button>
                                </div>
                                <div class=" mt-3">
                                    <a href="{{route('customer.register')}}" class="new-acc">@lang('site.dont_have_account_register_one_now')</a>

                                </div>
                                <div class="mt-3">
                                    <a href="{{route('home')}}" class="new-acc new-acc-2">@lang('site.login_as_a_visitor')</a>
                                </div>
                              </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('scripts')
    <script>
        let mobile = document.getElementById('mobile_input');

        String.prototype.ConvertToArabicNumbers = function (){
            var id= ['۰','۱','۲','۳','٤','٥','٦','۷','۸','۹'];
            return this.replace(/[0-9]/g, function(w){
                return id[+w]
            });
        }

{{--        @if(Helpers::pageDirection() == 'rtl')--}}
{{--            mobile.oninput = function (e)--}}
{{--        {--}}
{{--            e.target.value = e.target.value.ConvertToArabicNumbers();--}}
{{--        }--}}
{{--        @endif--}}
    </script>
@endpush
