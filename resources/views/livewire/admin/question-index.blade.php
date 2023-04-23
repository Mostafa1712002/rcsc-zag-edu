<div
    x-data
    x-on:hide-modal.window="
        $('#'+$event.detail.alert_id).fadeIn();
        setTimeout(
            function(){
                $('#'+$event.detail.alert_id).fadeOut();
                $('#'+$event.detail.modal_id).modal('hide');
            },2000);"
>

            <a href="#" x-on:click="$wire.set('current_question_id',0)" data-toggle="modal" data-target="#question-modal" class="btn btn-success btn-lg">
                @lang('site.add_new_question')
            </a>

    @if (count($records))
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center">@lang('general.series')</th>
                    <th class="text-center">@lang('validation.attributes.content')</th>
                    <th class="text-center">@lang('general.created_at')</th>
                    <th class="text-center">@lang('site.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td class="text-center">{{$loop->index+1}}</td>
                    <x-html.td-center :text="$record->content"/>
                    <x-html.td-center :text="$record->created_at"/>
                    <td class="text-center">
                        <a href='{{route('admin.question.answers',$record)}}' class="btn btn-primary">@lang('site.answers')</a>
                    </td>
                    <td class="text-center">
                        <a x-on:click="$wire.set('current_question_id',{{$record->id}})" data-toggle='modal' data-target="#question-modal" class="btn btn-info">@lang('site.edit')</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$records->links()}}
    @else
        {!! spark_alertWarningVisible(__('general.noDataToDisplay')) !!}
    @endif


    <div wire:ignore.self class="modal fade" id="question-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit.prevent='save'>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@lang('site.control_questions')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">

                        <div class="alert alert-success" id='alert-success' style='display:none'>@lang('site.saved')</div>
                        <div class="alert alert-danger" id='alert-error' style='display:none'>@lang('site.cant_save')</div>



                            <div class="form-group">
                                <label for="">@lang('validation.attributes.content')</label>
                                <textarea wire:model.defer='current_question.content' class="form-control @error('current_question.content') is-invalid @enderror"></textarea>
                                @error('current_question.content') <p class="text-danger">{{$message}}</p> @enderror
                            </div>



                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >@lang('site.save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End control modal -->

</div>
