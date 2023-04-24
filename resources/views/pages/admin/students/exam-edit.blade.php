@extends('pages.admin.master')
@section('content')
{!! spark_startCol([12,12,12,12])!!}
{!!spark_startCard($page_title,'default')!!}

<form action="{{ route('admin.student.update', ['student' => $record->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="exam_degree">@lang("site.exam_degree")</label>
        <input type="text" class="form-control" id="exam_degree" name="exam_degree" value="{{ $record->exam_degree }}" placeholder='@lang("site.exam_degree")'>
    </div>

    {!! spark_endCardWithHTML(spark_submitBtn(['class'=>'success','title'=>__('general.save'),'name'=>'submit'])) !!}

</form>

{!! spark_endCard() !!}

{!! spark_endCardWithHTML('') !!}
{!! spark_endCol() !!}

@endsection
