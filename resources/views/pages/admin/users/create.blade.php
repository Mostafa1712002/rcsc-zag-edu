@extends('pages.admin.master')
@section('content')
{!! spark_startCol([12,12,12,12])!!}
{!! spark_startForm('admin.user.store')!!}
{!! spark_startCard($page_title,'primary')!!}

@csrf


<div class="row">

    <div class="col">
        <div class="form-group">
            <label>@lang('site.name'): </label>
            <input type="text" class="form-control"  name='name' value='{{old('name')}}'/>
            <p class='text-danger'>{{$errors->first('name')}}</p>
        </div>
    </div>


    <div class="col">
        <div class="form-group">
            <label>@lang('site.email'): </label>
            <input type="text" class="form-control"  name='email' value='{{old('email')}}'/>
            <p class='text-danger'>{{$errors->first('email')}}</p>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label>@lang('site.mobile'): </label>
            <input type="text" class="form-control"  name='mobile' value='{{old('mobile')}}'/>
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

    <div class="col">
        <div class="form-group">
            <label>@lang('site.status'): </label>
            <select name="status" class="form-control">
                <option {{(old('status')=='active')? 'selected' : '' }} value="active">@lang('site.active')</option>
                <option {{(old('status')=='inactive')? 'selected' : '' }} value="inactive">@lang('site.inactive')</option>
            </select>
            <p class='text-danger'>{{$errors->first('status')}}</p>
        </div>
    </div>



</div>




{!! spark_endCardWithHTML(spark_submitBtn(['class'=>'success','title'=>__('general.save'),'name'=>'submit'])) !!}
{!! spark_endForm()!!}
{!! spark_endCol() !!}

@endsection
