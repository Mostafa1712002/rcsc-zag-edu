@extends('pages.admin.master')
@section('content')
{!! spark_startCol([12,12,12,12])!!}
{!!spark_startCard($page_title,'default')!!}
@livewire('admin.student-index')

{!! spark_endCardWithHTML('') !!}
{!! spark_endCol() !!}



@endsection

@push('scripts')

@endpush
