@extends('pages.admin.master')
@section('content')
{!! spark_startForm('admin.user.update',$record->id)!!}



{!! spark_startCard($page_title,'primary')!!}
@method('PUT')
@csrf

    <div class="row col-lg-12">

        {!! spark_startCol([8,8,12,12])!!}
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>@lang('site.name'): </label>
                        <input type="text" class="form-control"  name='name' value='{{$record->name}}'/>
                        <p class='text-danger'>{{$errors->first('name')}}</p>
                    </div>
                </div>


                <div class="col">
                    <div class="form-group">
                        <label>@lang('site.email'): </label>
                        <input type="email" class="form-control"  name='email' value='{{$record->email}}'/>
                        <p class='text-danger'>{{$errors->first('email')}}</p>
                    </div>
                </div>


            </div>


            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>@lang('site.mobile_country'): </label>
                        <select name="country_code" class='form-control'>
                            @foreach ($countries as $country )
                                <option {{($country->iso_code==$record->country_code)? 'selected' : '' }} value="{{$country->iso_code}}">
                                    {{ (app()->locale=='ar')? $country->title_ar : $country->title_en }}
                                    ({{$country->phone_code}})
                                </option>
                            @endforeach
                        </select>
                        <p class='text-danger'>{{$errors->first('mobile_country')}}</p>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label>@lang('site.mobile'): </label>
                        <input type="text" class="form-control"  name='mobile' value='{{$record->mobile}}'/>
                        <p class='text-danger'>{{$errors->first('mobile')}}</p>
                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col">
                    <label>@lang('site.password')</label>
                    <div class="input-group mb-3 form-group">
                        <div class="input-group-prepend">
                            <span data-related-element = 'password' class="input-group-text show-eye-btn"><i class="fas fa-eye"></i></span>
                        </div>
                        <input type="password" class="form-control" name='password'/>
                        @error('password')
                            <p class='text-danger'>@lang('site.password_error_message')</p>
                        @enderror

                    </div>
                </div>


                <div class="col">
                    <label>@lang('site.password_confirmation')</label>
                    <div class="input-group mb-3 form-group">
                        <div class="input-group-prepend">
                            <span data-related-element = 'password_confirmation' class="input-group-text show-eye-btn"><i class="fas fa-eye"></i></span>
                        </div>
                        <input type="password_confirmation" class="form-control" name='password_confirmation'/>
                        <p class='text-danger'>{{$errors->first('password_confirmation')}}</p>
                    </div>
                </div>


                <div class="col">
                    <div class="form-group">
                        <label>@lang('site.avatar'): </label>
                    <input type="file" name='avatar' class="form-control"/>
                        <p class='text-danger'>{{$errors->first('avatar')}}</p>
                    </div>
                </div>

            </div>
        {!! spark_endCol() !!}


        {!! spark_startCol([4,4,12,12])!!}
            <div class="thumbnail text-center">
                <img class='img-thumbnail' src="{{asset('uploads/'.$record->avatar)}}" style='margin-bottom:5px;'/>
                <table class="table" dir='{{ LaravelLocalization::getCurrentLocaleDirection() }}'>
                    <tr>
                        <td class="text-bold">@lang('site.join_date')</td>
                        <td>{{$record->created_at}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">@lang('site.status')</td>
                        <td>
                            <select name="status" class='form-control'>
                                <option value="active" {{$record->status=='active'? 'selected' : ''}}>@lang('site.active')</option>
                                <option value="inactive" {{$record->status=='inactive'? 'selected' : ''}}>@lang('site.inactive')</option>
                            </select>
                        </td>
                    </tr>

                    <tr id='deactivation-reason-tr' style='{{($record->status=='active' && !$errors->first('deactivation_reason'))? 'display:none' : '' }}'>
                        <td colspan="2">
                            <label for="">@lang('site.deactivation_reason')</label>
                            <textarea name="deactivation_reason" class="form-control">{{$record->deactivation_reason}}</textarea>
                            <p class='text-danger'>{{$errors->first('deactivation_reason')}}</p>
                        </td>
                    </tr>


                </table>
            </div>
        {!! spark_endCol() !!}
    </div>


{!! spark_endCardWithHTML(spark_submitBtn(['class'=>'success','title'=>__('general.save'),'name'=>'submit'])) !!}


<input type='hidden' value='{{$record->id}}' name='record_id'/>
{!! spark_endForm()!!}
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('[name=status]').change(function(){
                let that = $(this);
                if(that.val()=='active'){
                    $('#deactivation-reason-tr').hide();
                    $('[name=reason]').val('');
                }else{
                    $('#deactivation-reason-tr').show();
                }
            });
        });
    </script>
@endpush
