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

            <a href="#" x-on:click="$wire.set('current_answer_id',0)" data-toggle="modal" data-target="#answer-modal" class="btn btn-success btn-lg">
                @lang('site.add_new_answer')
            </a>

    @if (count($records))
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center">@lang('general.series')</th>
                    <th class="text-center">@lang('validation.attributes.content')</th>
                    <th class="text-center">@lang('validation.attributes.is_correct')</th>
                    <th class="text-center">@lang('site.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td class="text-center">{{$loop->index+1}}</td>
                    <td class="text-center">{{$record->content}}</td>
                    <td class="text-center">{{$record->is_correct}}</td>
                    <td class="text-center">
                        <a x-on:click="$wire.set('current_answer_id',{{$record->id}})" data-toggle="modal" data-target="#answer-modal" href="#" class="btn btn-info">@lang('site.edit')</a>
                        <a x-on:click="$wire.set('current_answer_id',{{$record->id}})" data-toggle="modal" data-target="#delete-modal" class="btn btn-danger">@lang('site.delete')</a>
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


    <div wire:ignore.self class="modal fade" id="answer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="">@lang('validation.attributes.content')</label>
                                    <input wire:model.defer='form.content' class="form-control @error('form.content') is-invalid @enderror"/>
                                    @error('form.content') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">@lang('validation.attributes.is_correct')</label>
                                    <select wire:model.defer='form.is_correct' class="form-control">
                                        <option value>@lang('validation.attributes.is_correct')</option>
                                        <option value="correct">@lang('site.correct')</option>
                                        <option value="wrong">@lang('site.wrong')</option>
                                    </select>
                                    @error('form.is_correct') <p class="text-danger">{{$message}}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >@lang('site.save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End control modal -->



    <div wire:ignore.self class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@lang('site.delete_answer')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="alert alert-success" id='delete-answer-success' style='display:none'>@lang('site.saved')</div>
                        <p class="text-danger">@lang('site.this_action_cant_be_undone')</p>
                    </div>
                    <div class="modal-footer">
                        <button wire:click='delete()' type="button" class="btn btn-danger" >@lang('site.delete')</button>
                    </div>
            </div>
        </div>
    </div><!-- End control modal -->

</div>
