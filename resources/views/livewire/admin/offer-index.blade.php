<div>

    @if (count($records))
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center">@lang('general.series')</th>
                        <th class="text-center">@lang('validation.attributes.picture')</th>
                        <th class="text-center">@lang('site.name')</th>
                        <th class="text-center">@lang('site.status')</th>
                        <th class="text-center">@lang('general.created_at')</th>
                        <th class="text-center">@lang('site.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                    @php
                        $offer_title = $record->{"title_".app()->getLocale()};
                    @endphp
                    <tr>
                        <td class="text-center">{{$loop->index+1}}</td>
                        <td class="text-center"><img class ='img-circle img-sm text-center' src="{{$record->pic_url}}"/></td>
                        <x-html.td-center :text="$offer_title"/>
                        <td class="text-center"><x-html.status-badge :status="$record->status"/></td>
                        <x-html.td-center :text="$record->created_at"/>
                        <td class="text-center">
                            <x-html.edit-button :href="route('admin.offer.edit',$record->id)"/>
                            <x-html.delete-button :href="route('admin.offer.delete',$record->id)"/>
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
