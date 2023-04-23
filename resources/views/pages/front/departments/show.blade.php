@extends('pages.front.master')
@section('content')
 <section class="search">
    <div class="container">
       <div class="row flex-sm-row-reverse-2">

            <div class="col-lg-3">
            <div class="search-at">
                <h5 class="mb-3">@lang('site.filter_results')</h5>
                <div class="search-details mt-3">
                    @livewire('filter-ads')
                </div>
            </div>

            </div>
            <div class="col-lg-9">
            <div class="search-card">
                <div class="row">
                    <form action="{{route('home')}}" class="col-lg-7 col-md-7">
                        <div class="input-group mb-3">
                            <input type="text" name='search_term' value='{{request('search_term')}}' class="form-control form-control-lg form-place-size" placeholder="@lang('site.search_for_what_you_need')"/>
                            <button type="submit" class="input-group-text btn-1">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    <div class="col-lg-2 col-md-1"> </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="d-grid gap-2">
                            <x-create-ad-button/>
                        </div>

                    </div>
                </div>
                <hr>
                <x-departments-nav :department="$department->id"/>
                <x-categories-nav :department="$department"/>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="float-end add-neww">@lang('site.latest_added')</h4>
                        <div class="buttons col-md-12 mt-3" dir="ltr">
                            <button class="btn" id="showdiv2" aria-hidden="true"> <i class="fa fa-th-large"></i></button>
                            <button class="btn" id="showdiv1"   aria-hidden="true"><i class="fa fa-th-list"></i> </button>
                        </div>

                        @if(count($records)==0)
                            <div class="row">
                                <div class="alert alert-warning">@lang('site.no_ads_available')</div>
                            </div>
                        @endif


                        <!--Product Grid-->
                        <div id="div1">
                            <section class="section-list">
                                <div class="row">
                                    @foreach ($records as $ad)
                                        <x-ad-list-item :ad="$ad"/>
                                    @endforeach
                                </div>
                            </section>

                        </div>


                        <!--Product List-->
                        <div id="div2" style="display:none;">
                            <section class="section-grid">
                                <div class="grid-prod row">
                                        @foreach ($records as  $ad)
                                            <x-ad-grid-item :ad="$ad"/>
                                        @endforeach
                                </div>
                            </section>

                        </div>
                        <div class="row text-center">
                            {{$records->links()}}
                        </div>
                    </div><!-- -->

                </div>
            </div>
        </div>
    </div>
  </div>
</section>
@endsection
