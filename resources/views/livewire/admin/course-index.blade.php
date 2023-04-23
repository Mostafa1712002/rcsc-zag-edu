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

            <a href="#" x-on:click="$wire.set('current_course_id',0)" data-toggle="modal" data-target="#course-modal" class="btn btn-success btn-lg">
                @lang('site.add_new_course')
            </a>

    @if (count($records))
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center">@lang('general.series')</th>
                    <th class="text-center">@lang('validation.attributes.title_ar')</th>
                    <th class="text-center">@lang('validation.attributes.title_en')</th>
                    <th class="text-center">@lang('validation.attributes.description_ar')</th>
                    <th class="text-center">@lang('validation.attributes.description_en')</th>
                    <th class="text-center">@lang('general.created_at')</th>
                    <th class="text-center">@lang('site.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td class="text-center">{{$loop->index+1}}</td>
                    <x-html.td-center :text="$record->title_ar"/>
                    <x-html.td-center :text="$record->title_en"/>
                    <x-html.td-center :text="$record->description_ar"/>
                    <x-html.td-center :text="$record->description_en"/>
                    <x-html.td-center :text="$record->created_at"/>
                    <td class="text-center">
                        <a x-on:click="$wire.set('current_course_id',{{$record->id}})" data-toggle='modal' data-target="#course-modal" class="btn btn-info">@lang('site.edit')</a>
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


    <div wire:ignore.self class="modal fade" id="course-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit.prevent='save'>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@lang('site.control_courses')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">

                        <div class="alert alert-success" id='alert-success' style='display:none'>@lang('site.saved')</div>
                        <div class="alert alert-danger" id='alert-error' style='display:none'>@lang('site.cant_save')</div>

                            <div class="form-group">
                                <label for="">@lang('validation.attributes.title_ar')</label>
                                <input wire:model.defer='current_course.title_ar' class="form-control @error('current_course.title_ar') is-invalid @enderror"/>
                                @error('current_course.title_ar') <p class="text-danger">{{$message}}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="">@lang('validation.attributes.description_ar')</label>
                                <textarea wire:model.defer='current_course.description_ar' class="form-control @error('current_course.description_ar') is-invalid @enderror"></textarea>
                                @error('current_course.description_ar') <p class="text-danger">{{$message}}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="">@lang('validation.attributes.title_en')</label>
                                <input wire:model.defer='current_course.title_en' class="form-control @error('current_course.title_en') is-invalid @enderror"/>
                                @error('current_course.title_en') <p class="text-danger">{{$message}}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="">@lang('validation.attributes.description_en')</label>
                                <textarea wire:model.defer='current_course.description_en' class="form-control @error('current_course.description_en') is-invalid @enderror"></textarea>
                                @error('current_course.description_en') <p class="text-danger">{{$message}}</p> @enderror
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
