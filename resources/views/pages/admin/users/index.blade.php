@extends('pages.admin.master')
@section('content')
{!! spark_startCol([12,12,12,12])!!}
{!!spark_startCard($page_title,'default',spark_getNewBtnInfo(['href'=>route('admin.user.create')]))!!}

@livewire('admin.user-index')


{!! spark_endCardWithHTML('') !!}
{!! spark_endCol() !!}



@endsection

@push('scripts')

@endpush
