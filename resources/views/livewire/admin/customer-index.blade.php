<div>
     <div class="row">

         <div class="form-group">
            <label for="userName">@lang('validation.attributes.full_name')</label>
            <input wire:model='name' type="text" id='userName' class="form-control"/>
        </div>


        <div class="form-group">
            <label for="userEmail">@lang('site.email')</label>
            <input wire:model.debounce.500ms='email' placeholder="John@example.com" type="text" id='userEmail' class="form-control @error('email') is-invalid @enderror"/>
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
                <div class="input-group-prepend"><span class="input-group-text">+966</span></div>
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
                <th class="text-center">@lang('site.name')</th>
                <th class="text-center">@lang('site.join_date')</th>
                <th class="text-center">@lang('site.mobile')</th>
                <th class="text-center">@lang('site.email')</th>
                <th class="text-center">@lang('site.verification')</th>
                <th class="text-center">@lang('site.status')</th>
                <th class="text-center">@lang('site.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
              <tr>
                <td class="text-center">{{$loop->index+1}}</td>
                <x-html.td-center :text="$record->full_name"/>
                <x-html.td-center :text="$record->created_at->format('Y-m-d')"/>
                <x-html.td-center :text="$record->mobile"/>
                <x-html.td-center :text="$record->email"/>
                <x-html.td-center :text="$record->verification_code? __('site.not_verified') : __('site.verified')"/>
                <td class="text-center"><x-html.status-badge :status="$record->status"/></td>
                <td class="text-center">
                    <x-html.show-button :href="route('admin.customer.show',$record->id)"/>
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
