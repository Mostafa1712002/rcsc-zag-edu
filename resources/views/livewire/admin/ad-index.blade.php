<div>
    <div class="row">
        <div class="col-12 col-sm">
            <div class="form-group">
                <label for="adId">@lang('site.ad_number')</label>
                <input wire:model='ad_id' type="text" id='adId' class="form-control"/>
            </div>
        </div>

        <div class="col-12 col-sm">
            <div class="form-group">
                <label for="statusSelect">@lang('site.status')</label>
                <select wire:model='status' id="statusSelect" class="form-control">
                    <option value="">@lang('site.select_status')</option>
                    <option value="active">@lang('site.active')</option>
                    <option value="inactive">@lang('site.inactive')</option>
                </select>
            </div>
        </div>

        <div class="col-12 col-sm">
            <div class="form-group">
                <label for="adTypeSelect">@lang('validation.attributes.ad_type')</label>
                <select wire:model='ad_type' id="adTypeSelect" class="form-control">
                    <option value="0" selected>@lang('site.select_ad_type')</option>
                    <option value="demand">@lang('site.demand')</option>
                    <option value="supply">@lang('site.supply')</option>
                    <option value="rent" class="{{$current_department_id == $this->real_estate_id || $current_department_id == $this->trucks_id?'d-block': 'd-none'}}">@lang('site.rent')</option>
                    <option value="leave" class="{{$current_department_id == $this->real_estate_id || $current_department_id == $this->trucks_id?'d-block': 'd-none'}}">@lang('site.leave')</option>
{{--                    <option value="leave" class="{{$current_department_id!= $this->hardware_id?'d-block': 'd-none'}}">@lang('site.leave')</option>--}}
                </select>
            </div>
        </div>
{{--        @if()--}}
        <div class="col-2 col-sm {{$current_department_id == config('app.cars_department_id')? 'd-flex': 'd-none'}}">
            <div class="form-group">
                <label for="select5" class="form-label">@lang('validation.attributes.carsAgencies')</label>
                <select wire:model='cars_agencies_id' class="form-control" id="select1">
                    <option value='0' selected>
                        {{__('site.select_', ['var'=>__('validation.attributes.carsAgencies')])}}
                    </option>
                    @foreach($cars_agencies as $agency_id=>$agency_title)
                        <option value="{{$agency_id}}">{{$agency_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
{{--        @endif--}}
        <div class="col-12 col-sm">
            <div class="form-group">
                <label for="searchTerm">@lang('site.search_term')</label>
                <input wire:model='search_term' type="text" id='searchTerm' class="form-control"/>
            </div>
        </div>

        <div class="col-12 col-sm">
        <div class="form-group">
            <label for="customerMobile">@lang('site.customer_mobile')</label>
            <input wire:model='customer_mobile' type="text" id='customerMobile' class="form-control"/>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm">
            <div class="form-group">
                <label for="select1" class="form-label">@lang('site.app_department')</label>
                <select wire:model='department_id' class="form-control" id="select1">
                    <option value='0' selected>@lang('site.select_department')</option>
                    @foreach($departments as $department_id=>$department_title)
                        <option value="{{$department_id}}">{{$department_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-12 col-sm">
            <div class="form-group">
                    <label for="select5" class="form-label">{{$parent_category_label}}</label>
                <select wire:model='parent_category_id' class="form-control" id="select5">
                    <option value='0' selected>@lang('site.select_parent_category')</option>
                    @foreach($parent_categories as $parent_category_id=>$parent_category_title)
                        <option value="{{$parent_category_id}}">{{$parent_category_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-12 col-sm">
            <div class="form-group">
                <label for="select6" class="form-label">{{$sub_category_label}}</label>
                <select wire:model='sub_category_id' class="form-control" id="select6">
                    <option value='0' selected>@lang('site.select_sub_category')</option>
                    @foreach($sub_categories as $sub_category_id=>$sub_category_title)
                        <option value="{{$sub_category_id}}">{{$sub_category_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if($current_department_id == $this->hardware_id)
            <div class="col-md-2 mb-3">
                <label for="add-sort-device" class="form-label">@lang('general.device_status')</label>
                <select wire:model='ad_status' class="form-control" id="add-sort-device">
                    <option value="{{null}}" selected>@lang('general.device_status')</option>
                    <option value="new">{{__('general.new')}}</option>
                    <option value="used">{{__('general.used')}}</option>
                </select>
            </div>
        @endif

        @if($current_department_id == $this->cars_id)
            <div class="col-md-2 mb-3">
                <label for="add-sort-car" class="form-label">@lang('general.car_status')</label>
                <select wire:model='ad_status' class="form-control" id="add-sort-car">
                    <option value="{{null}}" selected>@lang('general.car_status')</option>
                    <option value="new">{{__('general.new')}}</option>
                    <option value="used">{{__('general.used')}}</option>
                    <option value="junk">{{__('site.junk')}}</option>
                </select>
            </div>
        @endif

        @if($current_department_id == $this->trucks_id)
            <div class="col-md-2 mb-3">
                <label for="add-sort-truck" class="form-label">@lang('validation.attributes.trucks_status')</label>
                <select wire:model='ad_status' class="form-control" id="add-sort-truck">
                    <option selected>@lang('validation.attributes.trucks_status')</option>
                    <option value="new">{{__('general.new')}}</option>
                    <option value="used">{{__('general.used')}}</option>
{{--                    <option value="junk">{{__('site.junk')}}</option>--}}
                </select>
            </div>
        @endif

        @if($current_department_id == $this->real_estate_id)
            <div class="col-md-2 mb-3">
                <label for="add-sort" class="form-label">@lang('general.district')</label>
                <input wire:model='district' type="text" class="form-control form-select-11" id="add-sort"/>
            </div>
        @else
            <div class="col-2 col-sm">
                <div class="form-group">
                    <label for="select17" class="form-label">@lang('site.admodel')</label>

                    <select wire:model='admodel_id' class="form-control" id="select17">
                        <option value='0' selected>@lang('validation.attributes.admodel_id')</option>
                        @foreach($admodels as $admodel_id=>$admodel_title)
                            <option value="{{$admodel_id}}">{{$admodel_title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif


        <div class="col-12 col-sm">
            <div class="form-group">
                <label for="select2" class="form-label">@lang('validation.attributes.region_id')</label>
                <select wire:model='region_id' class="form-control" id='select2'>
                    <option value='0' selected>@lang('site.select_region')</option>
                    @foreach($regions as $region_id=>$region_title)
                        <option value="{{$region_id}}">{{$region_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-12 col-sm">
            <div class="form-group">
                <label for="select3" class="form-label">@lang('validation.attributes.city_id')</label>
                <select wire:model='city_id' class="form-control" id="select3">
                    <option value='0' selected>@lang('site.select_city')</option>
                    @foreach($cities as $city_id=>$city_title)
                        <option value="{{$city_id}}">{{$city_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-12 col-sm">
            <div class="form-group">
                <label for="select3" class="form-label">@lang('site.deleted_ads')</label>
                <select wire:model='show_deleted' class="form-control" id="select3">
                    <option selected value='0'>@lang('site.not_deleted_ads')</option>
                    <option selected value='1'>@lang('site.deleted_ads')</option>
                </select>
            </div>
        </div>
    </div>

    @if (count($records))
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center">@lang('general.series')</th>
                    <th class="text-center">@lang('site.ad_number')</th>
                    <th class="text-center">@lang('site.date')</th>
                    <th class="text-center">@lang('site.department')</th>
                    <th class="text-center">@lang('site.type')</th>
                    <th class="text-center">@lang('site.advertiser')</th>
                    <th class="text-center">@lang('site.city')</th>
                    <th class="text-center">@lang('site.price')</th>
                    <th class="text-center">@lang('site.views')</th>
                    <th class="text-center">@lang('site.abuses_count')</th>
                    <th class="text-center">@lang('site.status')</th>
                    <th class="text-center">@lang('site.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    @php
                        $department_title = $record->department->{"title_".app()->getLocale()};
                        $city_title = $record->city->{"name_".app()->getLocale()};
                        $status = $record->deleted_at==null? 'deleted' : $record->status;
                    @endphp
                <tr>
                    <td class="text-center">{{$loop->index+1}}</td>
                    <x-html.td-center :text="$record->id"/>
                    <x-html.td-center :text="$record->created_at->format('Y-m-d')"/>
                    <x-html.td-center :text="$department_title"/>
                    <x-html.td-center :text="__('site.'.$record->ad_type)"/>
                    <x-html.td-center :text="$record->customer->full_name"/>
                    <x-html.td-center :text="$city_title"/>
                    <x-html.td-center :text="$record->price"/>
                    <x-html.td-center :text="$record->views_count"/>

                    <td class='text-center'>
                        <a href='{{route('admin.abuse.index')}}?ad_id={{$record->id}}' class='btn btn-sm btn-danger'>
                            {{$record->abuses_count}}
                        </button>
                    </td>

                    @if($record->deleted_at == null)
                        <td class="text-center"><x-html.status-badge :status="$record->status"/></td>
                    @else
                        <td class="text-center"><x-html.status-badge :status="'deleted'"/></td>
                    @endif

                    <td class="text-center">
                        <x-html.show-button :href="route('admin.ad.show',$record->id)"/>
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
