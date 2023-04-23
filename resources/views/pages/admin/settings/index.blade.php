@extends('pages.admin.master')
@section('content')
{!! spark_startCol([12,12,12,12])!!}
{!! spark_startForm('admin.setting.update',$record->id)!!}
{!! spark_startCard($page_title,'primary')!!}

@csrf
@method('PUT')
<div class="row">
    <h3>@lang('site.contact_settings')</h3>
</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            <label>@lang('site.email'): </label>
            <input type="text" class="form-control"  name='email' value='{{$record->email}}'/>
            <p class='text-danger'>{{$errors->first('email')}}</p>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label>@lang('site.mobile_number'): </label>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">+966</span></div>
                <input type="text" class="form-control"  name='mobile_number' value='{{ $record->mobile_number }}' />
            </div>
            <p class='text-danger'>{{$errors->first('mobile_number')}}</p>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label>@lang('site.fax'): </label>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">+966</span></div>
                <input type="text" class="form-control"  name='fax' value='{{ $record->fax }}' />
            </div>
            <p class='text-danger'>{{$errors->first('fax')}}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            <label>@lang('site.whatsapp'): </label>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">+966</span></div>
                <input type="text" class="form-control"  name='whatsapp' value='{{ $record->whatsapp }}' />
            </div>
            <p class='text-danger'>{{$errors->first('whatsapp')}}</p>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label>@lang('site.twitter'): </label>
            <input type="text" class="form-control"  name='twitter' value='{{ $record->twitter }}' />
            <p class='text-danger'>{{$errors->first('twitter')}}</p>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label>@lang('site.facebook'): </label>
            <input type="text" class="form-control"  name='facebook' value='{{ $record->facebook }}' />
            <p class='text-danger'>{{$errors->first('facebook')}}</p>
        </div>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="form-group">
            <label>@lang('site.instagram'): </label>
            <input type="text" class="form-control"  name='instagram' value='{{$record->instagram}}'/>
            <p class='text-danger'>{{$errors->first('instagram')}}</p>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label>@lang('site.youtube'): </label>
            <input type="text" class="form-control"  name='youtube' value='{{ $record->youtube }}' />
            <p class='text-danger'>{{$errors->first('youtube')}}</p>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label>@lang('site.linkedin'): </label>
            <input type="text" class="form-control"  name='linkedin' value='{{ $record->linkedin }}' />
            <p class='text-danger'>{{$errors->first('linkedin')}}</p>
        </div>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="form-group">
            <label>@lang('validation.attributes.website'): </label>
            <input type="text" class="form-control" name='website' value='{{$record->website}}'/>
            <p class='text-danger'>{{$errors->first('website')}}</p>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label>@lang('validation.attributes.snapchat'): </label>
            <input type="text" class="form-control"  name='snapchat' value='{{ $record->snapchat }}' />
            <p class='text-danger'>{{$errors->first('snapchat')}}</p>
        </div>
    </div>

</div>

<hr>
<div class="row">
    <h3>@lang('site.app_settings')</h3>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <label>@lang('validation.attributes.commission_percent'): </label>
            <div class="input-group">
                <input type="text" class="form-control"  name='commission_percent' value='{{$record->commission_percent}}'/>
                <div class="input-group-append"><span class="input-group-text">%</span></div>
            </div>

            <p class='text-danger'>{{$errors->first('commission_percent')}}</p>
        </div>


        <div class="form-group">
            <label>@lang('validation.attributes.bank_account_id'): </label>
            <input type="text" class="form-control"  name='bank_account_id' value='{{$record->bank_account_id}}'/>
            <p class='text-danger'>{{$errors->first('bank_account_id')}}</p>
        </div>


    </div>
</div>

{!! spark_endCardWithHTML(spark_submitBtn(['class'=>'success','title'=>__('general.save'),'name'=>'submit'])) !!}


<input type="hidden" name='record_id' value='{{$record->id}}'/>
{!! spark_endForm()!!}
{!! spark_endCol() !!}

@endsection
