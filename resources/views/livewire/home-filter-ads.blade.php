<div class="row">
    <div class="input-group mb-3">

            <input
                type="text"
                wire:model.lazy='search_term'
                value='{{request('search_term')}}' class="form-control form-control-lg form-place-size" placeholder="@lang('site.search_for_what_you_need')"/>
            <button wire:click='updateSearchTerm' type="button" class="input-group-text btn-1">
                <i class="fas fa-search"></i>
            </button>
        </div>
    <hr>

    <!-- Departments nav-->
    <div class="table-responsive">
        <ul class="navbar-menu" style='display:flex;padding:0px;'>
            @foreach ($departments as $department_id=>$department_title)
                <li
                    style='
                        border: 0.5px solid rgb(238, 235, 235);
                        border-radius:5px;
                        padding:5px;
                        font-weight:normal;
                        margin:1px;'>
                    <a
                        x-data
                        x-on:click="$wire.set('form.department_id','{{$department_id}}')"
                        title='{{$department_title}}'
                        href="#"
                        style='
                            font-size:13px;
                            font-weight:normal;
                            @if($department_id==$form['department_id']) color:rgb(187,32,37); @endif
                            white-space:nowrap !important'>
                        {{ mb_strlen($department_title)>25? mb_substr($department_title,0,25).'...' : $department_title}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- End departments nav-->

    <hr/>
    @if(count($parent_categories))
        <div class="table-responsive">
            <ul class="navbar-menu" style='display:flex;padding:0px;'>
                @foreach ($parent_categories as $category_id=>$category_title)
                    <li
                        style='
                            border: 0.5px solid rgb(238, 235, 235);
                            border-radius:5px;
                            padding:5px;
                            float:right;
                            text-align:center;
                            margin:1px;'>
                        <a
                            x-data
                            x-on:click="$wire.set('form.parent_category_id','{{$category_id}}')"
                            href="#"
                            style='
                                font-size:13px;
                                font-weight:normal;
                                @if($category_id==$form['parent_category_id']) color:rgb(187,32,37); @endif white-space:nowrap !important'>
                            {{$category_title}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <hr/>
    @if(count($sub_categories))
        <div class="table-responsive">
            <ul class="navbar-menu" style='display:flex;padding:0px;display:inline;margin-botton:10px;'>
                @foreach ($sub_categories as $category_id=>$category_title)
                    <li
                        style='
                            border: 0.5px solid rgb(238, 235, 235);
                            border-radius:5px;
                            padding:5px;

                            float:right;
                            text-align:center;
                            margin:1px;'>
                        <a
                            x-data
                            x-on:click="$wire.set('form.sub_category_id','{{$category_id}}')"
                            href="#"
                            style='
                                font-size:13px;
                                font-weight:normal;

                                @if($category_id==$form['sub_category_id']) color:rgb(187,32,37); @endif white-space:nowrap !important'>
                            {{$category_title}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
{{--    <hr>--}}

    <div class="row">
        <!-- Ad type-->
        <div class="form-group col-md-4 col-6">
            <select wire:model='form.ad_type' class='form-control'>
                <option value='0'>@lang('validation.attributes.ad_type')</option>
                <option value="supply">@lang('site.supply')</option>
                <option value="demand">@lang('site.demand')</option>

                @if($this->form['department_id'] != config('app.hardWare_department_id'))
                    <option value="leave">@lang('site.leave')</option>
                @endif

                @if($this->form['department_id'] == config('app.real_state_department_id')
                    || $this->form['department_id'] == config('app.trucks_department_id'))
                    <option value="rent">@lang('site.rent')</option>
                @endif

            </select>
        </div>

        <!-- Region-->
        <div class="form-group col-md-4 col-6">
            <select wire:model='form.region_id' class='form-control'>
                <option value>@lang('site.select_region')</option>
                @foreach ($regions as $region_id=>$region_name)
                    <option value="{{$region_id}}">{{$region_name}}</option>
                @endforeach
            </select>
        </div>


        @if($cities)
            <div class="form-group col-md-4 col-6">
                <select wire:model='form.city_id' class='form-control'>
                    <option value>@lang('site.select_city')</option>
                    @foreach ($cities as $city_id=>$city_name)
                        <option value="{{$city_id}}">{{$city_name}}</option>
                    @endforeach
                </select>
            </div>
        @endif

        @if($admodels)
            <div class="form-group col-md-4 col-6">
                <select wire:model='form.admodel_id' class='form-control'>
                    <option value>@lang('site.select_admodel')</option>
                    @foreach ($admodels as $admodel_id=>$admodel_name)
                        <option value="{{$admodel_id}}">{{$admodel_name}}</option>
                    @endforeach
                </select>
            </div>
        @endif

{{--        @isset($this->form['department_id'])--}}
            @if($this->form['department_id']&& in_array($this->form['department_id'], config('app.with_status')))
                <div class="form-group col-md-4 col-6 ">
                    <select wire:model='form.ad_status' class='form-control'>
                        @if($this->form['department_id'] == config('app.cars_department_id'))
                            <option selected>@lang('general.car_status')</option>
                        @elseif($this->form['department_id'] == config('app.trucks_department_id'))
                            <option selected>@lang('validation.attributes.trucks_status')</option>
                        @elseif($this->form['department_id'] == config('app.hardWare_department_id'))
                            <option selected>@lang('general.device_status')</option>
                        @endif
                        <option value="new">{{__('general.new')}}</option>
                        <option value="used">{{__('general.used')}}</option>
                            @if($this->form['department_id'] == config('app.cars_department_id'))
                                <option value="junk">{{__('validation.attributes.junk')}}</option>
                            @endif
                    </select>
                </div>

            @endif
            <div class="form-group col-md-4 col-6">

            </div>
{{--        @endisset--}}

        <!-- Follow filter -->
        <div class="col-md-4 col-12">
            @auth('customer')
                <input wire:model='follow_filter' wire:click='followFilter' class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    @lang('site.inform_me_with_future_results')
                </label>
            @endauth
        </div>
    </div>


    <div class="col-md-12">
        <h4 class="float-end add-neww">@lang('site.latest_added')</h4>
        <div class="buttons col-md-12 mt-3" dir="ltr">
            <button class="btn" id="showdiv2" aria-hidden="true"> <i class="fa fa-th-large"></i></button>
            <button class="btn" id="showdiv1"   aria-hidden="true"><i class="fa fa-th-list"></i> </button>
        </div>

        @if(count($latest_ads)==0)
            <div class="row">
                <div class="alert alert-warning">@lang('site.no_ads_available')</div>
            </div>
        @endif
        <!--Product Grid-->
        <div id="div1">
            <section class="section-list">
                <div class="row">
                    @foreach ($latest_ads as $ad)
                        <x-ad-list-item :ad="$ad"/>
                    @endforeach
                </div>
                {{$latest_ads->links()}}
            </section>

        </div>


        <!--Product List-->
        <div id="div2" style="display:none;">
            <section class="section-grid">
                <div class="grid-prod row">
                        @foreach ($latest_ads as  $ad)
                            <x-ad-grid-item :ad="$ad"/>
                        @endforeach
                </div>
            </section>
            {{$latest_ads->links()}}
        </div>
    </div>

</div>

