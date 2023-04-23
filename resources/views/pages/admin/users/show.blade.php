@extends('pages.admin.master')
@section('content')
{!! spark_startCol([9,9,12,12])!!}
{!! spark_startCard($page_title,'primary')!!}
<div class="row">
    <table class="table table-striped table-hover table-reponsive" dir='{{ LaravelLocalization::getCurrentLocaleDirection() }}'>
        <tr>
            <td class="text-bold">@lang('site.name')</td>
            <td>{{$record->name}}</td>
        </tr>


        <tr>
            <td class="text-bold">@lang('site.email')</td>
            <td>{{$record->email}}</td>
        </tr>


        <tr>
            <td class="text-bold">@lang('site.mobile')</td>
            <td>{{$record->mobile_full_number}}</td>
        </tr>





    </table>
</div>
{!! spark_endCardWithHTML('') !!}
{!! spark_endCol() !!}

{!! spark_startCol([3,3,12,12])!!}
<div class="thumbnail text-center">
    <img class='img-thumbnail' src="{{asset('uploads/'.$record->avatar)}}" style='margin-bottom:5px;'/>
    <table class="table" dir='{{ LaravelLocalization::getCurrentLocaleDirection() }}'>
        <tr>
            <td class="text-bold">@lang('site.join_date')</td>
            <td>{{$record->created_at}}</td>
        </tr>

        <tr>
            <td class="text-bold">@lang('site.status')</td>
            <td>@lang('site.'.$record->status)</td>
        </tr>

        <tr>
            <td colspan="100%">
                <a class="btn btn-sm btn-info" href="{{route('admin.user.edit',$record->id)}}">
                    <i class="fas fa-edit"></i>
                    @lang('site.edit')
                </a>
            </td>
        </tr>

        {{-- <tr>
            <td colspan="100%">
                <a class="btn btn-sm btn-{{$record->status=='active'? 'danger' : 'success'}}" href="{{route('admin.user.toggle_status',$record->id)}}">
                    {{$record->status=='active'? __('site.deactivate_now') : __('site.activate_now')}}
                </a>
            </td>
        </tr> --}}


    </table>
</div>
{!! spark_endCol()!!}

@endsection
