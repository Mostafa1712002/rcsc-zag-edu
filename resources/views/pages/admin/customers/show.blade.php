@extends('pages.admin.master')
@section('content')
{!! spark_startCol([9,9,12,12])!!}
{!! spark_startCard($page_title,'primary')!!}
<div class="row">
    <table class="table table-striped table-hover table-reponsive" dir='{{ LaravelLocalization::getCurrentLocaleDirection() }}'>
        <tr>
            <td class="text-bold">@lang('site.name')</td>
            <td>{{$record->full_name}}</td>
        </tr>

        <tr>
            <td class="text-bold">@lang('site.rating')</td>
            <td>{!! spark_starsRating($record->avg_rating) !!}</td>
        </tr>


        <tr>
            <td class="text-bold">@lang('site.email')</td>
            <td>{{$record->email}}</td>
        </tr>

        <tr>
            <td class="text-bold">@lang('site.mobile')</td>
            <td>{{$record->mobile}}</td>
        </tr>

        <tr>
            <td class="text-bold">@lang('site.customer_ads')</td>
            <td>
                {!! $not_deleted_customer_ads_count? '<a class="btn btn-sm btn-success" href="'.route('admin.ad.index').'?customer_id='.$record->id.'">'.__('site.not_deleted_ads').'  <span class="badge bg-primary">'.$not_deleted_customer_ads_count.'</span></a>' : __('site.no_ads')!!}

                {!! $deleted_customer_ads_count? '<a class="btn btn-sm btn-danger" href="'.route('admin.ad.index').'?customer_id='.$record->id.'&show_deleted=1">'.__('site.deleted_ads').' <span class="badge  bg-primary">'.$deleted_customer_ads_count.'</span></a>' : '' !!}
            </td>
        </tr>


    </table>
</div>
{!! spark_endCardWithHTML('') !!}
{!! spark_endCol() !!}

{!! spark_startCol([3,3,12,12])!!}
<div class="thumbnail text-center">
    <img class='img-thumbnail' src="{{$record->avatar_url}}" style='margin-bottom:5px;'/>
    <table class="table" dir='{{ LaravelLocalization::getCurrentLocaleDirection() }}'>
        <tr>
            <td class="text-bold">@lang('site.join_date')</td>
            <td>{{$record->created_at}}</td>
        </tr>

        <tr>
            <td class="text-bold">@lang('site.status')</td>
            <td>@lang('site.'.$record->status)</td>
        </tr>
           @if($record->status=='active')
            <tr>
                <td colspan="100%">
                    <form action="{{route('admin.customer.deactivate',$record->id)}}" method='POST'>
                        @csrf
                        <label for="deactivation-reason">@lang('site.deactivation_reason')</label>
                        <textarea class='form-control @error('deactivation_reason') is-invalid @enderror' name='deactivation_reason' rows="5">{{$record->deactivation_reason}}</textarea>
                        @error('deactivation_reason')
                            <p class="invalid-feedback">{{$errors->first('deactivation_reason')}}</p>
                        @enderror
                        <button class="btn btn-sm btn-danger" type="submit">
                             @lang('site.deactivate_now')
                        </a>
                    </form>
                </td>
            </tr>
        @else
            <tr>
                <td colspan="100%">
                    <form action="{{route('admin.customer.activate',$record->id)}}" method='POST'>
                        @csrf
                        <button class="btn btn-sm btn-success" type="submit">
                            @lang('site.activate_now')
                        </a>
                    </form>
                </td>
            </tr>
        @endif



    </table>
</div>
{!! spark_endCol()!!}

@endsection
