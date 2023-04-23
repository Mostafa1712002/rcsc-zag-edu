<div>
     <div class="row">
        <div class="form-group">
            <label for="userEmail">@lang('site.email')</label>
            <input wire:model='email' placeholder="John@example.com" type="text" id='adId' class="form-control @error('email') is-invalid @enderror"/>
            @error('email')
                <p style='color:red'>{{$errors->first('email')}}</p>
            @enderror
        </div>


        <div class="form-group">
            <label for="statusSelect">@lang('site.status')</label>
            <select wire:model='status' id="statusSelect" class="form-control">
                <option value="">@lang('site.select_status')</option>
                <option value="active">@lang('site.active')</option>
                <option value="inactive">@lang('site.inactive')</option>
            </select>
        </div>



        <div class="form-group">
            <label for="customerMobile">@lang('site.mobile')</label>
            <div class="input-group">
                <input wire:model='mobile' type="text" class="form-control @error('mobile') is-invalid @enderror"/>
            </div>
            @error('mobile')
                <p style='color:red'>{{$errors->first('mobile')}}</p>
            @enderror
        </div>
    </div>
    @if (count($records))
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center">@lang('general.series')</th>
                        <th class="text-center">@lang('site.avatar')</th>
                        <th class="text-center">@lang('site.name')</th>
                        <th class="text-center">@lang('site.email')</th>
                        <th class="text-center">@lang('site.status')</th>
                        <th class="text-center">@lang('site.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                    <tr>
                        <td class="text-center">{{$loop->index+1}}</td>
                        <td class="text-center"><img class ='img-circle img-sm text-center' src="{{$record->avatar_url}}"/></td>
                        <x-html.td-center :text="$record->name"/>
                        <x-html.td-center :text="$record->email"/>
                        <td class="text-center"><x-html.status-badge :status="$record->status"/></td>
                        <td class="text-center">
                            <x-html.edit-button :href="route('admin.user.edit',$record->id)"/>
                            <x-html.delete-button :href="route('admin.user.delete',$record->id)"/>
                            <x-html.show-button :href="route('admin.user.show',$record->id)"/>
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
</div>
