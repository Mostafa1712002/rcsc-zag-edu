<div>
    <div class="row">

        <div class="form-group">
            <label for="adId">@lang('site.ad_number')</label>
            <input wire:model='ad_id' type="text" id='adId' class="form-control"/>
        </div>




        <div class="form-group">
            <label for="searchTerm">@lang('site.search_term')</label>
            <input wire:model='search_term' type="text" id='searchTerm' class="form-control"/>
        </div>
        <div class="form-group">
            <label for="resetButton" style='color:white'>@lang('site.reset')</label>
            <button class="btn btn-danger btn-sm" id='resetButton' type='button' wire:click='resetSearch'>@lang('site.reset')</button>
        </div>

    </div>

    @if (count($records))
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center">@lang('general.series')</th>
                    <th class="text-center">@lang('site.ad_number')</th>
                    <th class="text-center">@lang('site.customer')</th>
                    <th class="text-center">@lang('site.ad_address')</th>
                    <th class="text-center">@lang('site.ad_details')</th>
                    <th class="text-center">@lang('site.abuses_count')</th>
                    <th class="text-center">@lang('site.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    @php
                        $region_name = $record->ad->region->{"name_".app()->getLocale()};
                        $city_name = $record->ad->city->{"name_".app()->getLocale()};
                        $ad_address = $region_name.' - '.$city_name;
                        $abuses_count = $record->ad->abuses()->count();
                    @endphp
                <tr>
                    <td class="text-center">{{$loop->index+1}}</td>
                    <x-html.td-center :text="$record->ad_id"/>
                    <x-html.td-center :text="$record->customer->full_name"/>
                    <x-html.td-center :text="$ad_address"/>
                    <td class='text-center'>
                        <a href="{{route('admin.ad.show',$record->ad_id)}}" class='badge bg-info'>
                            @lang('site.ad_details')
                            @if($record->ad->deleted_at)
                                <span class="badge bg-danger">@lang('site.deleted')</span>
                            @endif
                        </a>
                    </td>

                    <td class='text-center'>
                        <button type='button' wire:click="$set('ad_id',{{$record->ad_id}});" class='btn btn-sm btn-danger'>
                            {{$abuses_count}}
                        </button>
                    </td>
                    <td class="text-center">
                        <x-html.show-button :href="route('admin.abuse.show',$record->id)"/>
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
