<div>
    <div class="row">
        <div class="form-group">
            <select wire:model='form.status' class="form-control">
                <option value="">@lang('site.select_status')</option>
                <option value="received">@lang('site.received')</option>
                <option value="not_received">@lang('site.not_received')</option>
            </select>
        </div>

        <div class="form-group">
            <input wire:model='form.ad_id' placeholder='@lang('site.ad_number')' type="text" class="form-control">
        </div>

        <div class="form-group">
            <input wire:model='form.id' placeholder='@lang('site.form_number')' type="text" class="form-control">
        </div>

        <div class="form-group">
            <button class="btn btn-danger" wire:click='resetForm'>@lang('site.reset')</button>
        </div>

    </div>
    @if (count($records))
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th class="text-center">@lang('general.series')</th>
                <th class="text-center">@lang('site.form_number')</th>
                <th class="text-center">@lang('site.form_date')</th>
                <th class="text-center">@lang('validation.attributes.ad_id')</th>
                <th class="text-center">@lang('validation.attributes.commission_amount')</th>
                <th class="text-center">@lang('validation.attributes.transfer_date')</th>
                <th class="text-center">@lang('site.status')</th>
                <th class="text-center">@lang('site.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
              <tr>
                <td class="text-center">{{$loop->index+1}}</td>
                <x-html.td-center :text="$record->id"/>
                <x-html.td-center :text="$record->created_at"/>
                <td class="text-center">
                    <a href="{{route('admin.ad.show',$record->ad_id)}}">{{$record->ad_id}}</a>
                </td>
                <x-html.td-center :text="$record->commission_amount.' '.__('site.sar')"/>
                <x-html.td-center :text="$record->transfer_date->format('Y-m-d')"/>
                <td class="text-center">
                    @if($record->status=='not_received')
                        <button class="btn btn-sm btn-danger receive-btn" data-id='{{$record->id}}'>@lang('site.'.$record->status)</button>
                    @else
                        <button disabled class="btn btn-sm btn-success">@lang('site.'.$record->status)</button>
                    @endif
                </td>
                <td class="text-center">
                    <x-html.show-button :href="route('admin.commission-transfer.show',$record->id)"/>
                </td>
              </tr>
            @endforeach
        </tbody>
    </table>
    {{$records->links()}}
@else
    {!! spark_alertWarningVisible(__('general.noDataToDisplay')) !!}
@endif
</div>
