@extends('pages.front.master')
@section('content')
    <!-- start main -->
        <section class="sign-in">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <p class="sign-head"><i class="fas fa-arrow-right"></i>@lang('site.register')</p>
                        <div class="sign-card bg-card-dark p-5 rounded">
                            <form class="l-custom" method="POST" action="{{route('verify',$customer->id)}}">
                                @csrf
                                @if (session('error_message'))
                                    <div class="alert alert-danger">
                                        {{session('error_message')}}
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label  class="form-label">@lang('site.please_check_sms_sent_to_number') <br><span>+966 {{$customer->mobile}}</span></label>
                                    <p>((TESTING ONLY)) Code generated at {{$customer->verification_code_generated_at}}</p>
                                    <div class="row justify-content-center" dir="ltr">
                                            <div class="col-3">
                                                <input type="text" class="form-control form-control-3 otp-field"  name='code1'/>
                                            </div>

                                            <div class="col-3">
                                                <input type="text" class="form-control form-control-3 otp-field" name='code2'/>
                                            </div>

                                            <div class="col-3">
                                                <input type="text" class="form-control form-control-3 otp-field" name='code3'/>
                                            </div>

                                            <div class="col-3">
                                                <input type="text" class="form-control form-control-3 otp-field" name='code4'/>
                                            </div>

                                    </div>
                                </div>


                                <div class="clearfix"></div>
                                <div class="d-grid gap-2">
                                    <button type="submit" id='proceed-btn' class="btn btn-2 px-5">@lang('site.proceed')</button>
                                </div>
                                <div class="mt-3">
                                    <a href="#" class="new-acc new-acc">@lang('site.resend_after') <span class="new-acc-2">5:34</span> </a>
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
        // $(document).ready(()=>{
        //     $('.otp-field').keyup(e=>{
        //         let that = $(this);
        //         if ((e.ke >= 48 && e.key <= 57) || (e.key >= 96 && e.key <= 105)) {
        //             console.log(e.key);
        //             if(that.attr('name')=='code1'){
        //                 $('[name=code2]').focus();
        //             }else if(that.attr('name')=='code2'){
        //                 $('[name=code3]').focus();
        //             }else if(that.attr('name')=='code3'){
        //                 $('[name=code4]').focus();
        //             }else if(that.attr('name')=='code4'){
        //                 $('#proceed-btn').focus();
        //             }
        //         }else{
        //             e.preventDefault();
        //         }
        //     });
        // });
    </script>
@endpush
