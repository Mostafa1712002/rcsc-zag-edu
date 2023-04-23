<div
    x-data="{ids:[]}"
    x-on:hide-modal.window="
        $('#'+$event.detail.alert_id).fadeIn();
        setTimeout(
            function(){
                $('#'+$event.detail.alert_id).fadeOut();
                $('#'+$event.detail.modal_id).modal('hide');
            },2000);"
>
    <form wire:submit.prevent='search'>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="userName">@lang('validation.attributes.full_name')</label>
                    <input wire:model.defer='full_name' type="text" id='userName' class="form-control"/>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="userName">@lang('validation.attributes.status')</label>
                    <select wire:model.defer='status' class="form-control">
                        <option value>@lang('site.select_status')</option>
                        <option value="active">@lang('site.active')</option>
                        <option value="waiting">@lang('site.waiting')</option>
                    </select>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="userEmail">@lang('validation.attributes.national_id')</label>
                    <input wire:model.defer='national_id' type="text" id='userEmail' class="form-control"/>
                </div>
            </div>

            <div class="col">
                <button class="btn btn-primary btn-sm" type='submit' style='margin-top:30px'>@lang('site.search')</button>
                <button class="btn btn-success btn-sm" wire:click='export' type='button' style='margin-top:30px'>@lang('site.export')</button>
            </div>

            <div class="col" x-show="ids.length>0">
                <button class="btn btn-success btn-sm" data-toggle='modal' data-target='#all-modal' type='button' style='margin-top:30px'>@lang('site.accept_selected') <span class="badge bg-inverse" x-text='ids.length'></span></button>
                <button class="btn btn-danger btn-sm" data-toggle='modal' data-target='#all-modal' type='button' style='margin-top:30px'>@lang('site.delete_selected') <span class="badge bg-inverse" x-text='ids.length'></span></button>
            </div>


        </div>
    </form>
    @if (count($records))
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center">@lang('site.select')</th>
                    <th class="text-center">@lang('general.series')</th>
                    <th class="text-center">@lang('validation.attributes.personal_pic')</th>
                    <th class="text-center">@lang('site.name')</th>
                    <th class="text-center">@lang('validation.attributes.course_ids')</th>
                    <th class="text-center">@lang('site.join_date')</th>
                    <th class="text-center">@lang('validation.attributes.national_id')</th>
                    <th class="text-center">@lang('validation.attributes.ack_video')</th>
                    <th class="text-center">@lang('validation.attributes.exam_degree')</th>
                    <th class="text-center">@lang('validation.attributes.exam_grade')</th>
                    <th class="text-center">@lang('validation.attributes.exam_pic')</th>
                    <th class="text-center">@lang('site.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td class="text-center">
                        @if($record->status=='waiting')
                            <input type="checkbox" value="{{$record->id}}" x-model='ids'>
                        @endif
                    </td>
                    <td class="text-center">{{$loop->index+1}}</td>
                    <td class="text-center"><img class='img img-rounded' style="width:100px;" src="{{$record->avatar_url}}" alt=""></td>
                    <x-html.td-center :text="$record->full_name"/>
                    <x-html.td-center :text="is_null($record->course_ids)? '0' : count($record->course_ids)"/>
                    <x-html.td-center :text="$record->created_at->format('Y-m-d')"/>
                    <x-html.td-center :text="$record->national_id"/>

                    <td class="text-center">
                        <a href="{{url('uploads/pics/'.$record->ack_video)}}" target='_blank' class="btn btn-primary btn-sm">@lang('site.download')</a>
                    </td>

                    <x-html.td-center :text="$record->exam_degree? $record->exam_degree.'/'.($record->questions_count*10) : '---'"/>
                    <td class="text-center">
                        @lang('grades.'.$record->exam_grade)
                        @if(!is_null($record->exam_degree))
                            <br>
                            <a target='_blank' class='btn btn-sm btn-warning' href='{{route('admin.certificate.show',$record)}}'>@lang('site.certificate')</a>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($record->exam_pic)
                            <img class='img img-rounded' style="width:100px;" src="{{$record->exam_pic_url}}" alt="">
                        @endif
                    </td>

                    <td class="text-center">
                        @if($record->status=='waiting')
                            <button wire:click='setCurrentStudentId({{$record->id}})' data-toggle='modal' data-target='#control-modal' class='btn btn-success'>@lang('site.accept')</button>
                            <button wire:click='setCurrentStudentId({{$record->id}})' data-toggle='modal' data-target='#control-modal' class='btn btn-danger'>@lang('site.delete')</button>
                        @endif
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



    <!-- control Modal -->
    <div wire:ignore.self class="modal fade" id="control-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('site.are_you_sure')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">

                    <h3>@lang('validation.attributes.full_name'): <span class="badge">{{optional($current_student)->full_name}}</span></h3>

                    <div class="alert alert-success" id='control-student-success' style='display:none'>@lang('site.saved')</div>
                    <div class="alert alert-danger" id='control-student-error' style='display:none'>@lang('site.cant_save')</div>

                    <p class='text-danger'>@lang('site.this_action_cant_be_undone')</p>

                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="accept()" class="btn btn-success" >@lang('site.accept')</button>
                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger" >@lang('site.delete')</button>
                </div>
            </div>
        </div>
    </div><!-- End control modal -->


    <!-- all Modal -->
    <div wire:ignore.self class="modal fade" id="all-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('site.are_you_sure')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">

                    <div class="alert alert-success" id='all-success' style='display:none'>@lang('site.saved')</div>
                    <div class="alert alert-danger" id='all-error' style='display:none'>@lang('site.cant_save')</div>

                    <p class='text-danger'>@lang('site.this_action_cant_be_undone')</p>

                </div>
                <div class="modal-footer">
                    <button type="button" x-on:click="$wire.changeAllTo('accept',ids)" class="btn btn-success" >@lang('site.accept')</button>
                    <button type="button" x-on:click="$wire.changeAllTo('delete',ids)"  class="btn btn-danger" >@lang('site.delete')</button>
                </div>
            </div>
        </div>
    </div><!-- End control modal -->
</div>
