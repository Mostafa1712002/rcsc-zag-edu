@extends('pages.front.master')
@section('content')
    <!-- start main -->
        <section class="sign-in">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <p class="sign-head"><i class="fas fa-arrow-right"></i>@lang('site.register')</p>
                        <div class="sign-card bg-card-dark p-5 rounded">
                            <form
                                x-data="{wait_time:{{$customer->forget_password_wait_time}},code1:'',code2:'',code3:'',code4:'' }" x-init="window.setInterval(() => { if(wait_time > 0) wait_time = wait_time - 1;}, 1000)"
                                class="l-custom"
                                method="POST"
                                action="{{route('customer.verify_reset_password_page',['customer'=>$customer])}}">
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

                                 {{-- @if ($customer->reset_password_num>3)
                                    <div class="alert alert-danger">
                                        @lang('site.sms_is_temp_disabled')
                                    </div>
                                @endif --}}
                                <div class="mb-3">
                                    <label  class="form-label">@lang('site.please_check_sms_sent_to_number') <br><span>+966 {{$customer->mobile}}</span></label>
                                    <p></p>
                                    <div class="row justify-content-center" dir="ltr">
                                            <div class="col-3">
                                                <input type="text" class="form-control form-control-3 otp-field" x-model="code1"  name='code1'/>
                                            </div>

                                            <div class="col-3">
                                                <input type="text" class="form-control form-control-3 otp-field" x-model="code2" name='code2'/>
                                            </div>

                                            <div class="col-3">
                                                <input type="text" class="form-control form-control-3 otp-field" x-model="code3" name='code3'/>
                                            </div>

                                            <div class="col-3">
                                                <input type="text" class="form-control form-control-3 otp-field" x-model="code4" name='code4'/>
                                            </div>

                                    </div>
                                </div>


                                <div class="clearfix"></div>
                                <div class="d-grid gap-2">
                                    <button
                                        x-show="wait_time>0"
                                        :class="code1.length!=1 ||code2.length!=1 ||code3.length!=1 ||code4.length!=1 ? 'disabled' : ''"
                                        type="submit"
                                        id='proceed-btn'
                                        class="btn btn-2 px-5">
                                        @lang('site.proceed')
                                    </button>
                                </div>
                                <div class="mt-3">
                                    <a href="#" class="new-acc new-acc">
                                        @lang('site.resend_after')
                                        <span
                                            class="new-acc-2"
                                            x-text="wait_time"
                                            x-show="wait_time>0"
                                        >
                                        </span>
                                    </a>
                                    <a href='{{route('customer.request_forget_password_code',['mobile'=>$customer->mobile])}}' x-show="wait_time<=0" class="btn btn-2 px-5">@lang('site.resend_code')</a>
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

</script>
@endpush
