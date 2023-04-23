@extends('pages.admin.master')
@section('content')
{!! spark_startForm('admin.user.update',$record->id)!!}



{!! spark_startCard($page_title,'primary')!!}
@method('PUT')
@csrf

    <div class="row col-lg-12">


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
                    <input type="text" class="form-control"  name='email' value='{{$record->email}}'/>
                    <p class='text-danger'>{{$errors->first('email')}}</p>
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

            <div class="col">
                <div class="form-group">
                    <label>@lang('site.status'): </label>
                    <select name="status" class="form-control">
                        <option {{($record->status=='active')? 'selected' : '' }} value="active">@lang('site.active')</option>
                        <option {{($record->status=='inactive')? 'selected' : '' }} value="inactive">@lang('site.inactive')</option>
                    </select>
                    <p class='text-danger'>{{$errors->first('status')}}</p>
                </div>
            </div>

        </div>
    </div>
{!! spark_endCardWithHTML(spark_submitBtn(['class'=>'success','title'=>__('general.save'),'name'=>'submit'])) !!}


<input type='hidden' value='{{$record->id}}' name='record_id'/>
{!! spark_endForm()!!}



<form action="{{route('admin.save_permissions',$record->id)}}" method='POST'>
    <div class="col-12 table-wrap">
    {!! spark_startCard(__('site.permissions'),'primary')!!}



                    @csrf
                    @method('PUT')
                    <table class='table'>
                        <tr>
                            <td colspan="2">
                                <button
                                    type='button'
                                    class="btn"
                                    x-data="{
                                        select_all:false,
                                        toggle(){
                                            this.select_all=!this.select_all;
                                            if(this.select_all){
                                                $('.permission-checkbox').attr('checked','checked');
                                            }else{
                                                $('.permission-checkbox').removeAttr('checked');
                                            }

                                        }
                                    }"
                                    x-text="select_all? '@lang('site.deselect_all')' : '@lang('site.select_all')'"
                                    x-on:click="toggle()"
                                >

                                </button>
                            </td>
                        </tr>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>
                                    <input
                                        class='permission-checkbox'
                                        type="checkbox"
                                        name="{{$permission}}"
                                        id="{{$permission}}"
                                        {{$record->hasPermissionTo($permission)? "checked" : ""}}
                                    />
                                </td>
                                <td>
                                    <label for="#{{$permission}}">@lang('permissions.'.$permission)</label>
                                </td>
                        @endforeach
                    </table>
                <input type="hidden" name="record_id" value="{{$record->id}}">
    {!! spark_endCardWithHTML('<button class="btn btn-success" type="submit">'.__('site.save').'</button>') !!}
    </div><!-- End col-12-->
</form>


@endsection

